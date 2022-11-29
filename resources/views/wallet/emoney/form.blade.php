@extends('layouts.template.app')

@section('content_body')
<div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Wallet E-Money Information</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->
            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="{{ route('wallet-emoney') }}" class="btn btn-primary font-weight-bold">Back</a>
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
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Today Transaction</h5>
                                <table class="table">
                                    <tbody>
                                        @foreach ($today_transaction as $val)
                                        <tr>
                                            <th scope="row">{{$val->transaction_type}}</th>
                                            <td>{{$val->count}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Wallet Limit</h5>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Balance</th>
                                            <td class="text-right">
                                                {{ number_format($wallet_limit->max_balance, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Monthly Transaction</th>
                                            <td class="text-right">
                                                {{ number_format($wallet_limit->transaction_monthly, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Withdraw Daily</th>
                                            <td class="text-right">
                                                {{ number_format($wallet_limit->withdraw_daily, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Transfer Daily</th>
                                            <td class="text-right">
                                                {{ number_format($wallet_limit->transfer_daily, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Payment Daily</th>
                                            <td class="text-right">
                                                {{ number_format($wallet_limit->payment_daily, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Topup Daily</th>
                                            <td class="text-right">
                                                {{ number_format($wallet_limit->topup_daily, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Max Switching</th>
                                            <td class="text-right">
                                                {{ number_format($wallet_limit->switching_max, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Free Withdraw</th>
                                            <td class="text-right">{{ $wallet_limit->free_withdraw }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Max Transfer Group</th>
                                            <td class="text-right">{{ $wallet_limit->max_group_transfer }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Max Withdraw Group</th>
                                            <td class="text-right">{{ $wallet_limit->max_group_withdraw }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Latest Transaction</h5>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="align-middle text-center">Type</th>
                                                <th class="align-middle text-center">Amount</th>
                                                <th class="align-middle text-center">Balance</th>
                                                <th class="text-center">Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($latest_transaction as $val)
                                            <tr class="daily-report pointer">
                                                <td class="text-center">
                                                    {{ $val->transaction_type }}
                                                    <br>
                                                    @if ($val->status == 0)
                                                    <span class="text-danger">Deleted</span>
                                                    @elseif ($val->status == 1)
                                                    <span class="text-warning">Canceled</span>
                                                    @elseif ($val->status == 2)
                                                    <span class="text-primary">Pending</span>
                                                    @elseif ($val->status == 3)
                                                    <span class="text-success">Success</span>
                                                    @endif
                                                </td>
                                                <td class="text-right align-middle">IDR
                                                    {{ number_format($val->amount, 2, ',', '.') }}</td>
                                                <td class="text-right align-middle">IDR
                                                    {{ number_format($val->balance, 2, ',', '.') }}</td>
                                                <td class="text-center align-middle">
                                                    {{ $val->created_at }}
                                                    <br>
                                                    <small class="text-muted">Updated: {{$val->updated_at}}</small>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{route('wallet-history', ['wallet' => $id])}}">
                                    <p class="text-right">
                                        More <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Transfer Circle</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
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
                                <h5 class="card-title">Lock Feature</h5>
                                <form>
                                    @if (isset($id))
                                    <input type="hidden" name="wallet_id" id="wallet_id" value="{{$id}}">

                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lock_in">In</label>
                                                <select id="lock_in" name="lock_in" placeholder="In"
                                                    class="form-control" tabindex="-98">
                                                    <option value="0" {{$info->lock_in == 0 ? "selected": ""}}>Active
                                                    </option>
                                                    <option value="1" {{$info->lock_in == 1 ? "selected": ""}}>Locked
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lock_out">Out</label>
                                                <select id="lock_out" name="lock_out" placeholder="Out"
                                                    class="form-control" tabindex="-98">
                                                    <option value="0" {{$info->lock_out == 0 ? "selected": ""}}>Active
                                                    </option>
                                                    <option value="1" {{$info->lock_out == 1 ? "selected": ""}}>Locked
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lock_wd">Withdraw</label>
                                                <select id="lock_wd" name="lock_wd" placeholder="Withdraw"
                                                    class="form-control" tabindex="-98">
                                                    <option value="0" {{$info->lock_wd == 0 ? "selected": ""}}>Active
                                                    </option>
                                                    <option value="1" {{$info->lock_wd == 1 ? "selected": ""}}>Locked
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lock_tf">Transfer</label>
                                                <select id="lock_tf" name="lock_tf" placeholder="Transfer"
                                                    class="form-control" tabindex="-98">
                                                    <option value="0" {{$info->lock_tf == 0 ? "selected": ""}}>Active
                                                    </option>
                                                    <option value="1" {{$info->lock_tf == 1 ? "selected": ""}}>Locked
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lock_pm">Payment</label>
                                        <select id="lock_pm" name="lock_pm" placeholder="Payment" class="form-control"
                                            tabindex="-98">
                                            <option value="0" {{$info->lock_pm == 0 ? "selected": ""}}>Active</option>
                                            <option value="1" {{$info->lock_pm == 1 ? "selected": ""}}>Locked</option>
                                        </select>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="list-group">
                                <a class="list-group-item" href="{{route('wallet.emoney.reversal', ['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Adjustment Reversal fund(s)</strong>
                                    </h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">For release Reversal
                                        funds from user</p>
                                </a>
                                <a class="list-group-item" href="{{route('wallet.emoney.limit', ['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Set Wallet Limit</strong></h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">Change limit wallet
                                        like In,Out,Transfer Fee etc</p>
                                </a>
                                <a class="list-group-item" href="{{route('wallet.emoney.switch', ['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Set Switching Fee</strong></h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">Specific price for user
                                        for bank switching</p>
                                </a>
                                <a class="list-group-item" href="{{route('wallet.emoney.wd.blacklist',['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Withdraw Blacklist</strong></h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">Restrict withdraw to
                                        specific account</p>
                                </a>
                                <a class="list-group-item" href="{{route('wallet.emoney.tf.blacklist',['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Transfer Blacklist</strong></h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">Restrict transfer to
                                        specific</p>
                                </a>
                                <a class="list-group-item" href="{{route('wallet.emoney.adjustment',['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Add Adjustment</strong></h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">Adjust wallet balance,
                                        will also increase the monthly limit in</p>
                                </a>
                                <a class="list-group-item" href="{{route('wallet.emoney.withdraw.fee',['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Withdraw Fee</strong></h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">Specific price for
                                        withdraw</p>wallet.emoney.withdraw.fee
                                </a>
                                <a class="list-group-item"
                                    href="{{route('wallet.emoney.return.adjustment',['id' => $id])}}">
                                    <h4 class="list-group-item-heading"><strong>Add Return Adjustment</strong></h4>
                                    <p class="list-group-item-text" style="margin-top:10px;">Will undo the amount of
                                        adjustment before, this action will decreasing monhtly limit in</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
</div>
@endsection

@section('content_js')
<script>
    var updateLock = function () {
        return {
            param: function () {
                var e = {};
                e.lock_in = $("#lock_in").val().toLowerCase(),
                    e.lock_out = $("#lock_out").val().toLowerCase(),
                    e.lock_wd = $("#lock_wd").val().toLowerCase(),
                    e.lock_tf = $("#lock_tf").val().toLowerCase(),
                    e.lock_pm = $("#lock_pm").val().toLowerCase(),
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
                $.post("{{ route('wallet.emoney.update.lock') }}", $data, function (e) {
                    
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
                }).fail(function (xhr) {
                    loader_tb.destroy();
                    alertModal.find(".modal-title > span").text("ERROR");
                    alertModal.find(".modal-body").text(xhr.responseJSON.message);
                    alertModal.modal("show");
                });
            }
        }
    }();

    $('#btnSave').click(function () {
        var e = updateLock.param();
        updateLock.init(e);
    });
    
    $(function () {
        $("#success-alert").hide();
        $("#failed-alert").hide();
    });
</script>
@endsection
