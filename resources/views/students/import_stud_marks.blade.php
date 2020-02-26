@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Zain Exam
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->
    <link rel="stylesheet" href="{{ asset('css/import_data.css')}}">
@stop
{{-- Page content --}}
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="card-title float-left my-2">Upload Student Marks</h5>
                        <a href="{{ url('student/template') }}"><button class="btn btn-success float-right">Download</button></a>
                    </div>


                    <div class="card-body">
                        <form method="POST" action="{{ URL('student/import_template') }}"  files="true" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="import_file" required/>

                            <button class="btn btn-primary import btn-block mt-3" type="submit">Upload File</button>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body text-danger">
                        <h5> NB: </h5>
                        <ul>
                            <li>Download the template for guide on how to make you csv file</li>
                            <li>Ensure that the system have all the required</li>
                            <li>Make sure all the columns are similar to the template you downloaded</li>
                            <li>Ensure that all columns match to avoid errors</li>
                            <li class="text-danger">Before you Import Members, ensure that all columns are filled</li>
                        </ul>
                        <p> </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- put scripts gera -->
@stop
