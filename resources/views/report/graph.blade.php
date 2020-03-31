@extends('layouts/default')

{{-- Page title --}}
@section('title')
    General Report
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!-- put styling here -->
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
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Bar Chart Example</h5>
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

    <!-- ChartJS-->
    <script type="text/javascript" src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/demo/chartjs-demo.js') }}"></script>

    <script>
        var jsonfile = {
            "jsonarray": [{
                "name": "Joe",
                "age": 12
            }, {
                "name": "Tom",
                "age": 14
            }, {
                "name": "Tom",
                "age": 9
            }, {
                "name": "Tom",
                "age": 10
            }]
        };

        var labels = jsonfile.jsonarray.map(function(e) {
            return e.name;
        });
        var data = jsonfile.jsonarray.map(function(e) {
            return e.age;
        });;

        var ctx = canvas.getContext('2d');
        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Graph Line',
                    data: data,
                    backgroundColor: 'rgba(0, 119, 204, 0.3)'
                }]
            }
        };

        var chart = new Chart(ctx, config);
    </script>

@stop
