@extends('layouts.template.app')

@section('content_body')
<div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Transfer Blacklist</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->
            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="{{ URL::previous() }}" class="btn btn-primary font-weight-bold">Back</a>
                <!--end::Button-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
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
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Resume IDR · E-Money</h5>
                                <div class="col-md-12">
                                    <strong class="roboto">Balance</strong>
                                    <div>
                                        {{ number_format($wallet_summary->balance, 0, ',', '.') }} /
                                        {{ number_format($wallet_summary->max_balance, 0, ',', '.') }} </div>
                                    <div class="progress progress-lg m-t-xs">
                                        <div class="progress-bar progress-bar-info progress-bar-striped active"
                                            role="progressbar" aria-valuenow="95.53" aria-valuemin="0"
                                            aria-valuemax="100"
                                            style="width: <?= $wallet_summary->balance / $wallet_summary->max_balance * 100; ?>%;">
                                            <span class="sr-only">95.53%</span>
                                        </div>
                                    </div>
                                    <strong class="roboto">Monthly Transaction IN</strong>
                                    <div>
                                        {{ number_format($wallet_summary->sum_transaction_in, 0, ',', '.') }} /
                                        {{ number_format($wallet_summary->transaction_monthly, 0, ',', '.') }} </div>
                                    <div class="progress progress-lg m-t-xs">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped active"
                                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                            style="width: <?= $wallet_summary->sum_transaction_in / $wallet_summary->transaction_monthly * 100; ?>%">
                                            <span class="sr-only">0%</span>
                                        </div>
                                    </div>

                                    <!--                          DEPRECATEDD REMOVE SOON -->
                                    <strong class="roboto">Monthly Transaction OUT</strong>
                                    <div>
                                        {{$wallet_summary->sum_transaction_out ? number_format($wallet_summary->sum_transaction_out, 0, ',', '.') : 0}}
                                        / ~
                                    </div>
                                    <div class="progress progress-lg m-t-xs">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped active"
                                            role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 100%">
                                            <span class="sr-only">100%</span>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Reversal </th>
                                                <td>IDR 0</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Fund(s)</th>
                                                <td>IDR 0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Transfer Blacklist</h5>
                                <form>
                                    @if (isset($id))
                                        <input type="hidden" name="wallet_id" id="wallet_id" value="{{$id}}">
    
                                    @endif
                                    @if (isset($user_info))
                                        <input type="hidden" name="user_id" id="user_id" value="{{$user_info->id}}">

                                    @endif
                                    <div class="form-group">
                                        <label for="search_user">Search User Nusapay</label>
                                        <input class="typeahead form-control" name="search_user" id="search_user" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="search_user">Name : <span id="name"></span></label>
                                        <br>
                                        <label for="search_user">Phone : <span id="phone"></span></label>
                                        <span id="target_user_id" hidden></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="document">Agreement Document</label>
                                                    <input type="text" id="document" name="document"
                                                        placeholder="Document Numbers" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="btnFindDoc">&nbsp;</label>
                                                    <button type="button" class="btn btn-success form-control"
                                                        data-toggle="modal" data-target="#DocumentData">Find
                                                        Document</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="field-reason">Reason</label>
                                        <textarea id="field-reason" class="form-control" name="reason"
                                            placeholder="Reason" rows="5"></textarea>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="hidden" name="wallet_type" value="">
                                        <button type="button"
                                            class="btn btn-secondary HandlingAdjustWallet" id="btnSave">Request</button>

                                    </div>
                                </form>
                            </div>
                        </div>
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
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
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
        </div>

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
    </div>
</div>
@endsection

@section('content_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content_js')
<script
    src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
    integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0="
    crossorigin="anonymous"></script>
<script>
    var addTransferBlackList = function () {
        return {
            param: function () {
                var e = {};
                    e.name = $('#name').text(),
                    e.phone = $('#phone').text(),
                    e.user_id = $('#user_id').val(),
                    e.document = $("#document").val(),
                    e.reason = $("#field-reason").val(),
                    e.target = $("#target_user_id").text(),
                    e.wallet_id = $("#wallet_id").val().toLowerCase();
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
                console.log($params);
                $.post("{{ route('wallet.emoney.tf.blacklist.add') }}", $data, function (e) {
                    // TODO: ganti
                    console.log(e);
                    $('#notifSuccess').find(".toast-body").text("Update Lock Wallet Success");
                    $('#notifSuccess').toast('show');
                }).fail(function (xhr) {
                    loader_tb.destroy();
                    alertModal.find(".modal-title > span").text("ERROR");
                    alertModal.find(".modal-body").text(xhr.responseJSON.message);
                    alertModal.modal("show");
                });
            }
        }
    }();

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
                    // TODO: add feedback
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

    $('#btnSave').click(function () {
        var e = addTransferBlackList.param();
        addTransferBlackList.init(e);
    });

    $( "#search_user" ).autocomplete({
        source: function( request, response ) {
            console.log(request.term);
            // Fetch data
            $.ajax({
            url:"{{route('wallet.emoney.tf.blacklist.list.user')}}",
            type: 'post',
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                search: request.term
            },
            success: function( data ) {
                response( data );
            }
            });
        },
        select: function (event, ui) {
            // Set selection
            $('#search_user').val(ui.item.label); // display the selected text
            $('#name').text(ui.item.name)
            $('#phone').text(ui.item.phone)
            $('#target_user_id').text(ui.item.id)
            return false;
        }
    });

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
                $.post("{{ route('wallet.emoney.tf.blacklist.req.table') }}", $data, function (e) {
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

    $(function () {
        var e = reqData.param();
        reqData.init(e);

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

    function actionApprove (id, isHistory = false) {
        $data['id'] = id;
        $.post("{{ route('wallet.setting.get') }}", $data, function (e) {
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
                    <th scope="row">User Id</th>
                    <td>
                        ${changes.user_id}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Target User</th>
                    <td>
                        ${changes.target_id}
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
                if(e.content.status == 2){
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
        $.post("{{ route('wallet.emoney.tf.blacklist.req.approval') }}", $data, function(e){
            console.log(e);
            $('#requestModal').modal('hide')
            var e = reqData.param();
            reqData.init(e);
        })
    }

</script>
@endsection
