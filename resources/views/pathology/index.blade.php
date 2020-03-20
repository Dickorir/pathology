@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Cancer Record
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
                    <strong>Cancer Records</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $pathologies_count }}</h1>
                        <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                        <small>Total Cancer Records</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    @include('notifications')
                    <div class="ibox-title">
                        <h5>Cancer Records </h5>
                        <div class="ibox-tools" style="margin-top: -8px;">
                            <a href="{{ url('cancer-record/add') }}" class="btn btn-primary">
                                Add <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content table-responsive">
                        <table class="table table-striped table-bordered table-hover patho " >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>patient_id</th>
                                <th>hospital</th>
                                <th>request_form_name</th>
                                <th>date</th>
                                <th>type_of_test</th>
                                <th>specimen</th>
                                <th>cancer_type</th>
                                <th>cancer_stage</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i = 1;@endphp
                            @foreach($pathologies as $pathology)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-capitalize">{{ $pathology->patient->name ?? '' }}</td>
                                    <td class="text-capitalize">{{ $pathology->hospital ?? '' }}</td>
                                    <td class="text-capitalize">{{ $pathology->request_form_name ?? '' }}</td>
                                    <td class="text-capitalize">{{ $pathology->date ?? '' }}</td>
                                    <td class="text-capitalize">{{ $pathology->type_of_test ?? '' }}</td>
                                    <td class="text-capitalize">{{ $pathology->specimen ?? '' }}</td>
                                    <td class="text-capitalize">{{ $pathology->cancer_type ?? '-' }}</td>
                                    <td class="text-capitalize">{{ $pathology->cancer_stage ?? '-' }}</td>
                                    <td>
                                        <a href='{{ url('cancer-record',$pathology->id) }}'><i class="fa fa-eye text-success" title="view cancer-record"></i></a> &nbsp;
                                        <a href='{{ url('cancer-record',$pathology->id.'/edit') }}'><i class="fa fa-pencil-square-o text-info" title="edit cancer-record"></i></a> &nbsp;
                                        <a href='{{ url('cancer-record',$pathology->id.'/delete') }}' class="toa" id="{{ $pathology->id }}"><i class="fa fa-trash-o text-danger" title="delete cancer-record"></i></a>
                                        {{--<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Form in simple modal box</a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
            $('.patho').DataTable({
                "scrollY": "400px",
                "scrollCollapse": true
            });
        });
    </script>
@stop
