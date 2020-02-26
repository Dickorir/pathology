<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
//        $generate = factory(Student::class,30)->create();
        $students = Student::orderBy('created_at')->paginate(10);
        $studentscount = Student::orderBy('created_at')->count();
//        dd($students);
        return view('students.index', compact('students','studentscount'));
    }

    public function create(Request $request)
    {
//        dd($request);
        if ($request)
            $stude = \App\Student::with(['school'])->where('index_no',$request->student_index_no)->first();
//        dd($stude);
        return view('students.create',compact('stude'));
    }

    protected function create_student(array $data)
    {
//        dd($data);
        return Student::create([
            'index_no' => $data['index_no'],
            'first_name' => $data['first_name'],
            'other_names' => $data['other_names'],
            'school_code' => $data['school_code'],
        ]);
    }

    public function store(Request $request)
    {
        if ($request->submit == 'Update'){
            return $this->update($request);
        }
//        dd($request);
        $this->validator_student($request->all())->validate();

        event(new Registered($user = $this->create_student($request->all())));

        if ($user->id) {
            return redirect('students')->with('success', trans('Student created'));
        } else {
            return redirect('students')->withInput()->with('error', trans('Student not created'));
        }

    }

    protected function validator_student(array $data)
    {
        return Validator::make($data, [
            'index_no' => ['required','string','max:255', 'unique:students'],
            'first_name' => ['required','string','max:255'],
            'other_names' => ['required','string','max:255'],
            'school_code' => ['required','string','max:255'],
        ]);
    }

    public function import()
    {
        return view('students.import_stud_marks');
    }

    public function template()
    {
        return response()->download(base_path('resources/excel-templates/student_marks.csv'));
//        return Excel::download(new MembersExport, 'users.xlsx');
    }

    public function update(Request $request, $id=0)
    {
        $student = Student::where('index_no', $request->index_no)->first();
//        dd($student,9);
        $student->update($request->all());
//        dd($admin);
        if ($student->id) {
            return redirect('students')->with('success', trans('Students updated'));
        } else {
            return redirect('students')->withInput()->with('error', trans('Students not updated'));
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
