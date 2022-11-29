@extends('layouts.template.app')
@section('lib_css')
<link href="{{ asset('template/plugins/custom/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template/css/datatablez.min.css') }}" rel="stylesheet" type="text/css" />


@endsection


@section('content_body')
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid mt-5">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-custom gutter-b">
        
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="fa fa-flag fa-fw text-primary"></i>
                    </span>
                    <h3 class="card-label"> {{ $page_title }} </h3>
                </div>

                <div class="card-toolbar">
                    <?php  if($detail->status != 1) : ?>
                        <a class="btn btn-info pull-right approveCashback" style="margin-right: 5px" href="javascript:void(0)" data-id="<?= (!empty($detail->id) ? $detail->id : ""); ?>">Update</i></a>
                        <a class="btn btn-success pull-right" href="<?= route('cashback.edit',['id' => $detail->id]) ?>" style="margin-right: 5px"> Edit</i></a>
                        <a class="btn btn-danger pull-right deleteCashback" style="margin-right: 5px" href="javascript:void(0)" data-id="<?= (!empty($detail->id) ? $detail->id : ""); ?>">Delete</i></a>
                        {{-- <a class="btn btn-info pull-right returnCashback" style="margin-right: 5px" href="javascript:void(0)" data-id="<?= (!empty($detail->id) ? $detail->id : ""); ?>"><i class="fa fa-file-text fa-fw"></i> Draft</a> --}}
                    <?php endif; ?>
                    <a class="btn btn-default float-right" style="float:right; margin-right: 5px" onclick="window.history.go(-1);"><i class="fa fa-arrow-left"></i> Back </a></h3>
                </div>
            </div>

            <div id="card-body">
                <div class="col-lg-12">
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
                </div>
                <div class="row mt-4">
                <!-- Details Cashback -->
                    <div class="col-md-4">
                        <div class="card card-custom gutter-b">
                               {{-- mercehnt --}}
                                <div class="card-body">
                                    <div class="table-responsive" style="padding-top:10px">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Promotion Name</th>
                                                <th><?= !empty($detail->name) ? $detail->name : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Terms</th>
                                                <th><?= !empty($detail->terms) ? $detail->terms : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Budget</th>
                                                <th><?= !empty($detail->budget) ? number_format($detail->budget) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Budget Used</th>
                                                <th><?= !empty($detail->budget_used) ? number_format($detail->budget_used) : "0" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Redeems</th>
                                                <th><?= !empty($detail->spread_count) ? $detail->spread_count.' redeems '. $detail->numrows.' users' : "0" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Total Cashback</th>
                                                <th><?= !empty($detail->percentage) ? $detail->percentage.' %' : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>From Nusapay</th>
                                                <th><?= !empty($detail->promo_fund_percentage) ? $detail->promo_fund_percentage.' %' : "0" ?></th>
                                            </tr>
                                            <tr>
                                                <th>From merchant</th>
                                                <th><?= !empty($detail->merch_fund_percentage) ? $detail->merch_fund_percentage.' %' : "0" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Max Claim / Days</th>
                                                <th><?= !empty($detail->claim_p_day) ? $detail->claim_p_day : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Max Claim / User / Days</th>
                                                <th><?= !empty($detail->claim_p_day_user) ? $detail->claim_p_day_user : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Max Claim Amount / Transaction</th>
                                                <th><?= !empty($detail->max_amount) ? number_format($detail->max_amount) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Max Claim Amount / User / Period</th>
                                                <th><?= !empty($detail->max_amount_claim_user) ? number_format($detail->max_amount_claim_user) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Max Claim Amount / User / Month</th>
                                                <th><?= !empty($detail->max_claim_p_month_user) ? number_format($detail->max_claim_p_month_user) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Periode</th>
                                                <th><?= (!empty($detail->start_date) && !empty($detail->end_date)) ? date('d M Y', strtotime($detail->start_date)).' - '.date('d M Y', strtotime($detail->end_date)) : ""; ?></th>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <th><?= ($detail->status != "") ? setPromotionStatus($detail->status) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Created By</th>
                                                <th><?= !empty($detail->created_by) ? $detail->created_by : "" ?></th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                <!-- End Details Cashback -->

                    <div class="col-md-8">
                        <?php if($detail->status != 1) : ?>
                        <!-- Publish Promotion Cashback -->
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        Publish Reedems Cashback
                                    </div>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" id="id" name="id" value="">
                                        <div class="form-group">
                                            <span for="field-status">Status Promotion Cashback</span>
                                            <select class="form-control select2-search status_kyc" id="status_kyc" name="status_kyc">
                                                    <option <?= ($detail->status == 0) ? "selected" : "" ?> value="0">Moderation</option>
                                                    <option <?= ($detail->status == 2) ? "selected" : "" ?> value="2">Delete</option>
                                                    <option <?= ($detail->status == 3) ? "selected" : "" ?> value="3">re_Draft</option>
                                                    <option <?= ($detail->status == 4) ? "selected" : "" ?> value="4">Staff Follow Up</option>
                                                    <option <?= ($detail->status == 6) ? "selected" : "" ?> value="6">On Hold</option>
                                                    <option <?= ($detail->status == 7) ? "selected" : "" ?> value="7">On Rejected</option>
                                                    <option <?= ($detail->status == 8) ? "selected" : "" ?> value="8">Draft</option>
                                                    <?php if($roles->id == 1) : ?>
                                                        <option <?= ($detail->status == 5) ? "selected" : "" ?> value="5">Request Approved</option>
                                                    <?php else : ?>
                                                        <option <?= ($detail->status == 5) ? "selected" : "" ?> value="5">Request Approved</option>
                                                        <option <?= ($detail->status == 1) ? "selected" : "" ?> value="1">Active</option>
                                                    <?php endif; ?>
                                                </select>
                                        </div>
                                        <div class="form-group StaffOnly">
                                            <span for="staff">Name Staff</span>
                                            <input type="text" hidden id="staff" name="staff" placeholder="Staff Name" class="form-control" value="{{$roles->id}}"/>
                                            <input type="text" placeholder="Staff Name" class="form-control" value="{{$roles->name}}" readonly/>
                                            <div class="staff"></div>
                                        </div>
                                        <div class="form-group">
                                            <span for="subject">Subject Reason</span>
                                            <input type="text" id="subject" name="subject" placeholder="Subject Reason" class="form-control"/>
                                            <div class="subject"></div>
                                        </div>
                                        <div class="form-group">
                                            <span for="reason">Reason</span>
                                            <textarea id="reason" name="reason" placeholder="Approve or reject Reason" rows="5" class="form-control" style="resize:none"></textarea>
                                            <div class="reason"></div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Publish Promotion Cashback -->
                        <?php endif; ?>

                        <!-- KYC History Cashback -->
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        List History KYC Promotion Cashbacks
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="datatablez table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Operator</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Reason</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php if(!empty($getKYCLog)) : ?>
                                                    <?php foreach($getKYCLog->get() as $ls) : ?>
                                                    <tr>
                                                        <td><?= isset($ls->user) ? '<i class="fa fa-user"></i> '.$ls->user : "" ?> <?= isset(json_decode($ls->content)->staff) ? ', '.json_decode($ls->content)->staff : "" ?></td>
                                                        <td><?= isset(json_decode($ls->content)->status) ? setPromotionStatus(json_decode($ls->content)->status) : "" ?></td>
                                                        <td><?= isset($ls->created) ? $ls->created : "" ?></td>
                                                        <td><?= isset(json_decode($ls->content)->reason) ? json_decode($ls->content)->reason : "" ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End KYC History Cashback -->
                    
                        <!-- History Redeems -->
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        History Reedems Cashbacks # <?= !empty($detail->name) ? $detail->name : "" ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="datatablez table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>User</th>
                                                    <th>Amount</th>
                                                    <th>Transaction Amount</th>
                                                    <th>Order Id</th>
                                                    <th>Valid Until</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php if(!empty($getCashback)) : ?>
                                                <?php $i=0; ?>
                                                <?php foreach($getCashback->get() as $ls) : ?>
                                                <tr>
                                                    <td><?= isset($ls->redeemed_at) ? $ls->redeemed_at : "" ?></td>
                                                    <td><?= isset($ls->redeemed_by) ? '<i class="fa fa-user"></i> '.$ls->redeemed_by : "" ?></td>
                                                    <td><?= isset($ls->amount) ? $ls->amount : "" ?></td>
                                                    <td><?= isset($ls->transaction_amount) ? $ls->transaction_amount : "" ?></td>
                                                    <td><?= (isset($ls->transaction_id) && isset($ls->transaction_ref)) ? $ls->transaction_id.'<br /><small>'.$ls->transaction_ref.'</small>' : "" ?></td>
                                                    <td><?= (isset($ls->redeemed_at) && isset($ls->cashout_at)) ? $ls->redeemed_at.'<br /><small>'.$ls->cashout_at.'</small>' : "" ?></td>
                                                </tr>
                                                <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End History Redeems -->
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

{{-- modal confirmasi promotion --}}
    <div id="id01" class="modal" aria-hidden="true" tabindex="-1" role="dialog"  data-backdrop="static" aria-labelledby="staticBackdrop">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="flaticon2-warning text-warning mr-2"></i>
                        <span>Confirm</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
            
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold btn-modal-cancel"
                        data-dismiss="modal">Close</button>
                    <button type="button"
                        class="btn btn-light-success font-weight-bold btn-loading btn-modal-action">Process</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('lib_js')
<script src="{{ asset('template/js/datatablez.min.js') }}"></script>
<script src="{{ asset('template/js/confirm-bootstrap.js') }}"></script>


@endsection

@section('content_js')
<script type="text/javascript">
$(document).ready(function() {
    $('.datatablez').DataTable();

    $('.approveCashback').click( function() {
        var confirmModal = $("#id01");
        
        confirmModal.find(".modal-title > span").text("Warning : Promotion Cashback Confirmation");
        confirmModal.find(".modal-body").text("Are you sure want to save this cashback request?");
        confirmModal.modal("show");
        $id = $(this).attr("data-id");

        confirmModal.find(".btn-modal-action").click(function(){
            var btn = $(this),
            initialText = btn.attr("data-initial-text"),
            loadingText = btn.attr("data-loading-text");

            var id = $id;
            var status = $('#status_kyc').val();
            var staff = $('#staff').val();
            var subject = $('#subject').val();
            var reason = $('#reason').val();

            console.log(id,status,staff,subject,reason);

            btn.html(loadingText).addClass("disabled").prop("disabled",true);
            $.post("{{route('cashback.approve')}}",{_token:'{{ csrf_token() }}', id: id ,status : status ,staff : staff,subject: subject,reason: reason}, function(e){
                confirmModal.modal("hide");
                if(!e.status){
                    alertModal.find(".modal-title > span").text("ERROR");
                    alertModal.find(".modal-body").text(e.message);
                    alertModal.modal("show");
                    return false;
                }
                console.log(e);
                alertModal.find(".modal-title > span").text("INFO");
                alertModal.find(".modal-body").text(e.message);
                alertModal.find(".btn-modal-cancel").removeAttr("data-dismiss");
                alertModal.modal("show");

                location.reload();

                alertModal.find(".btn-modal-cancel").click(function(){
                    document.location.reload();
                });
            }).fail(function(xhr) {
                confirmModal.modal("hide");
                alertModal.find(".modal-title > span").text("ERROR");
                alertModal.find(".modal-body").text(xhr.responseJSON.message);
                alertModal.modal("show");
            },'json');
        });
    });

});

</script>
@endsection
