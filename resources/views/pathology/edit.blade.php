@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update Cancer Record
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->
    <link rel="stylesheet" href="{{ asset('css/plugins/steps/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}">

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
                    <strong>Update Cancer Record</strong>
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
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <form class="m-t" role="form"  method="POST" action="{{ route('cancerRecord.update', $pathology->id) }}"  enctype="multipart/form-data">
                            @csrf
                            <div id="wizard">

                                <h1>Patient Details</h1>

                                <div class="step-content">

                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Patient Details</h3>

                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input name="name" required type="text" value="{{ old('name', $pathology->patient->name) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Age <span class="text-danger">*</span></label>
                                                <input name="age" required type="text" value="{{ old('age', $pathology->patient->age) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select name="gender" id="gender" class="form-control m-b required">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" @if($pathology->gender === 'Male') selected="selected" @endif >Male</option>
                                                    <option value="Female" @if($pathology->gender === 'Female') selected="selected" @endif >Female</option>
                                                    <option value="Other" @if($pathology->gender === 'Other') selected="selected" @endif >Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input name="tel" type="text" value="{{ old('tel', $pathology->patient->tel) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control" >{{ old('address', $pathology->patient->address) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h3 class="m-t-none m-b"><br></h3>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" type="email" value="{{ old('email', $pathology->patient->email) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>ID Number</label>
                                                <input name="id_no" type="text" value="{{ old('id_no', $pathology->patient->id_no) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Village</label>
                                                <input name="village" type="text" value="{{ old('village', $pathology->patient->village) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input name="location" type="text" value="{{ old('location', $pathology->patient->location) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>District</label>
                                                <input name="district" type="text" value="{{ old('district', $pathology->patient->district) }}" class="form-control">
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
                                                <input name="hospital" type="text" value="{{ old('hospital', $pathology->hospital) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Doctor name</label>
                                                <input name="doctor_name" type="text" value="{{ old('doctor_name', $pathology->doctor_name) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Request Form Name <span class="text-danger">*</span></label>
                                                <input name="request_form_name" required type="text" value="{{ old('request_form_name', $pathology->request_form_name) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Form Number </label>
                                                <input name="form_number" type="text" value="{{ old('form_number', $pathology->form_number) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h3 class="m-t-none m-b"><br></h3>

                                            <div class="form-group">
                                                <label>Year<span class="text-danger">*</span></label>
                                                <input required name="date" type="text" class="form-control" value="{{ old('date', Carbon\Carbon::parse($pathology->date)->format('d/m/Y')) }}" data-mask="99/99/9999" autocomplete="off">
                                                <span class="form-text">dd/mm/yyyy</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Type of test<span class="text-danger">*</span></label>
                                                <input name="type_of_test" required type="text" value="{{ old('type_of_test', $pathology->type_of_test) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Specimen<span class="text-danger">*</span></label>
                                                <input name="specimen" required type="text" value="{{ old('specimen', $pathology->specimen) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Form Upload <span class="text-danger">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo1" name="request_form_upload" onchange="document.getElementById('fronts').src = window.URL.createObjectURL(this.files[0]);$('#drop').hide();$('#onas').show();">
                                                    <label for="logo1" class="custom-file-label">Choose file...</label>
                                                </div>
                                                <span id="onas" style="" ><img src="{{ asset('uploads/request_form_uploads/'.$pathology->request_form_upload) }}" id="fronts" alt="fronts image" class="img-responsive" style="max-height:200px;min-height:200px"/></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h1>Report</h1>
                                <div class="step-content" style="overflow-x: auto">
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
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
                                                <input name="cancer_type" type="text" value="{{ old('cancer_type', $pathology->cancer_type) }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Cancer Stage</label>
                                                <select class="form-control m-b" name="cancer_stage">
                                                    <option value="">Select Stage</option>
                                                    <option value="1" @if($pathology->cancer_stage === '1') selected="selected" @endif>stage 1</option>
                                                    <option value="2" @if($pathology->cancer_stage === '2') selected="selected" @endif>stage 2</option>
                                                    <option value="3" @if($pathology->cancer_stage === '3') selected="selected" @endif>stage 3</option>
                                                    <option value="4" @if($pathology->cancer_stage === '4') selected="selected" @endif>stage 4</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Report Upload <span class="text-danger">*</span></label>
                                                <span id="ona" style="" ><img id="front" alt="front image" src="{{ asset('uploads/request_form_uploads/'.$pathology->request_form_upload) }}" class="img-responsive" style="max-height:200px;min-height:200px"/></span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo" name="report_upload" onchange="document.getElementById('front').src = window.URL.createObjectURL(this.files[0]);$('#drop').hide();$('#ona').show();">
                                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">

                                            <div class="form-group">
                                                <button type="submit" class="float-right btn  btn-info">Update</button>

                                            </div>
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

    <!-- SUMMERNOTE -->
    <script src="{{ asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
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
        $(document).ready(function() {
            //initialize summernote
            $('.summernote-notes').summernote();
            //assign the variable passed from controller to a JavaScript variable.
            var content = {!! json_encode($pathology->clinical_history_notes) !!};
            //set the content to summernote using `code` attribute.
            $('.summernote-notes').summernote('code', content);
        });
        $(document).ready(function() {
            //initialize summernote
            $('.summernote-report').summernote();
            //assign the variable passed from controller to a JavaScript variable.
            var content = {!! json_encode($pathology->report) !!};
            //set the content to summernote using `code` attribute.
            $('.summernote-report').summernote('code', content);
        });
    </script>

@stop
