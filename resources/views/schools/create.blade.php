@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Create Pathology
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->
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
                    <strong>School</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-8 col-sm-offset-2">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Create New School</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="m-t" role="form"  method="POST" action="{{ route('school.store') }}">
                            @csrf
                            <div class="form-group">
                                <input id="school_code" type="text" class="form-control @error('school_code') is-invalid @enderror" name="school_code" value="{{ old('school_code') }}" required autocomplete="school_code" placeholder="school_code">

                                @error('school_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="school_name" type="text" class="form-control @error('school_name') is-invalid @enderror" name="school_name" value="{{ old('school_name') }}" required autocomplete="school_name" placeholder="School">

                                @error('school_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary m-b">Submit</button>
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
@stop
