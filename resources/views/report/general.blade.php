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
                        <h5>Cancer Records General Report </h5>
                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover patho " >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cancer Type</th>
                                    <th>Cancer Stage</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Year</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1;@endphp
                                @foreach($pathologies as $pathology)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-capitalize">{{ $pathology->cancer_type ?? '-' }}</td>
                                        <td class="text-capitalize">{{ $pathology->cancer_stage == null ? '-' : 'Stage '.$pathology->cancer_stage }}</td>
                                        <td class="text-capitalize">{{ $pathology->patient->age ?? '' }}</td>
                                        <td class="text-capitalize">{{ $pathology->patient->gender ?? '' }}</td>
                                        <td class="text-capitalize">{{ date('Y', strtotime($pathology->date)) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
@stop
