<?php

namespace App\Http\Controllers;

use App\Marks;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentMarksController extends Controller
{
    public function index()
    {
//        $generate = factory(Student::class,30)->create();
        $marks = Marks::orderBy('created_at')->paginate(10);
//        dd($students);
        return view('marks.index', compact('marks'));
    }

    public function create(Request $request)
    {
//        dd($request);
        $students = \App\Student::with(['school'])->get();
        if ($request)
        $stude = \App\Student::with(['marks'])->where('index_no',$request->student_index_no)->first();
//        dd($stude);

        return view('marks.create', compact('request','stude', 'students'));
    }

    protected function create_marks(array $data)
    {
//        dd($data);
        return Marks::create([
            'index_no' => $data['index_no'],
            'math' => $data['math'],
            'math_grade' => $data['math_grade'],
            'eng' => $data['eng'],
            'eng_grade' => $data['eng_grade'],
            'kiswa' => $data['kiswa'],
            'kiswa_grade' => $data['kiswa_grade'],
            'sci' => $data['sci'],
            'sci_grade' => $data['sci_grade'],
            'soc_stud' => $data['soc_stud'],
            'soc_stud_grade' => $data['soc_stud_grade'],
            'tot_score' => $data['tot_score'],
            'tot_grade' => $data['tot_grade'],
        ]);
    }

    public function store(Request $request)
    {
        if ($request->submit == 'update'){
            return $this->update($request);
        }
//        dd($request);
        $this->validator_marks($request->all())->validate();

        event(new Registered($user = $this->create_marks($request->all())));

        if ($user->id) {
            return redirect('marks')->with('success', trans('Marks created'));
        } else {
            return redirect('marks')->withInput()->with('error', trans('Marks not created'));
        }

    }

    protected function validator_marks(array $data)
    {
        return Validator::make($data, [
            'index_no' => ['required','string','max:30'],
            'math' => ['required','max:3'],
            'math_grade' => ['required','string','max:10'],
            'eng' => ['required','max:3'],
            'eng_grade' => ['required','string','max:10'],
            'kiswa' => ['required','max:3'],
            'kiswa_grade' => ['required','string','max:10'],
            'sci' => ['required','max:3'],
            'sci_grade' => ['required','string','max:10'],
            'soc_stud' => ['required','max:3'],
            'soc_stud_grade' => ['required','string','max:10'],
            'tot_score' => ['required','max:3'],
            'tot_grade' => ['required','string','max:10'],
        ]);
    }


    public function update(Request $request, $id=0)
    {
        $this->validator_marks($request->all())->validate();

        $mark = Marks::where('index_no', $request->index_no)->first();
//        dd($mark, 90);

//        dd($request);
        $mark->update($request->all());
//        dd($admin);
        if ($mark->id) {
            return redirect('marks')->with('success', trans('Marks updated'));
        } else {
            return redirect('marks')->withInput()->with('error', trans('Marks not updated'));
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
