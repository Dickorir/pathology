@extends('layouts/default')

{{-- Page title --}}
@section('title')
    General Report
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->

    <!-- Toastr style -->
    <link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}">

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
                    <strong> General Report</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    @include('notifications')
                    <div class="ibox-title">
                        <h5>Cancer Records for total people against year on Individual Cancer </h5>
                    </div>

                    <div class="ibox-title">
                        <div class="float-right">
                            <form id="search_form" class="form-inline pull-right" action="{{url('general-graph-combined')}}"
                                  method="post" role="search">
                                {{ csrf_field() }}
                                <div class="form-group" id="data_5" style="margin-top: -10px">
                                    <label class="font-normal">Range select</label>
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control-sm form-control" name="start" value="01-01-2019" />
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control-sm form-control" name="end" value="{{ date('d-m-Y') }}" />
                                    </div>
                                </div>
                                <div class="input-group" style="margin-top: -10px">
                                    <select id="search_input" name="q" class="form-control" style="width:150px;">
                                        <option value="">All</option>
                                        @foreach($cancer_types as $cancer_type)
                                            <option value="{{ $cancer_type->cancer_type }}">{{ $cancer_type->cancer_type }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                        <button id="view-report" type="submit" class="btn btn-custom btn-md btn-info" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                        <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Bar Chart </h5>
                    </div>
                    <div class="ibox-content">
                        <div>
                            <canvas id="canvas" height="140"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- put scripts gera -->
    <!-- ChartJS-->
    <script type="text/javascript" src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/demo/chartjs-demo.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

    <!-- Image cropper -->
    <script type="text/javascript" src="{{ asset('js/plugins/cropper/cropper.min.js') }}"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script type="text/javascript" src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

    <!-- Date range picker -->
    <script type="text/javascript" src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Tags Input -->
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "dd-mm-yyyy"
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#view-report").click(function(event){
                event.preventDefault();

                var id = $('#search_input').val();
                // alert(id);

                $.ajax({
                    url: '/general-graph-combined',
                    method:"POST",
                    data:$('#search_form').serialize(),
                    beforeSend:function(){
                        //
                    },
                    success:function(data){
                        arasa(data.cancer, data.cancer_type);
                    },
                    error: function (data) {
                        alert('Ooops something went wrong!');
                    },
                    complete : function (data){
                        //
                    }
                });
            });
        });
    </script>
    <script>
        function arasa(cancer,cancer_type) {

            var jsonfile = cancer;

            console.log(jsonfile);

            var labels = jsonfile.jsonarray.map(function (e) {
                return e.year;
            });
            var data = jsonfile.jsonarray.map(function (e) {
                return e.total;
            });

            var ctx = canvas.getContext('2d');
            var config = {
                    type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: cancer_type + ' cancer',
                        data: data,
                        backgroundColor: 'rgba(0, 119, 204, 0.3)'
                    }]
                }
            };

            var chart = new Chart(ctx, config);
        }
    </script>
@stop
