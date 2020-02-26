@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Zain Exam
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
                    <strong>Students Marks</strong>
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
                        <h5>Students Marks </h5>
                        <div class="ibox-tools" style="margin-top: -8px;">
                            <a href="{{ url('mark/add') }}" class="btn btn-primary">
                                Add <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-title">
                        <div class="float-right">
                            <form id="admin_search_form" class="form-inline pull-right" action="{{url('admin/search')}}"
                                  method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group" style="margin-top: -10px">
                                    <input id="admin_search_input" type="text" class="form-control" name="q" required
                                           placeholder="Search admin" style="width:150px;">
                                    <span class="input-group-btn">
                                        <button id="admin_search" type="submit" class="btn btn-custom btn-md btn-info" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                        <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>

                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#admin_search_input").bind("keyup change", function(event) {
                                    // $("#admin_search_input").click(function(event){
                                        event.preventDefault();

                                        jQuery.support.cors = true;
                                        $.ajax({
                                            url: '/admin/search',
                                            method:"POST",
                                            data:$('#admin_search_form').serialize(),
                                            beforeSend:function(){
                                                //
                                            },
                                            success:function(data){
                                                $('#admi').html(data.search);
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
                        </div>
                    </div>
                    {{--<div class="mt-3"></div>--}}
                    <div id="admi">
                        <div class="ibox-content table-responsive">

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Index No</th>
                                    <th>Math</th>
                                    <th>English</th>
                                    <th>Kiswahili</th>
                                    <th>Science</th>
                                    <th>Social Studies</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = ($marks->currentpage()-1)* $marks->perpage() + 1;@endphp
                                @foreach($marks as $mark)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-capitalize">{{ $mark->index_no ?? '' }}</td>
                                        <td class="text-capitalize">{{ $mark->math.' | '.$mark->math_grade ?? '' }}</td>
                                        <td class="text-capitalize">{{ $mark->eng.' | '.$mark->eng_grade ?? '' }}</td>
                                        <td class="text-capitalize">{{ $mark->kiswa.' | '.$mark->kiswa_grade ?? '' }}</td>
                                        <td class="text-capitalize">{{ $mark->sci.' | '.$mark->sci_grade ?? '' }}</td>
                                        <td class="text-capitalize">{{ $mark->soc_stud.' | '.$mark->soc_stud_grade ?? '' }}</td>
                                        <td class="text-capitalize">{{ $mark->tot_score.' | '.$mark->tot_grade ?? '' }}</td>
                                        <td>
                                            <a class="" href=""
                                               onclick="event.preventDefault();
                                                     document.getElementById('edit-form{{$mark->index_no}}').submit();">
                                                <i class="fa fa-pencil-square-o text-info"></i>
                                            </a>
                                            <a href='{{ url('admin',$mark->id.'/delete') }}' class="toa" id="{{ $mark->id }}"><i class="fa fa-trash-o text-danger" title="delete student"></i></a>

                                            <form id="edit-form{{$mark->index_no}}" role="form"  method="POST" action="{{ route('student.select') }}">
                                                @csrf
                                                <input name="student_index_no" value="{{ $mark->index_no ?? '' }}" type="hidden">
                                            </form>

                                            {{--<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Form in simple modal box</a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $marks->links() }}
                            </div>

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
