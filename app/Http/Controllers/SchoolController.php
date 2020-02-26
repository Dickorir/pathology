<?php

namespace App\Http\Controllers;

use App\Imports\SchoolsImport;
use App\School;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SchoolController extends Controller
{
    public function index()
    {
//        $generate = factory(School::class,30)->create();
        $schools = School::orderBy('created_at')->paginate(10);
        $schoolscount = School::orderBy('created_at')->count();
//        dd($schools);
        return view('schools.index', compact('schools','schoolscount'));
    }

    public function create()
    {
        return view('schools.create');
    }

    protected function create_school(array $data)
    {
//        dd($data);
        return School::create([
            'school_code' => $data['school_code'],
            'school_name' => $data['school_name'],
        ]);
    }

    public function store(Request $request)
    {
//        dd($request);
        $this->validator_school($request->all())->validate();

        event(new Registered($user = $this->create_school($request->all())));

        if ($user->id) {
            return redirect('schools')->with('success', trans('School created'));
        } else {
            return redirect('schools')->withInput()->with('error', trans('School not created'));
        }

    }

    protected function validator_school(array $data)
    {
        return Validator::make($data, [
            'school_code' => ['required','string','max:255', 'unique:schools'],
            'school_name' => ['required','string','max:255'],
        ]);
    }
    public function edit($index_no)
    {
        $school = School::where('school_code',$index_no)->first();
//        dd($school);
        return view('schools.edit', compact('school'));
    }
    public function update(Request $request, $index_no)
    {
        $school = School::where('school_code', $index_no)->first();
//        dd($school);
        $school->update($request->all());
//        dd($admin);
        if ($school->id) {
            return redirect('schools')->with('success', trans('School updated'));
        } else {
            return redirect('schools')->withInput()->with('error', trans('School not updated'));
        }
    }
    public function import()
    {
        return view('schools.import_schools');
    }

    public function template()
    {
        return response()->download(base_path('resources/excel-templates/schools.csv'));
//        return Excel::download(new MembersExport, 'users.xlsx');
    }
    public function importdata()
    {
//        dd(request()->all());
        Excel::import(new SchoolsImport,request()->file('import_file'));

        return back()->with('success', 'All good!');
    }

}
