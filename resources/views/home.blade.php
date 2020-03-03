@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Knh Pathology
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->
@stop
{{-- Page content --}}
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-success float-right">Patients</span>
                        <h5>Patients</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"></h1>
                        <small>Total</small>
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
