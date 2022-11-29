@extends('layouts.template.app')
@section('lib_css')
<link href="{{ asset('template/plugins/custom/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template/plugins/custom/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('template/css/viewer.min.css') }}" rel="stylesheet" type="text/css" />


@endsection


@section('content_body')
 <!--begin::Entry-->
 <div class="d-flex flex-column-fluid mt-5">
    <!--begin::Container-->
    <div class="container-fluid">
        
        <form method="POST" action="<?= (isset($detail)) ? route('cashback.update',['id' => $detail->id]) : route('cashback.save') ?>">
            @csrf
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="fa fa-flag fa-fw text-primary"></i>
                        </span>
                        <h3 class="card-label"> {{ $page_title }} </h3>
                    </div>
                        
                    <div class="card-toolbar">
                        @if($page->mod_action_roles($mod_alias, 'create'))
                        <button type="submit" class="btn btn-sm btn-warning font-weight-bold">
                            <i class="flaticon2-hourglass-1"></i>Save
                        </button>
                        @endif
                        <a href="<?= (isset($detail)) ? route('cashback.detail',['id' => $detail->id]) : route('cashback') ?>" class="btn btn-sm btn-danger font-weight-bold ml-2"><i class="fa fa-arrow-left"></i> Cancel</a>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>General Information</h4>
                                            <input type="hidden" id="id" name="id" value="<?= (isset($detail->id) && !empty($detail->id)) ? $detail->id : "" ?>">
                                            <div class="form-group">
                                                <label for="promotion_name">Promotion Name</label>
                                                <input type="text" class="form-control" id="promotion_name" name="promotion_name" placeholder="Promotion Name" value="<?= (isset($detail->name) && !empty($detail->name)) ? $detail->name : "" ?>" required>
                                                <div class="promotion_name"></div>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="merchant">Merchant</label>
                                                <select id="merchant" name="merchant" class="form-control select2-search">
                                                    <option value="" >-- Select Merchant --</option>
                                                </select>
                                            </div><br/> --}}
                                            <div class="form-group">
                                                <label for="terms">Terms</label>
                                                <textarea rowspan="5" type="text" class="form-control" id="terms" name="terms" placeholder="Terms" required><?= (isset($detail->terms) && !empty($detail->terms)) ? $detail->terms : "" ?></textarea>
                                                <div class="terms"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Budget</h4>
                                            <div class="form-group">
                                                <label for="budget">Budget</label>
                                                <input type="text" class="form-control" id="budget" name="budget" placeholder="Budget" value="<?= (isset($detail->budget) && !empty($detail->budget)) ? $detail->budget : "" ?>" required>
                                                <div class="budget"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="switch">
                                                    <input type="checkbox" name="show_persentage" onclick='handleClick(this);' class="js-switch switch showPercn" value="">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="total_promotion">Total Cashback Percentage</label>
                                                <input type="number" class="form-control" id="total_promotion" name="total_promotion" placeholder="% Total promotion" value="<?= (isset($detail->percentage) && !empty($detail->percentage)) ? $detail->percentage : "" ?>" required>
                                                <div class="total_promotion"></div>
                                            </div>
                                            <div class="show_percentage">
                                                <div class="form-group">
                                                    <label for="percnt_yamisok">Percentage from Yamisok</label>
                                                    <input type="number" class="form-control" id="percnt_yamisok" name="percnt_yamisok" placeholder="% from Yamisok" value="<?= (isset($detail->promo_fund_percentage) && !empty($detail->promo_fund_percentage)) ? $detail->promo_fund_percentage : "" ?>">
                                                    <div class="percnt_yamisok"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="percnt_merchant">Percentage from Merchant</label>
                                                    <input type="number" class="form-control" id="percnt_merchant" name="percnt_merchant" placeholder="% from Merchant" value="<?= (isset($detail->merch_fund_percentage) && !empty($detail->merch_fund_percentage)) ? $detail->merch_fund_percentage : "" ?>">
                                                    <div class="percnt_merchant"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Claim</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="claim_day">Maximum Claim / Day</label>
                                            <input type="text" class="form-control" id="claim_day" name="claim_day" placeholder="Max Claim / Day" value="<?= (isset($detail->claim_p_day) && !empty($detail->claim_p_day)) ? $detail->claim_p_day : "" ?>" required>
                                            <div class="claim_day"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="claim_usr_day">Maximum Claim / User / Day</label>
                                            <input type="text" class="form-control" id="claim_usr_day" name="claim_usr_day" placeholder="Max Claim / User / Day" value="<?= (isset($detail->claim_p_day_user) && !empty($detail->claim_p_day_user)) ? $detail->claim_p_day_user : "" ?>" required>
                                            <div class="claim_usr_day"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="claim_transaction">Maximum Claim Amount / Transaction</label>
                                            <input type="text" class="form-control" id="claim_transaction" name="claim_transaction" placeholder="Max Claim / Transaction" value="<?= (isset($detail->max_amount) && !empty($detail->max_amount)) ? $detail->max_amount : "" ?>" required>
                                            <div class="claim_transaction"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="claim_usr_period">Maximum Claim Amount / User / Period</label>
                                            <input type="text" class="form-control" id="claim_usr_period" name="claim_usr_period" placeholder="Max Claim / User / Period" value="<?= (isset($detail->max_amount_claim_user) && !empty($detail->max_amount_claim_user)) ? $detail->max_amount_claim_user : "" ?>" required>
                                            <div class="claim_usr_period"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="claim_user_month">Maximum Claim Count / User / Month</label>
                                            <input type="text" class="form-control" id="claim_user_month" name="claim_user_month" placeholder="Max Claim / Month / by User" value="<?= (isset($detail->max_claim_p_month_user) && !empty($detail->max_claim_p_month_user)) ? $detail->max_claim_p_month_user : "" ?>" required>
                                            <div class="claim_user_month"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Period</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="date_from">From</label>
                                            <div class="input-group">
                                                <input type="text" class="datetime-pickers form-control" autocomplete="off" value="<?= (isset($detail->start_date) && !empty($detail->start_date)) ? $detail->start_date : "" ?>" id="date_from" name="date_from" placeholder="Select Date" required>
                                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="date_to">To</label>
                                            <div class="input-group">
                                                <input type="text" class="datetime-pickers form-control" autocomplete="off" value="<?= (isset($detail->end_date) && !empty($detail->end_date)) ? $detail->end_date : "" ?>" id="date_to" name="date_to" placeholder="Select Date" required>
                                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
@section('lib_js')
<script src="{{ asset('template/plugins/custom/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/plugins/custom/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('template/js/viewer.min.js') }}"></script>
<script src="{{ asset('template/plugins/custom/datetimepicker/jquery.datetimepicker.js') }}"></script>

@endsection

@section('content_js')
<script type="text/javascript">
$(document).ready(function() {
    $('.show_percentage').hide();

    $('.datetime-pickers').datetimepicker({
        orientation: "top auto",
        format : "Y-m-d H:i:s",
        autoclose: true
    });
});
    function handleClick(cb) {
      if(cb.checked){
        $(this).parent().fadeTo('slow', 0.5)
        $('#total_promotion').attr('readonly', true)
        $('.show_percentage').show()
      }else{
        $(this).parent().fadeTo('slow', 1)
        $('#total_promotion').removeAttr('readonly', false)
        $('.show_percentage').hide()
      }
    };

</script>
@endsection
