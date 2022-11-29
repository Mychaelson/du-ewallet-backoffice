@extends('layouts.template.app')

@section('content_body')
<div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Wallet Adjustment</h5>
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
                                <h5 class="card-title">Wallet Adjustment</h5>
                                <form>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select class="form-control" name="type" id="type"> 
                                                        <option value="Decrease">Decrease</option>
                                                        <option value="Increase">Increase</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-amount">Amount</label>
                                                    <input type="number" id="field-amount" name="amount"
                                                        placeholder="Amount" mdec="0" class="auto form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="document">Agreement Document</label>
                                        <input type="text" id="document" name="document" placeholder="Document Numbers"
                                            class="form-control" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="field-description">Description</label>
                                        <textarea id="field-description" class="form-control" name="description"
                                            placeholder="Description" rows="5"></textarea>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="hidden" name="wallet_type" value="">
                                        <button type="button"
                                            class="btn btn-default HandlingAdjustWallet">Request</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List Request Wallet Adjustment</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="align-middle text-center">Operator</th>
                                                <th class="align-middle text-center">Description</th>
                                                <th class="align-middle text-center">Balance</th>
                                                <th class="align-middle text-center">Status</th>
                                                <th class="align-middle text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Adjustment History</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="align-middle text-center">Operator</th>
                                                <th class="align-middle text-center">Description</th>
                                                <th class="align-middle text-center">Spending</th>
                                                <th class="align-middle text-center">Amount</th>
                                                <th class="align-middle text-center">Balance</th>
                                                <th class="align-middle text-center">Status</th>
                                                <th class="align-middle text-center">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
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

    $('#btnSave').click(function () {
        var e = updateLock.param();
        updateLock.init(e);
    });

</script>
@endsection
