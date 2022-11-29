@extends('layouts.template.app')
@section('content_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

@endsection
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

                                                <div class="float-right">
                                                    <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                                                        <li class="fa fa-upload"></li> Upload
                                                    </a>
                                                </div>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Select File</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{route('media-upload')}}" method="POST" id="form-submit" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="file-loading">
                        <input id="input-44" name="images[]" required type="file" multiple>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btn-save" class="btn btn-primary">Save</button>
                </div>
          </div>
        </div>
      </div>
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
            timer: 3000
        })
    </script>
@endif

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/filetype.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/fileinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.1/js/locales/LANG.js"></script>
<script>
    $('#btn-save').on('click',function(){
        $('#form-submit').submit()
    });
</script>
<script>
    $(document).ready(function() {
        $("#input-44").fileinput({
            uploadUrl: '/file-upload-batch/2',
            maxFilePreviewSize: 10240,
            showUpload: false
        });
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
                    $.post("{{ route('media.dt') }}", $data, function(e) {
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
