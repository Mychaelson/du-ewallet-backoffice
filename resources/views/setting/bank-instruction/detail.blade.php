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

                            @if (isset($idBank))
                                <input hidden value="{{$idBank}}" id="bank_instruction_id" />
                            @endif

                            <div class="mb-5">
                                <div class="row align-items-center align-items-sm-start">
                                    <div class="col-md-8 col-xxl-3 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                        <div class="d-xxl-flex">
                                            <button
                                                class="btn btn-light-success mr-2 mr-xxl-6 mb-4 mb-lg-2 mb-xl-4 mb-xxl-0"
                                                type="button" id="submit-data"><i class="flaticon2-refresh"></i> Reload
                                                Data</button>
                                            <!-- <div class="flex-grow-1">
                                                    <div class="input-daterange input-group date-range-period">
                                                        <input type="text" class="m-input form-control" readonly="" id="start" placeholder="{{ \Carbon\Carbon::now()->format('d M Y') }}" data-selected="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <span class="input-group-append pointer">
                                                            <span class="input-group-text">
                                                                <i class="la la-calendar-check-o"></i>
                                                            </span>
                                                        </span>
                                                        <input type="text" class="m-input form-control" readonly="" id="end" placeholder="{{ \Carbon\Carbon::now()->format('d M Y') }}" data-selected="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    </div>
                                                </div> -->
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
                                    {{-- <div class="col-md-4 col-xxl-9 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                        <div class="row">
                                            <div class="col-xxl-2 mb-4 mb-xxl-0">
                                                <div class="input-icon flex-grow-1 mr-0 mr-xxl-6 mb-4 mb-lg-2 mb-xl-2 mb-xxl-0">
                                                    <input type="text" class="form-control search-text" placeholder="Search by Nickname" id="dt_search_nickname" autocomplete="off" />
                                                    <span>
                                                        <i class="flaticon2-search-1 text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
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
                    <form action="{{ route('create-master-jobs') }}" method="POST" id="create-form">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name Pekerjaan</label>
                            <input type="text" name="nama_pekerjaan" class="form-control" placeholder="Nama Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Jobs Name</label>
                            <input type="text" name="jobs_name" class="form-control" placeholder="Jobs Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Type</label>
                            <select class="form-control" name="type">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="Hight">Hight</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-save" class="btn btn-outline-primary">Save changes</button>
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
                    <form action="{{ route('edit-process-master-jobs') }}" method="POST" id="edit-form">
                        <input type="hidden" name="_method" value="PUT">
                        @csrf
                        <input type="hidden" name="req_id" id="edit-id">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pekerjaan</label>
                            <input type="text" id="edit-nama-pekerjaan" name="nama_pekerjaan" class="form-control"
                                placeholder="Name Activity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Jobs Name</label>
                            <input type="text" id="edit-jobs-name" name="jobs_name" class="form-control"
                                placeholder="Groups Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Type</label>
                            <select class="form-control" id="edit-type" name="type">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="Hight">Hight</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-edit" class="btn btn-outline-primary">Save changes</button>
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
                    console.log(data.name_id)
                    $('#modal-edit').modal('show');
                    $('#edit-id').val(data.id);
                    $('#edit-nama-pekerjaan').val(data.name_id);
                    $('#edit-jobs-name').val(data.name_en);
                    $('#edit-type').val(data.type).change();
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
                    e.bank_instruction_id = $('#bank_instruction_id').val(),
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
                    $.post("{{ route('bank-instruction-detail.dt') }}", $data, function(e) {
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
