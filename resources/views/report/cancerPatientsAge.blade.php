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
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
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
                    <div class="ibox-title the-title">
                        <h5 id="the-title">{{ $title }} </h5>
                    </div>

                    <div class="ibox-title">
                        <div class="float-right">
                            <form id="search_form" class="form-inline pull-right" action="{{url('cancer-patients-age')}}"
                                  method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="form-group" id="data_5" style="margin-top: -10px">
                                    <label class="font-normal">Chart</label>
                                    <select id="chart" name="chart" class="form-control" style="width:80px;">
                                        <option value="bar">Bar</option>
                                        <option value="line">Line</option>
                                    </select>
                                </div>
                                <div class="form-group" id="data_5" style="margin-top: -10px;margin-left: 30px;">
                                    <label class="font-normal">Age</label>
                                    <div class="input-group" id="">
                                        <input type="text" class="form-control-sm form-control" name="startAge" value="" style="width: 50px;" />
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control-sm form-control" name="endAge" value="" style="width: 50px;" />
                                    </div>
                                </div>
                                <div class="form-group" id="data_5" style="margin-top: -10px;margin-left: 30px;">
                                    <label class="font-normal">Range</label>
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control-sm form-control" name="start" value="01-01-2019" style="width: 140px" />
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control-sm form-control" name="end" value="{{ date('d-m-Y') }}" style="width: 140px" />
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
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content" id="display">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover patho " >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Age</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1;@endphp
                                @foreach($pathologies as $pathology)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-capitalize">{{ $pathology->age ?? '' }}</td>
                                        <td class="text-capitalize">{{ $pathology->total ?? '' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="ibox ">
                    <div class="ibox-title ">
                        <h5 id="the-title2">{{ $title }} </h5>
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
    <script src="/js/plugins/toastr/toastr.min.js"></script>
    <!-- Sweet alert -->
    <script src="/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

    <!-- ChartJS-->
    <script type="text/javascript" src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/demo/chartjs-demo.js') }}"></script>
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


    <script>
        $(document).ready(function (){
            $('.pathos').DataTable({
                "scrollY": "400px",
                "scrollCollapse": true
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.patho').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

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
                    url: '/cancer-patients-age',
                    method:"POST",
                    data:$('#search_form').serialize(),
                    beforeSend:function(){
                        //
                    },
                    success:function(data){
                        arasa(data.cancer, data.cancer_type);
                        $('#display').html(data.search);
                        $('#the-title').html(data.title);
                        $('#the-title2').html(data.title);
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

            console.log(cancer_type);

            var labels = jsonfile.jsonarray.map(function (e) {
                return e.age;
            });
            var data = jsonfile.jsonarray.map(function (e) {
                return e.total;
            });
            console.log(labels);
            console.log(data);

            var ctx = canvas.getContext('2d');
            var config = {
                type: $('#chart').val(),
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
