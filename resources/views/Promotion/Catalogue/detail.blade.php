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
                        <a class="btn btn-info pull-right approveCatalogue" style="margin-right: 5px" href="javascript:void(0)" data-id="<?= (!empty($detail->id) ? $detail->id : ""); ?>">Update</i></a>
                        <a class="btn btn-success pull-right" href="<?= route('catalogue.edit',['id' => $detail->id]) ?>" style="margin-right: 5px"> Edit</i></a>
                        <a class="btn btn-danger pull-right deleteCatalogue" style="margin-right: 5px" href="javascript:void(0)" data-id="<?= (!empty($detail->id) ? $detail->id : ""); ?>">Delete</i></a>
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
                                                <th>Catalogue Name</th>
                                                <th><?= !empty($detail->name) ? $detail->name : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Slug</th>
                                                <th><?= !empty($detail->slug) ? $detail->slug : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <th><?= !empty($detail->description) ? $detail->description : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Terms</th>
                                                <th><?= !empty($detail->terms) ? $detail->terms : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Point</th>
                                                <th><?= !empty($detail->point) ? $detail->point : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Max Coupon</th>
                                                <th><?= !empty($detail->quantity) ? $detail->quantity : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Coupon Value</th>
                                                <th><?= !empty($detail->item_value) ? number_format($detail->item_value) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Image</th>
                                                <th><?= !empty(json_decode($detail->images)[0]) ? '<img class="img-thumbnail rounded" style="width: 200px;" src="'.json_decode($detail->images)[0].'">' : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Periode</th>
                                                <th><?= (!empty($detail->start_at) && !empty($detail->end_at)) ? date('d M Y', strtotime($detail->start_at)).' - '.date('d M Y', strtotime($detail->end_at)) : ""; ?></th>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <th><?= ($detail->status != "") ? setCatalogueStatusLabel($detail->status) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Created By</th>
                                                <th><?= !empty($detail->operator) ? $detail->operator : "" ?></th>
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
                                    <div class="card-header ">
                                        <div class="card-title">
                                            Publish Catalog 
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="id" name="id" value="{{$detail->id}}">
                                        <div class="form-group">
                                            <span for="field-status">Status Promotion Cashback</span>
                                            <select class="form-control select2-search status_kyc" id="status_kyc" name="status_kyc">
                                                    <option <?= ($detail->status == 0) ? "selected" : "" ?> value="0">Draft</option>
                                                    <option <?= ($detail->status == 1) ? "selected" : "" ?> value="1">Active</option>
                                                    <option <?= ($detail->status == 2) ? "selected" : "" ?> value="2">Delete</option>
                                                    <option <?= ($detail->status == 3) ? "selected" : "" ?> value="3">re_Draft</option>
                                                    <option <?= ($detail->status == 4) ? "selected" : "" ?> value="4">Staff Follow Up</option>
                                            </select>
                                        </div>
                                        <div class="form-group StaffOnly">
                                            <span for="staff">Name Staff</span>
                                            <input type="hidden" id="staff" name="staff" placeholder="Staff Name" class="form-control" value="{{$roles->id}}"/>
                                            <input type="text" name="staff" placeholder="Staff Name" class="form-control" value="{{$roles->name}}" readonly/>
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
                                <div class="card-header ">
                                    <div class="card-title">
                                        List History KYC Catalog Promotion
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
                                                    <?php $i=0; ?>
                                                    <?php foreach($getKYCLog->get() as $ls) : ?>
                                                    <tr>
                                                        <td><?= isset($ls->user) ? '<i class="fa fa-user"></i> '.$ls->user : "" ?> <?= isset(json_decode($ls->content)->staff) ? ', '.json_decode($ls->content)->staff : "" ?></td>
                                                        <td><?= isset(json_decode($ls->content)->status) ? setMissionStatus(json_decode($ls->content)->status) : "" ?></td>
                                                        <td><?= isset($ls->created) ? $ls->created : "" ?></td>
                                                        <td><?= isset(json_decode($ls->content)->reason) ? json_decode($ls->content)->reason : "" ?></td>
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
                        <!-- End KYC History Cashback -->
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

    $('.approveCatalogue').click( function() {
        var confirmModal = $("#id01");
        
        confirmModal.find(".modal-title > span").text("Warning : Promotion Catalogue Confirmation");
        confirmModal.find(".modal-body").text("Are you sure want to save this catalogue request?");
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
            $.post("{{route('catalogue.approve')}}",{_token:'{{ csrf_token() }}', id: id ,status : status ,staff : staff,subject: subject,reason: reason}, function(e){
                confirmModal.modal("hide");
                if(!e.status){
                    confirmModal.find(".modal-title > span").text("ERROR");
                    confirmModal.find(".modal-body").text(e.message);
                    confirmModal.modal("show");
                    return false;
                }
                console.log(e);
                confirmModal.find(".modal-title > span").text("INFO");
                confirmModal.find(".modal-body").text(e.message);
                confirmModal.find(".btn-modal-cancel").removeAttr("data-dismiss");
                confirmModal.modal("show");

                location.reload();

                confirmModal.find(".btn-modal-cancel").click(function(){
                    document.location.reload();
                });
            }).fail(function(xhr) {
                confirmModal.modal("hide");
                confirmModal.find(".modal-title > span").text("ERROR");
                confirmModal.find(".modal-body").text(xhr.responseJSON.message);
                confirmModal.modal("show");
            },'json');
        });
    });

    $('.deleteCatalogue').click(function(){
        $id = $(this).data('id');
        var confirmModal = $("#id01");
        confirmModal.find(".modal-title > span").text("Warning : Promotion Catalogue Confirmation");
        confirmModal.find(".modal-body").text("Are you sure want to Delete this catalogue request?");
        confirmModal.modal("show");

        confirmModal.find(".btn-modal-action").click(function(){
            var btn = $(this),
            initialText = btn.attr("data-initial-text"),
            loadingText = btn.attr("data-loading-text");

            var id = [$id];
            btn.html(loadingText).addClass("disabled").prop("disabled",true);
            $.post("{{route('catalogue.delete')}}",{_token:'{{ csrf_token() }}', id: id }, function(e){
                confirmModal.modal("hide");
                if(!e.status){
                    confirmModal.find(".modal-title > span").text("ERROR");
                    confirmModal.find(".modal-body").text(e.message);
                    confirmModal.modal("show");
                    return false;
                }
                window.location.href = "{{ route('catalogue')}}";

            }).fail(function(xhr) {
                confirmModal.modal("hide");
                confirmModal.find(".modal-title > span").text("ERROR");
                confirmModal.find(".modal-body").text(xhr.responseJSON.message);
                confirmModal.modal("show");
            },'json');
        });
    });

   

});
function handleClick(cb) {
      if(cb.checked){
        $(this).parent().fadeTo('slow', 0.5)
        $('#switch_mission').val(2);
      }else{
        $(this).parent().fadeTo('slow', 1)
        $('#switch_mission').val(1);
    }
    };

</script>
@endsection
