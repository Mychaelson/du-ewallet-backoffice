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
                                    <div class="col-xxl-2 mb-4 mb-xxl-0">
                                        <select class="form-control select2-search" id="dt_code">
                                            <option value="">-- Search By Code --</option>
                                            @foreach ($get_all as $ga)
                                                <option value="{{ $ga->code }}">{{ $ga->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xxl-2 mb-4 mb-xxl-0">
                                        <select class="form-control select2-search" id="dt_status">
                                            <option value="">-- Select Status --</option>
                                                <option value="1">Active</option>
                                                <option value="0">Non Active</option>
                                           </select>
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

    <div class="modal fade" id="show-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for=""><Strong>Code</Strong></label>
                            <p id="d-code"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Name</Strong></label>
                            <p id="d-name"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Provider</Strong></label>
                            <p id="d-provider"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for=""><Strong>Category</Strong></label>
                            <p id="d-category"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Denom</Strong></label>
                            <p id="d-denom"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Admin Fee</Strong></label>
                            <p id="d-admin-fee"></p>
                        </div>
                    </div>
<hr>
                    <div class="row">
                        <div class="col">
                            <label for=""><Strong>Price Sell</Strong></label>
                            <p id="d-price-sell"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Price Buy</Strong></label>
                            <p id="d-price-buy"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Discount</Strong></label>
                            <p id="d-discount"></p>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for=""><Strong>Product Type</Strong></label>
                            <p id="d-type"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Status</Strong></label>
                            <p id="d-status"></p>
                        </div>

                        <div class="col">
                            <label for=""><Strong>Created </Strong></label>
                            <p id="d-created"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                       <div class="col">
                           <label for=""><Strong>Description </Strong></label>
                           <br>
                           <div id="d-description">
                        </div>
                    </div>
                    </div>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
    <script>
        $(document).ready(function() {
            $('body').on('click', '#see-data', function() {
                var code = $(this).data('id');
                $.ajax({
                    url: 'ppob/detail-product/' + code,
                    method: 'GET',
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data.description);
                        $('#show-modal').modal('show');
                        $('#d-code').text(data.code);
                        $('#d-name').text(data.name);
                        $('#d-provider').text(data.provider);
                        $('#d-category').text(data.category_name);
                        $('#d-denom').text('Rp. ' + parseFloat(data.denom, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                        $('#d-admin-fee').text('Rp. ' + parseFloat(data.admin_fee, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                        $('#d-price-sell').text('Rp. ' + parseFloat(data.price_sell, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                        $('#d-price-buy').text('Rp. ' + parseFloat(data.price_buy, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                        $('#d-discount').text('Rp. ' + parseFloat(data.discount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                       if(data.status == 1){
                           $('#d-status').text('Active');
                       }else{
                        $('#d-status').text('Non Active');
                       }
                        $('#d-created').text(data.created_at);
                        $('#d-type').text(data.product_type);
                        $('#d-description').html(data.description);
                    }
                })
            });

        });

        var dt_load = function() {
            return {
                param: function() {
                    var e = {};
                    // e.period=$(".date-range-period #start").attr('data-selected') + '/' + $(".date-range-period #end").attr('data-selected'),
                    e.code = $("#dt_code").val(),
                    e.status = $("#dt_status").val(),
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
                    $.post("{{ route('product-v2.dt') }}", $data, function(e) {
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
