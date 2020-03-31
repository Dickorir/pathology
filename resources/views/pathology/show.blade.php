@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Cancer Records
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->

    <!-- Toastr style -->
    <link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <style>

        input[type=checkbox] {
            display: none;
        }

        .report_form img {
            margin-left: 100px;
            transition: transform 0.25s ease;
            cursor: zoom-in;
        }
        .request_form img {
            margin-left: 100px;
            transition: transform 0.25s ease;
            cursor: zoom-in;
        }

        input[name=form_req]:checked ~ label > img {
            transform: scale(2.1);
            cursor: zoom-out;
        }

        input[name=form_rep]:checked ~ label > img {
            transform: scale(2.1);
            cursor: zoom-out;
        }
    </style>
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
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Cancer Record</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>show</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox product-detail">
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-5">

                                <div class="ibox-content no-padding border-left-right request_form ">
                                    <span>Request form</span><br>
                                    <input type="checkbox" id="zoomCheck" name="form_req">
                                    <label for="zoomCheck">
                                        <img src="{{ asset('uploads/request_form_uploads/'.$pathology->request_form_upload) }}" alt="Upload form" style="width: 200px;">
                                    </label>
                                </div>

                                <div class="ibox-content no-padding border-left-right report_form">
                                    <span class="">Report form</span><br>
                                    <input type="checkbox" id="zoomCheck2" name="form_rep">
                                    <label for="zoomCheck2">
                                        <img src="{{ asset('uploads/report_uploads/'.$pathology->report_upload) }}" alt="Upload form" style="width: 200px;">
                                    </label>
                                </div>

                            </div>
                            <div class="col-md-7">

                                <h2 class="font-bold m-b-xs">
                                    Cancer Record Info
                                    {{--                                    {{ $pathology->patient->name }}--}}
                                </h2>
                                <hr>

                                <dl class="m-t-md">
                                    <dt>Type of Test</dt>
                                    <dd> {{ $pathology->type_of_test ?? 'None' }}</dd>
                                    <dt>Specimen</dt>
                                    <dd> {{ $pathology->specimen ?? 'None' }}</dd>
                                    <dt>Cancer Type</dt>
                                    <dd> {{ $pathology->cancer_type ?? 'None' }}</dd>
                                    <dt>Cancer Stage</dt>
                                    <dd> {{ $pathology->cancer_stage ?? 'None' }}</dd>
                                    <dt>Request Form Name</dt>
                                    <dd> {{ $pathology->request_form_name ?? 'None' }}</dd>
                                    <dt>Lab Number</dt>
                                    <dd> {{ $pathology->form_number ?? 'None' }}</dd>
                                    <dt>Date</dt>
                                    <dd> {{ $pathology->date ?? 'None' }}</dd>
                                    <dt>Clinical history/notes</dt>
                                    <dd> {!! $pathology->clinical_history_notes ?? 'None' !!}</dd>
                                    <dt>Hospital</dt>
                                    <dd> {{ $pathology->hospital ?? 'None' }}</dd>

                                    <dt>Patient name</dt>
                                    <dd> {{ $pathology->patient->name ?? 'None' }}</dd>

                                    <dt>Patient age</dt>
                                    <dd> {{ $pathology->patient->age ?? 'None' }}</dd>

                                    <dt>Patient gender</dt>
                                    <dd> {{ $pathology->patient->gender ?? 'None' }}</dd>

                                    <dt>Doctor_name</dt>
                                    <dd> {{ $pathology->doctor_name ?? 'None' }}</dd>
                                </dl>
                                <hr>

                                <dt>report</dt>
                                <dd> {!! $pathology->report ?? 'None' !!} </dd>




                            </div>
                        </div>

                    </div>
                    <div class="ibox-footer">
                            <span class="float-right">
                                {{ date('D-d-M-Y') }}
                            </span>
                        Cancer Records Centre
                    </div>
                </div>

            </div>
        </div>




    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- put scripts gera -->
    <script src="/js/plugins/toastr/toastr.min.js"></script>
    <!-- Sweet alert -->
    <script src="/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $(".toa").click(function(event){
                event.preventDefault();
                //Save the link in a variable called element
                var element = $(this);
                //Find the id of the link that was clicked
                var id = element.attr("id");

                swal({
                        title: "Are you sure to delete this Admin?",
                        text: "You will not be able to recover this data!",
                        type: "warning",
                        showCancelButton: true,
                        // confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        confirmButtonColor: "#DD6B55",
                        cancelButtonColor: '#d33',
                        closeOnConfirm: false
                    },

                    function() {
                        $.ajax({
                            type: "GET",
                            url: "/student/"+id+"/delete",
                            data: id,
                            success:function (data) {
                                swal({
                                    title: 'Deleted!',
                                    text: 'Admin deleted',
                                    type: 'success',
                                    showConfirmButton: true
                                });

                                element.parent().parent().fadeOut('slow', function() {$(this).remove();});
                            },
                            error:function (data) {
                                swal({
                                    title: 'Failed',
                                    text: data.error,
                                    type: 'error',
//                      timer: 1000,
                                    confirmButtonText: 'Ok'
                                });
                            }
                        })
                    });

            });
        });
    </script>
@stop
