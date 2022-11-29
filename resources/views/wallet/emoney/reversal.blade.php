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
                <!-- SIDE INFO START -->
                <div class="row">
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
                                <h5 class="card-title">Reversal fund(s) Balance</h5>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Reversal fund(s)</th>
                                            <td>
                                                <!-- TODO: add current reversal amount -->
                                                <div class="mw-100 mb-2">
                                                    <input type="text" class="form-control" placeholder="Amount" name="reversal_fund" autocomplete="off" value="0" required />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Agreement Document</th>
                                            <td>
                                                <select id="agreement_document" name="agreement_document" class="form-control selectpicker">
                                                    <!-- TODO: add document list -->
                                                    <option value="">Document</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Reason</th>
                                            <td>
                                                <textarea id="field-reason" name="reason" placeholder="Reason" rows="8" class="form-control" style="resize:none"></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>
                                            </th>
                                            <td class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-secondary">Request</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- FORM end -->

                        <!-- table 1 start -->
                        <!-- TODO: added data and pagination -->
                        <div class="card mt-2">
                            <div class="card-body">
                                <h5 class="card-title">Wallet Reversal fund(s) History</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Operator</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>test</td>
                                            <td>test</td>
                                            <td>test</td>
                                            <td>test</td>
                                            <td>test</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table 1 end -->
                        
                        <!-- table 2 start -->
                        <!-- TODO: added data and pagination -->
                            <div class="card mt-2">
                                <div class="card-body">
                                    <h5 class="card-title">List Request Wallet Reversal fund(s)</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Operator</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>test</td>
                                                <td>test</td>
                                                <td>test</td>
                                                <td>test</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <!-- table 2 end -->

                        <!-- table 3 start -->
                        <!-- TODO: added data and pagination -->
                        <div class="card mt-2">
                                <div class="card-body">
                                    <h5 class="card-title">Operator Action History</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Operator</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>test</td>
                                                <td>test</td>
                                                <td>test</td>
                                                <td>test</td>
                                                <td>test</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <!-- table 3 end -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
