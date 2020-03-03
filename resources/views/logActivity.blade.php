@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Create Pathology
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
                    <strong>Create new Pathology</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="container">
            <h1>Log Activity Lists</h1>
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Subject</th>
                    <th>URL</th>
                    <th>Method</th>
                    <th>Ip</th>
                    <th width="300px">User Agent</th>
                    <th>User Id</th>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
                @if($logs->count())
                    @foreach($logs as $key => $log)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $log->subject }}</td>
                            <td class="text-success">{{ $log->url }}</td>
                            <td><label class="label label-info">{{ $log->method }}</label></td>
                            <td class="text-warning">{{ $log->ip }}</td>
                            <td class="text-danger">{{ $log->agent }}</td>
                            <td>{{ $log->user_id }}</td>
                            <td>{{ $log->user_name }}</td>
                            <td>{{ $log->created_at }}</td>
                            <td><button class="btn btn-danger btn-sm">Delete</button></td>
                        </tr>
                    @endforeach
                @endif
            </table>
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
        $(document).ready(function(){
            $('.summernote').summernote();

            $('.summernote-notes').summernote();
            $('.summernote-report').summernote();

        });
    </script>

@stop
