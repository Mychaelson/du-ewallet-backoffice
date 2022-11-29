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
                    <div class="col-md-3">
                        <form>
                            <div class="form-group">
                                <label for="filterPhone">Filtered By Phone :</label>
                                <input type="text" class="form-control" id="filterPhone" placeholder="Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="filterlock">Filter By Lock :</label>
                                <select id="filterlock" class="form-control">
                                    <option selected>Choose...</option>
                                    @foreach ($filter_lock as $row=>$key)
                                    <option>{{$key}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="filterRegister">Filter By Date Registered :</label>
                                <input type="date" class="form-control" id="filterStartDate"
                                    placeholder="Filter Start Date">
                                <br />
                                <input type="date" class="form-control" id="filterToDate" placeholder="Filter To Date">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="filterRange">Filter By Range :</label>
                                <select id="filterRange" class="form-control">
                                    <option selected>All</option>
                                    <option>Balance</option>
                                    <option>Reversal Fund(s)</option>
                                </select>
                                <br />
                                <input type="number" class="form-control" id="minAmount" placeholder="Min Amount">
                                <br />
                                <input type="number" class="form-control" id="maxAmount" placeholder="Max Amount">
                            </div>
                            <button type="button" class="btn btn-primary" id="submit-data">Filter</button>
                            <button type="submit" class="btn btn-danger">Reset</button>
                        </form>

                        <hr>
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan=2>Resume Filtered Emoney</th>
                                    </tr>
                                    <tr>
                                        <th>Balance User</th>
                                        <th class="total_balance" id="sum_balance">Rp. 0</th>
                                    </tr>
                                    <tr>
                                        <th>Reversal fund(s)</th>
                                        <th class="total_hold">Rp. 0</th>
                                    </tr>
                                    </tbothead dy>
                            </table>
                        </div>


                    </div>
                    <div class="col-lg-9">
                        @if (session('msg_error'))
                        <div class="alert alert-danger" role="alert">
                            {{session('msg_error')}}
                        </div>
                        @endif
                        @if (session('msg_success'))
                        <div class="alert alert-success" role="alert">
                            {{session('msg_success')}}
                        </div>
                        @endif

                        <div class="mb-5">
                            <div class="row align-items-center align-items-sm-start">
                                <div class="col-md-8 col-xxl-3 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                    <div class="d-xxl-flex">
                                        <button
                                            class="btn btn-light-success mr-2 mr-xxl-6 mb-4 mb-lg-2 mb-xl-4 mb-xxl-0"
                                            type="button" id="reload-data"><i class="flaticon2-refresh"></i> Reload
                                            Data</button>
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
@endsection

@section('content_js')
<script>
    var dt_load = function () {
        return {
            param: function () {
                var e = {};
                e.pagination = {
                    'perpage': $('#pagination-perpage').val()
                };
                e.filterPhone = $('#filterPhone').val(),
                e.filterlock = $('#filterlock').val(),
                e.startDateRegistered = $('#filterStartDate').val(),
                e.endDateRegistered = $('#filterToDate').val(),
                e.filterRange = $('#filterRange').val(),
                e.minAmount = $('#minAmount').val(),
                e.maxAmount = $('#maxAmount').val();
                return e;
            },
            init: function ($params) {
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
                $.post("{{ route('wallet-emoney.dt') }}", $data, function (e) {
                    console.log(e);
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
                        $('#sum_balance').text(`Rp. ${parseInt(e.sum_balance).toLocaleString()}`);
                    } else {
                        $('#report-table .alert').show().find('.alert-text').text(e.message ? e
                            .message : 'No records found');
                    }
                }).fail(function (xhr) {
                    loader_tb.destroy();
                    alertModal.find(".modal-title > span").text("ERROR");
                    alertModal.find(".modal-body").text(xhr.responseJSON.message);
                    alertModal.modal("show");
                });
            }
        }
    }();

    $(function () {
        var e = dt_load.param();
        dt_load.init(e);
        $("#minAmount").hide();
        $("#maxAmount").hide();

        $('#submit-data').click(function () {
            var e = dt_load.param();
            console.log(e);
            dt_load.init(e);
        });

        $('#filterRange').change(function () {
            let f_range = this.value;
            if (f_range == 'All') {
                $("#minAmount").hide();
                $("#maxAmount").hide();
            } else {
                $("#minAmount").show();
                $("#maxAmount").show();
            }
            console.log(this.value);
        });

        $('#reload-data').click(function () {
            var e = dt_load.param();
            console.log(e);
            dt_load.init(e);
        });


        $('.search-text').keypress(function (e) {
            if (e.keyCode == 13) {
                $('#submit-data').trigger('click');
            }
        });


        $('body').delegate('#refresh-table', 'click', function () {
            var e = dt_load.param(),
                $this = $(this);
            e.pagination = {
                'perpage': $(this).attr('data-limit'),
                'page': $(this).attr('data-pagination')
            };
            dt_load.init(e);
        });


        $('body').delegate('#pagination a', 'click', function (p) {
            p.preventDefault();
            var e = dt_load.param();
            e.pagination = {
                'perpage': $('#pagination-perpage').val(),
                'page': $(this).attr('data-page')
            };
            dt_load.init(e);
        });

        $('body').delegate('#pagination-perpage', 'change', function (p) {
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