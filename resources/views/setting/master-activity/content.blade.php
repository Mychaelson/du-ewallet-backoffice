@extends('layouts.template.app')

@section('content_body')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-line-graph text-primary"></i>
                        </span>
                        <h3 class="card-label"> {{ $page_title }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (session('msg_error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('msg_error') }}
                                </div>
                            @endif
                            @if (session('msg_success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg_success') }}
                                </div>
                            @endif

                            <div class="mb-5">
                                <div class="row align-items-center align-items-sm-start">
                                    <div class="col-md-8 col-xxl-3 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                        <div class="d-xxl-flex">
                                            <button
                                                class="btn btn-light-success mr-2 mr-xxl-6 mb-4 mb-lg-2 mb-xl-4 mb-xxl-0"
                                                type="button" id="submit-data"><i class="flaticon2-refresh"></i> Reload
                                                Data</button>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="float-right">
                                            <button
                                                class="btn btn-light-primary mr-2 mr-xxl-6 mb-4 mb-lg-2 mb-xl-4 mb-xxl-0"
                                                data-toggle="modal" data-target="#modal-create"><i
                                                    class="flaticon2-plus"></i>
                                                Create</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="report-table">
                                <div class="alert alert-secondary" role="alert">
                                    No Record Founds!
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---Moda Create-->
    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create-master-activity') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name Activity</label>
                            <input type="text" name="name" required class="form-control" placeholder="Name Activity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Group</label>
                            <input type="text" name="group" required class="form-control" placeholder="Groups Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Role</label>
                            <input type="text" name="role" required class="form-control" placeholder="Role Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">About</label>
                            <textarea class="form-control" required name="about" id="" rows="5" placeholder="Jobs Name"></textarea>
                        </div>

                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-outline-primary">
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!--------------->

    <!---Moda Create-->
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-process-master-activity') }}" method="POST" id="edit-form">
                        <input type="hidden" name="_method" value="PUT">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name Activity</label>
                            <input type="text" id="edit-name" name="name" class="form-control"
                               required placeholder="Name Activity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Group</label>
                            <input type="text" id="edit-group" name="group" class="form-control"
                               required placeholder="Groups Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Role</label>
                            <input type="text" id="edit-role" name="role" class="form-control"
                               required placeholder="Role Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">About</label>
                            <textarea class="form-control" id="edit-about" name="about" id="" rows="5"
                               required placeholder="Jobs Name"></textarea>
                        </div>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-outline-primary" value="Save and Change">
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!--------------->
@endsection

@section('content_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @if (session('message'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-data', function() {
                var userURL = $(this).data('url');
                $.get(userURL, function(data) {
                    $('#modal-edit').modal('show');
                    $('#edit-id').val(data.id);
                    $('#edit-name').val(data.name);
                    $('#edit-group').val(data.group);
                    $('#edit-role').val(data.role);
                    $('#edit-about').val(data.about);
                })
            });

        });

        $('#btn-save').on('click', function() {
            $('#create-form').submit()
        });

        $('#btn-edit').on('click', function() {
            $('#edit-form').submit()
        });
    </script>
    <script>
        var dt_load = function() {
            return {
                param: function() {
                    var e = {};
                    // e.period=$(".date-range-period #start").attr('data-selected') + '/' + $(".date-range-period #end").attr('data-selected'),
                    // e.group=$("#dt_select_group").val().toLowerCase(),
                    // e.job=$("#dt_select_job").val().toLowerCase(),
                    // e.searchNickname=$("#dt_search_nickname").val().toLowerCase(),
                    e.pagination = {
                        'perpage': $('#pagination-perpage').val()
                    };
                    return e;
                },
                init: function($params) {
                    loader_tb.init();
                    $data = {
                        _token: '{{ csrf_token() }}',
                        query: {},
                        pagination: {}
                    };
                    if (typeof $params === 'object') {
                        for (var key in $params) {
                            var obj = $params[key];
                            if (key != 'pagination') {
                                $data['query'][key] = obj;
                            } else {
                                $data[key] = obj;
                            }
                        }
                    }
                    $.post("{{ route('master-activity.dt') }}", $data, function(e) {
                        $('#report-table').find('#table-area').remove();
                        loader_tb.destroy();
                        if (!e.status) {
                            alertModal.find(".modal-title > span").text("ERROR");
                            alertModal.find(".modal-body").text(e.message);
                            alertModal.modal("show");
                            return false;
                        }
                        if (e.total_row > 0) {
                            $('#report-table .alert').hide();
                            $('#report-table').append(e.content);
                        } else {
                            $('#report-table .alert').show().find('.alert-text').text(e.message ? e
                                .message : 'No records found');
                        }
                    }).fail(function(xhr) {
                        loader_tb.destroy();
                        alertModal.find(".modal-title > span").text("ERROR");
                        alertModal.find(".modal-body").text(xhr.responseJSON.message);
                        alertModal.modal("show");
                    });
                }
            }
        }();

        $(function() {
            var e = dt_load.param();
            dt_load.init(e);

            $('#submit-data').click(function() {
                var e = dt_load.param();
                dt_load.init(e);
            });


            $('.search-text').keypress(function(e) {
                if (e.keyCode == 13) {
                    $('#submit-data').trigger('click');
                }
            });


            $('body').delegate('#refresh-table', 'click', function() {
                var e = dt_load.param(),
                    $this = $(this);
                e.pagination = {
                    'perpage': $(this).attr('data-limit'),
                    'page': $(this).attr('data-pagination')
                };
                dt_load.init(e);
            });


            $('body').delegate('#pagination a', 'click', function(p) {
                p.preventDefault();
                var e = dt_load.param();
                e.pagination = {
                    'perpage': $('#pagination-perpage').val(),
                    'page': $(this).attr('data-page')
                };
                dt_load.init(e);
            });

            $('body').delegate('#pagination-perpage', 'change', function(p) {
                p.preventDefault();
                var e = dt_load.param();
                e.pagination = {
                    'perpage': $(this).val()
                };
                dt_load.init(e);
            });
        });
    </script>
@endsection
