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
                        <h5>{{ $stude == null ? 'Create New ' : 'Edit ' }}Student</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="m-t" role="form"  method="POST" action="{{ route('student.store') }}">
                            @csrf
                            <div class="form-group">
                                <input id="index_no" type="text" class="form-control @error('index_no') is-invalid @enderror" name="index_no" value="{{ old('index_no', $stude->index_no ?? '') }}" required autocomplete="index_no" placeholder="Index No" autofocus>

                                @error('index_no')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $stude->first_name ?? '') }}" required autocomplete="first_name" placeholder="First Name" autofocus>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="other_names" type="text" class="form-control @error('other_names') is-invalid @enderror" name="other_names" value="{{ old('other_names', $stude->other_names ?? '') }}" required autocomplete="other_names" placeholder="Other Names" autofocus>

                                @error('other_names')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                @php $schools = \App\School::all(); @endphp
                                <label>School</label>
                                <select data-placeholder="Choose a Student..." class="chosen-select"  tabindex="2" name="school_code">
                                @foreach($schools as $school)
                                        <option value="{{ $school->school_code }}" {{ $stude != null ? ($school->school_code == $stude->school->school_code ? 'selected' : '') : '' }}>{{ $school->school_code.'|'.$school->school_name }}</option>
                                    @endforeach
                                </select>
                                @error('school_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" name="submit" value="{{ $stude == null ? 'Create' : 'Update' }}" class="btn btn-primary m-b">{{ $stude == null ? 'Create' : 'Update ' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}

@section('footer_scripts')
    <!-- put scripts gera -->
    <script type="text/javascript" src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.chosen-select').chosen({width: "100%"});
        });
    </script>
@stop
