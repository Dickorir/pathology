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
                        <h5>Cancer Records for total people against year on {{ $cancer_type }} cases </h5>
                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover patho " >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Year</th>
                                    <th>Total People</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1;@endphp
                                @foreach($pathologies as $pathology)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-capitalize">{{ date('Y', strtotime($pathology->date)) }}</td>
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
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Line Chart</h5>
                    </div>
                    <div class="ibox-content">
                        <div>
                            <canvas id="canvas" height="140"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Line Chart Example
                            <small>With custom colors.</small>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div>
                            <canvas id="lineChart" height="140"></canvas>
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

    <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
                url: '/general-graph',
                method:"GET",
                data:{},
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
            ;

            var ctx = canvas.getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: cancer_type,
                        data: data,
                        backgroundColor: 'rgba(0, 119, 204, 0.3)'
                    }]
                }
            };

            var chart = new Chart(ctx, config);
        }
    </script>
    <script>
        $(function () {
            var lineData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [

                    {
                        label: "Data 1",
                        backgroundColor: 'rgba(26,179,148,0.5)',
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [28, 48, 40, 19, 86, 27, 90]
                    },{
                        label: "Data 2",
                        backgroundColor: 'rgba(220, 220, 220, 0.5)',
                        pointBorderColor: "#fff",
                        data: [65, 59, 80, 81, 56, 55, 40]
                    },{
                        label: "Data 3",
                        backgroundColor: 'rgba(120,22,118,0.5)',
                        pointBorderColor: "#fff",
                        data: [55, 99, 20, 81, 56, 95, 40]
                    }
                ]
            };

            var lineOptions = {
                responsive: true
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


        });
    </script>
@stop
