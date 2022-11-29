@extends('layouts.template.app')

@section('content_body')
<div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ $page_title }}</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->
            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="{{route('wallet.emoney.detail', ['id' => $id])}}" class="btn btn-primary font-weight-bold">Back</a>
                <!--end::Button-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <!-- SIDE INFO START -->
                    <div class="col-3">
                        <!-- user info begin -->
                        <div class="card mt-2">
                            <div class="card-body">
                                <h5 class="card-title">Owner</h5>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Phone</th>
                                            <td>{{ $user_info->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Name</th>
                                            <td>{{$user_info->name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- user info end -->

                        <!-- account merchant start -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Account Merchant</h5>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Name</th>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Account</th>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- account merchant end -->

                        <!-- user wallet info start -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Wallet IDR · E-Money</h5>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">balance</th>
                                            <td>{{ number_format($info->balance, 0, ',', '.') }}</td>
                                        </tr>
                                        <!-- TODO: add reversal fund -->
                                        <tr>
                                            <th scope="row">
                                                Reversal
                                                <br>
                                                Fund(s)
                                            </th>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- user wallet info end -->
                    </div>
                    <!-- SIDE INFO END -->

                    <div class="col-9">
                        <!-- FORM start -->
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="alert alert-custom alert-outline-2x alert-outline-success fade show mb-5"
                                    role="alert" id="success-alert">
                                    <div class="alert-icon">
                                        <i class="flaticon-warning"></i>
                                    </div>
                                    <div class="alert-text">Success: Data has been process</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                                <i class="ki ki-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="alert alert-custom alert-outline-2x alert-outline-danger fade show mb-5"
                                    role="alert" id="failed-alert">
                                    <div class="alert-icon">
                                        <i class="flaticon-warning"></i>
                                    </div>
                                    <div class="alert-text"></div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                                <i class="ki ki-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                
                                <h5 class="card-title">Limit</h5>
                                <table class="table table-borderless">
                                    @if (isset($id))
                                        <input type="hidden" name="wallet_id" id="wallet_id" value="{{$id}}">
                                    @endif
                                    <tbody>
                                        <tr>
                                            <th>
                                                <div>
                                                    Max Balance
                                                    <br>
                                                    <input type="text" class="form-control mt-2" placeholder="Amount" name="max_balance" id="max_balance" autocomplete="off" value="{{$limit->max_balance}}" required />
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    Max Transfer Daily
                                                    <br>
                                                    <input type="text" class="form-control mt-2" placeholder="Amount" name="max_transfer_daily" id="max_transfer_daily" autocomplete="off" value="{{$limit->transfer_daily}}" required />
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    Max Withdraw Daily
                                                    <br>
                                                    <input type="text" class="form-control mt-2" placeholder="Amount" name="max_withdraw_daily" id="max_withdraw_daily" autocomplete="off" value="{{$limit->withdraw_daily}}" required />
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <div>
                                                    Max Monthly Transaction
                                                    <br>
                                                    <input type="text" class="form-control mt-2" placeholder="Amount" name="max_monthly_transaction" id="max_monthly_transaction" autocomplete="off" value="{{$limit->transaction_monthly}}" required />
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    Max Group Transfer
                                                    <br>
                                                    <input type="number" class="form-control mt-2" placeholder="Amount" name="max_group_transfer" id="max_group_transfer" autocomplete="off" value="{{$limit->max_group_transfer}}" required />
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    Free Withdraw Monthly
                                                    <br>
                                                    <input type="text" class="form-control mt-2" placeholder="Amount" name="free_withdraw" id="free_withdraw" autocomplete="off" value="{{$limit->free_withdraw}}" required />
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <div>
                                                    Max Payment Daily
                                                    <br>
                                                    <input type="text" class="form-control mt-2" placeholder="Amount" name="max_payment_daily" id="max_payment_daily" autocomplete="off" value="{{$limit->payment_daily}}" required />
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    Switching Max
                                                    <br>
                                                    <input type="text" class="form-control mt-2" placeholder="Amount" name="switching_max" id="switching_max" autocomplete="off" value="{{$limit->switching_max}}" required />
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    Max Group Withdraw
                                                    <br>
                                                    <input type="number" class="form-control mt-2" placeholder="Amount" name="max_group_withdraw" id="max_group_withdraw" autocomplete="off" value="{{$limit->max_group_withdraw}}" required />
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="row">Agreement Document</th>
                                            <td colspan="1">
                                                <div class="form-group">
                                                    <input type="text" id="document" name="document"
                                                        placeholder="Document Numbers" class="form-control" required autocomplete="off">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-success form-control"
                                                        data-toggle="modal" data-target="#DocumentData">Find
                                                        Document</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Reason</th>
                                            <td colspan="2">
                                                <div class="form-group">
                                                    <textarea id="reason" class="form-control" name="reason" placeholder="Reason"
                                                        rows="5" required></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-outline-danger mt">Request Unset</button>
                                    <button type="button" class="btn btn-primary" id="btnRequest">Request</button>
                                </div>
                            </div>
                        </div>
                        <!-- FORM end -->

                        <!-- table 1 start -->
                        <!-- TODO: added data and pagination -->
                        <div class="card mt-2">
                            <div class="card-body">
                                <h5 class="card-title">Documents</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>file</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>test</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table 1 end -->

                        <!-- table 2 start -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List Request Wallet Limit</h5>
                                <div id="report-table">
                                    <div class="alert alert-secondary" role="alert">
                                        No Record Founds!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- table 2 end -->

                        <!-- table 3 start -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Wallet Limit History</h5>
                                <div id="report-table-history">
                                    <div class="alert alert-secondary" role="alert">
                                        No Record Founds!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- table 3 end -->

                        <!-- Modal -->
                            <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="requestModalLabel">Request Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table" id="report-table-req">
                                                <div class="alert alert-secondary" id="req-info" role="alert">
                                                    No Record Founds!
                                                </div>
                                        </table>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <div id="btnAction">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <!-- end modal -->

                        <div class="modal fade" id="DocumentData" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Report Document</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="300">
                                            <div>
                                                <button type="button" class="btn btn-primary" id="btnShowDoc">Show Data</button>
                                                <hr />
                                                <div id="report-req-table">
                                                    <div class="alert alert-secondary" role="alert">
                                                        No Record Founds!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Container-->
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
    var updateForm = function () {
        return {
            param: function () {
                var e = {};
                e.max_balance = $('#max_balance').val(),
                e.max_transfer_daily = $('#max_transfer_daily').val(),
                e.max_withdraw_daily = $('#max_withdraw_daily').val(),
                e.max_monthly_transaction = $('#max_monthly_transaction').val(),
                e.max_payment_daily = $('#max_payment_daily').val(),
                e.switching_max = $('#switching_max').val();
                e.max_group_transfer = $('#max_group_transfer').val();
                e.free_withdraw = $('#free_withdraw').val();
                e.max_group_withdraw = $('#max_group_withdraw').val();
                e.wallet_id = $("#wallet_id").val().toLowerCase();
                e.document = $("#document").val();
                e.reason = $("#reason").val().toLowerCase(),
                console.log(e);
                return e;
            },
            init: function ($params) {
                loader_tb.init();
                $data = {
                    _token: '{{ csrf_token() }}',
                    query: {}
                };
                if (typeof $params === 'object') {
                    for (var key in $params) {
                        var obj = $params[key];
                        if (key == 'wallet_id') {
                            $data[key] = obj;
                        } else {
                            $data['query'][key] = obj;
                        }
                    }
                }
                $.post("{{ route('wallet.emoney.update.limit') }}", $data, function (e) {
                    console.log(e);
                    if(e.status == true){
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").slideUp(500);
                        });
                    }else{
                        $('#failed-alert').find(".alert-text").text(e.message);

                        $("#failed-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#failed-alert").slideUp(500);
                        });
                    }
                    // $('#notifSuccess').find(".toast-body").text("Update Lock Wallet Success");
                    // $('#notifSuccess').toast('show');
                }).fail(function (xhr) {
                    loader_tb.destroy();
                    alertModal.find(".modal-title > span").text("ERROR");
                    alertModal.find(".modal-body").text(xhr.responseJSON.message);
                    alertModal.modal("show");
                });
            }
        }
    }();

    var reqData = function () {
        return {
            param: function () {
                var e = {};
                e.pagination = {
                    'perpage': $('#pagination-perpage').val()
                };
                e.wallet_id = $("#wallet_id").val().toLowerCase(),
                    e.startDateRegistered = $('#filterStartDate').val(),
                    e.endDateRegistered = $('#filterToDate').val();
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
                $.post("{{ route('wallet.emoney.limit.req.table') }}", $data, function (e) {
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
                        console.log(e);
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

    var reqDataHistory = function () {
        return {
            param: function () {
                var e = {};
                e.pagination = {
                    'perpage': $('#pagination-perpage').val()
                };
                e.wallet_id = $("#wallet_id").val().toLowerCase(),
                    e.startDateRegistered = $('#filterStartDate').val(),
                    e.endDateRegistered = $('#filterToDate').val();
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
                $.post("{{ route('wallet.emoney.limit.req.history.table') }}", $data, function (e) {
                    $('#report-table-history').find('#table-req-wallet-limit-history').remove();
                    loader_tb.destroy();
                    if (!e.status) {
                        alertModal.find(".modal-title > span").text("ERROR");
                        alertModal.find(".modal-body").text(e.message);
                        alertModal.modal("show");
                        return false;
                    }

                    if (e.total_row > 0) {
                        $('#report-table-history .alert').hide();
                        $('#report-table-history').append(e.content);
                        console.log(e);
                    } else {
                        $('#report-table-history .alert').show().find('.alert-text').text(e.message ? e
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
        $("#success-alert").hide();
        $("#failed-alert").hide();

        var e = reqData.param();
        reqData.init(e);
        var f = reqDataHistory.param();
        reqDataHistory.init(f);

        $('body').delegate('#refresh-table', 'click', function () {
            var e = reqData.param(),
                $this = $(this);
            e.pagination = {
                'perpage': $(this).attr('data-limit'),
                'page': $(this).attr('data-pagination')
            };
            reqData.init(e);
        });


        $('body').delegate('#pagination a', 'click', function (p) {
            p.preventDefault();
            var e = reqData.param();
            e.pagination = {
                'perpage': $('#pagination-perpage').val(),
                'page': $(this).attr('data-page')
            };
            reqData.init(e);
        });

        $('body').delegate('#pagination-perpage', 'change', function (p) {
            p.preventDefault();
            var e = reqData.param();
            e.pagination = {
                'perpage': $(this).val()
            };
            reqData.init(e);
        });
    });

    $('#btnRequest').click(function () {
        var e = updateForm.param();
        updateForm.init(e);
        var e = reqData.param();
        reqData.init(e);
        var f = reqDataHistory.param();
        reqDataHistory.init(f);
    });

    function actionApprove (id, isHistory = false) {
        $data['id'] = id;
        $.post("{{ route('wallet.emoney.limit.req.action') }}", $data, function (e) {
            let html = "";
            let changes = jQuery.parseJSON( e.content.changes );
            console.log(changes);
            html = `
            <tbody id="report-table-req-body">
                <tr>
                    <th scope="row">wallet_id</th>
                    <td>
                        #${e.content.wallet_id}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Agreement Document</th>
                    <td>
                        ${e.content.document}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Description</th>
                    <td>
                        ${e.content.reason ?? '-'}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Requested By</th>
                    <td>
                        ${e.content.requestor}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Approved By</th>
                    <td>
                        ${e.content.approver ?? '-'}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Created</th>
                    <td>
                        ${e.content.created_at}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Max Balance</th>
                    <td>
                        ${changes['max_balance']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Max Monthly Transaction</th>
                    <td>
                        ${changes['transaction_monthly']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Max Payment Daily</th>
                    <td>
                        ${changes['payment_daily']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Max Transfer Daily</th>
                    <td>
                        ${changes['transfer_daily']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Max Withdraw Daily</th>
                    <td>
                        ${changes['withdraw_daily']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Swithcing Max</th>
                    <td>
                        ${changes['switching_max']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Free Withdraw</th>
                    <td>
                        ${changes['free_withdraw']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Max Group Transfer</th>
                    <td>
                        ${changes['max_group_transfer']}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Max Group Withdraw</th>
                    <td>
                        ${changes['max_group_withdraw']}
                    </td>
                </tr>
                </tbody>
            `;

            // $('#report-table-req').find('#table-area').remove();
            $('#req-info').remove();
            loader_tb.destroy();
            if (!e.status) {
                alertModal.find(".modal-title > span").text("ERROR");
                alertModal.find(".modal-body").text(e.message);
                alertModal.modal("show");
                return false;
            }
            if (e.content) {
                $('#report-table-req .alert').hide();
                $('#report-table-req-body').remove();
                $('#report-table-req').append(html);
                $('#btnAction').empty();
                if(!isHistory){
                    $('#btnAction').append(`
                        <button onclick="approval(${e.content.id}, 'reject')" class="btn btn-danger">Reject</button>
                        <button onclick="approval(${e.content.id}, 'approve')" class="btn btn-primary">Approve</button>
                    `)
                }
                console.log(e);
            } else {
                $('#report-table-req .alert').show().find('.alert-text').text(e.message ? e
                    .message : 'No records found');
            }
        }).fail(function (xhr) {
            loader_tb.destroy();
            alertModal.find(".modal-title > span").text("ERROR");
            alertModal.find(".modal-body").text(xhr.responseJSON.message);
            alertModal.modal("show");
        });
    }

    function approval (id, status){
        $data = {
            _token: '{{ csrf_token() }}',
        };
        $data.id = id;
        $data.status = status;
        $.post("{{ route('wallet.emoney.limit.req.approval') }}", $data, function(e){
            $('#requestModal').modal('hide')
            var e = reqData.param();
            reqData.init(e);
            var f = reqDataHistory.param();
            reqDataHistory.init(f);
        })
    }

    var showDataDoc = function () {
        return {
            param: function () {
                var e = {};
                e.pagination = {
                    'perpage': $('#pagination-perpage').val()
                };
                e.wallet_id = $("#wallet_id").val().toLowerCase(),
                    e.startDateRegistered = $('#filterStartDate').val(),
                    e.endDateRegistered = $('#filterToDate').val();
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
                $.post("{{ route('report.req.dt') }}", $data, function (e) {
                    $('#report-req-table').find('#table-area').remove();
                    loader_tb.destroy();
                    if (!e.status) {
                        alertModal.find(".modal-title > span").text("ERROR");
                        alertModal.find(".modal-body").text(e.message);
                        alertModal.modal("show");
                        return false;
                    }
                    if (e.total_row > 0) {
                        $('#report-req-table .alert').hide();
                        $('#report-req-table').append(e.content);
                    } else {
                        $('#report-req-table .alert').show().find('.alert-text').text(e.message ? e
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

    $('#btnShowDoc').click(function () {
        var e = showDataDoc.param();
        showDataDoc.init(e);
    });
</script>
@endsection