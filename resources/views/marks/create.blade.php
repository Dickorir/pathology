@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Zain Exam
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->
    <link rel="stylesheet" href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.min.css') }}">

@stop
{{-- Page content --}}
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <!-- <h2>Static Tables</h2> -->
            <h2></h2>

            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item">
                    <a>Tables</a>
                </li> -->

                <li class="breadcrumb-item active">
                    <strong>Student</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-8 col-sm-offset-2">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Enter Index Number to Add/Edit Marks </h5>
                    </div>
                    <div class="ibox-content">

                        <form class="m-t" role="form"  method="POST" action="{{ route('student.select') }}">
                            @csrf
                            <div class="form-group">
                                <label>Index No | Exam Center</label>
                                <div>
                                    <select data-placeholder="Choose a Student..." class="chosen-select"  tabindex="2" name="student_index_no" onchange="this.submit.form()">
                                        @foreach($students as $student)
                                            <option value="{{ $student->index_no }}" {{ $student->index_no == $student->index_no ? 'selected' : '' }}>{{ $student->index_no.'|'.$student->school->school_name.'-'.$student->school->school_code }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs mt-2" type="submit"><strong>Go!</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($request->student_index_no)
            <div class="row">
                <div class="col-8 col-sm-offset-2">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>{{ $stude->marks != null ? 'Edit ' : 'Create New ' }}Marks for {{ $stude->index_no.' | '.$stude->school->school_name.' from '.$stude->school_code }} </h5>
                        </div>
                        <div class="ibox-content">

                            <form class="m-t" role="form"  method="POST" action="{{ route('mark.store') }}">
                                @csrf
                                <input type="hidden" name="index_no" value="{{ $request->student_index_no ?? '' }}" >
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <td>Subject</td>
                                        <th>Score</th>
                                        <th>Grade</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <th>Math</th>
                                        <td><input type="text" name="math" value="{{ old('email', $stude->marks->math ?? '') }}" class="form-control"></td>
                                        <td><input type="text" name="math_grade" value="{{ old('email', $stude->marks->math_grade ?? '') }}" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <th>English</th>
                                        <td><input type="text" name="eng" value="{{ old('math', $stude->marks->eng ?? '') }}" class="form-control"></td>
                                        <td><input type="text" name="eng_grade" value="{{ old('math_grade', $stude->marks->eng_grade ?? '') }}" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <th>Kiswahili</th>
                                        <td><input type="text" name="kiswa" value="{{ old('eng', $stude->marks->kiswa ?? '') }}" class="form-control"></td>
                                        <td><input type="text" name="kiswa_grade" value="{{ old('eng_grade', $stude->marks->kiswa_grade ?? '') }}" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <th>Science</th>
                                        <td><input type="text" name="sci" value="{{ old('kiswa', $stude->marks->sci ?? '') }}" class="form-control"></td>
                                        <td><input type="text" name="sci_grade" value="{{ old('kiswa_grade', $stude->marks->sci_grade ?? '') }}" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <th>Social Studies</th>
                                        <td><input type="text" name="soc_stud" value="{{ old('sci', $stude->marks->soc_stud ?? '') }}" class="form-control"></td>
                                        <td><input type="text" name="soc_stud_grade" value="{{ old('sci_grade', $stude->marks->soc_stud_grade ?? '') }}" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <th>Total</th>
                                        <td><input type="text" name="tot_score" value="{{ old('soc_stud', $stude->marks->tot_score ?? '') }}" class="form-control"></td>
                                        <td><input type="text" name="tot_grade" value="{{ old('soc_stud_grade', $stude->marks->tot_grade ?? '') }}" class="form-control"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button type="submit" name="submit" value="{{ $stude->marks != null ? 'update' : 'create' }}" class="btn btn-primary m-b float-right">{{ $stude->marks != null ? 'Update ' : 'Create ' }}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

{{-- page level scripts --}}

@section('footer_scripts')
    <!-- put scripts gera -->

    <!-- Select2 -->

    <!-- Chosen -->
    <script type="text/javascript" src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('.chosen-select').chosen({width: "100%"});

        });
    </script>
@stop
