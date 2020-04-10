@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Create Cancer Record
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->
    <link rel="stylesheet" href="{{ asset('css/plugins/steps/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/plugins/datapicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}">

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
                    <strong>Create new Cancer Record</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">

                    <div class="ibox-title">
                        <h5>Details Form</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <form class="m-t" role="form"  method="POST" action="{{ route('cancerRecord.store') }}"  enctype="multipart/form-data">
                            @csrf
                            <div id="wizard">

                                <h1>Patient Details</h1>

                                <div class="step-content">

                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Patient Details</h3>

                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input name="name" required type="text" placeholder="Name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Age <span class="text-danger">*</span></label>
                                                <input name="age" required type="number" placeholder="Age" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control m-b" name="gender">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input name="tel" type="text" placeholder="Phone number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h3 class="m-t-none m-b"><br></h3>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" type="email" placeholder="Email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>ID Number</label>
                                                <input name="id_no" type="text" placeholder="ID Number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Village</label>
                                                <input name="village" type="text" placeholder="village" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input name="location" type="text" placeholder="Location" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>District</label>
                                                <input name="district" type="text" placeholder="District" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h1>Test Details</h1>
                                <div class="step-content" style="overflow-x: auto">
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Test Details</h3>

                                            <div class="form-group">
                                                <label>Hospital <span class="text-danger">*</span></label>
                                                <input name="hospital" type="text" placeholder="Hospital" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Doctor name</label>
                                                <input name="doctor_name" type="text" placeholder="Doctor name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Request Form Name <span class="text-danger">*</span></label>
                                                <input name="request_form_name" required type="text" placeholder="Form Name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Lab Number </label>
                                                <input name="form_number" type="text" placeholder="Lab Number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h3 class="m-t-none m-b"><br></h3>

                                            <div class="form-group">
                                                <label>Year<span class="text-danger">*</span></label>
                                                <input required name="date" type="text" class="form-control" data-mask="99/99/9999" autocomplete="off">
                                                <span class="form-text">dd/mm/yyyy</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Type of test<span class="text-danger">*</span></label>
                                                <input name="type_of_test" required type="text" placeholder="Type of test" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Specimen<span class="text-danger">*</span></label>
                                                <input name="specimen" required type="text" placeholder="specimen" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Form Upload <span class="text-danger">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo1" name="request_form_upload" onchange="document.getElementById('fronts').src = window.URL.createObjectURL(this.files[0]);$('#drop').hide();$('#onas').show();">
                                                    <label for="logo1" class="custom-file-label">Choose file...</label>
                                                </div>
                                                <span id="onas" style="display: none" ><img id="fronts" alt="fronts image" class="img-responsive" style="max-height:200px;min-height:200px"/></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h1>Report</h1>
                                <div class="step-content" style="overflow-x: auto">
                                    <div class="row">
                                        <div class="col-sm-6 b-r" style="display: none">
                                                <div class="form-group">
                                                    <label>clinical_history_notes</label>
                                                    <textarea name="clinical_history_notes" class="form-control summernote-notes" placeholder="clinical_history_notes">x</textarea>

                                                </div>
                                                <div class="form-group">
                                                    <label>Report</label>
                                                    <textarea name="report" class="form-control summernote-report" placeholder="Report">x</textarea>
                                                </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Cancer Type <span class="text-danger">*</span></label>
                                                <input name="cancer_type" type="text" placeholder="Cancer Type" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Cancer Stage</label>
                                                <select class="form-control m-b" name="cancer_stage">
                                                    <option value="1">stage 1</option>
                                                    <option value="2">stage 2</option>
                                                    <option value="3">stage 3</option>
                                                    <option value="4">stage 4</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Report Upload <span class="text-danger">*</span></label>
                                                <span id="ona" style="display: none" ><img id="front" alt="front image" class="img-responsive" style="max-height:200px;min-height:200px"/></span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo" name="report_upload" onchange="document.getElementById('front').src = window.URL.createObjectURL(this.files[0]);$('#drop').hide();$('#ona').show();">
                                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="float-right btn btn-success">Submit</button>

                                            </div>

                                        </div>
                                        <div class="col-sm-6">

                                        </div>
                                    </div>

                                </div>
                            </div>
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
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

    <!-- Input Mask-->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

    <!-- Date range picker -->
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- SUMMERNOTE -->
    <script src="{{ asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
    <script>
        var mem = $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                errorPlacement: function (error, element)
                {
                    element.before(error);
                },
                rules: {
                    confirm: {
                        equalTo: "#password"
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.summernote').summernote();

            $('.summernote-notes').summernote();
            $('.summernote-report').summernote();

        });

        // function loadlink(){
        //     $('.summernote-notes').summernote();
        //     $('.summernote-report').summernote();
        // }
        //
        // loadlink(); // This will run on page load
        // setInterval(function(){
        //     loadlink() // this will run after every 5 seconds
        // }, 5000);
    </script>

@stop
