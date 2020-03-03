<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'tel' => 'required|max:255|unique:users',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'tel' => 'required|max:255|unique:users,tel,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }


    public function getlogin()
    {
        return view('auth.getotp');
    }

    public function sendSms($otp, $uname)
    {

        // $username = 'sandbox'; // use 'sandbox' for development in the test environment
        // $apiKey   = '03a775b072b9a1e23b88810b371dc60b7c34f8d5e2df61ef8eff43079089def5'; // use your sandbox app API key for development in the test environment
        // $AT       = new AfricasTalking($username, $apiKey);

        $username = 'Dickilla'; // use 'sandbox' for development in the test environment
        $apiKey   = '068c0e4c47593753aa837c0162125fc7c17114301f8e247d93d9866020b298f4'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

// Get one of the services
        $sms      = $AT->sms();

// Use the service
        $result   = $sms->send([
            'to'      => $uname,
            'message' => 'Your OTP for KNH Pathology: '.$otp
        ]);
        return true;
    }

    public function get_otp(Request $request)
    {
        $this->validateOtp($request);

        $username = User::where('tel', '=', $request->username)
            ->orWhere('email', '=', $request->username)
            ->first();

        if(is_null($username)){
            return redirect()->back()->with('error', ' '.$request->username.' is not registered!');
        }

        $num = rand(1000, 9999);

        $uname = $request->username;
        if ( $this->checkEmail($uname) ) {
            dd('send email');
        }else{
            $this->sendSms($num, $uname);
        }
//        dd('laa');
        // update password for this user
        User::find($username->id)->update(['password' => Hash::make($num),]);

        return redirect('login')->with('success', trans('OTP sent. Please check You Email/Phone'));
    }

    function checkEmail($email) {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }


    protected function validateOtp(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
        ]);
    }

    public function username()
    {
        return 'username';
    }


}
