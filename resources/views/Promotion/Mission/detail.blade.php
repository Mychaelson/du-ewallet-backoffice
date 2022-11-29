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
                        <a class="btn btn-info pull-right approveMission" style="margin-right: 5px" href="javascript:void(0)" data-id="<?= (!empty($detail->id) ? $detail->id : ""); ?>">Update</i></a>
                        <a class="btn btn-success pull-right" href="<?= route('mission.edit',['id' => $detail->id]) ?>" style="margin-right: 5px"> Edit</i></a>
                        <a class="btn btn-danger pull-right deleteMission" style="margin-right: 5px" href="javascript:void(0)" data-id="<?= (!empty($detail->id) ? $detail->id : ""); ?>">Delete</i></a>
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
                                                <th>Description</th>
                                                <th><?= !empty($detail->description) ? $detail->description : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Terms</th>
                                                <th><?= !empty($detail->terms) ? $detail->terms : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Count All Mission</th>
                                                <th><?= !empty($detail->tot_mission) ? $detail->tot_mission.' mission' : "0 mission" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Count User Joined</th>
                                                <th><?= !empty($detail->user_join) ? $detail->user_join.' mission' : "0 mission" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Count Complete Mission</th>
                                                <th><?= !empty($detail->complete_mission) ? $detail->complete_mission.' mission' : "0 mission" ?></th>
                                            </tr>
                                            <!-- <tr>
                                                <th>Redemtion Note</th>
                                                <th><?= !empty($detail->redemption_note) ? $detail->redemption_note : "" ?></th>
                                            </tr> -->
                                            <tr>
                                                <th>Point</th>
                                                <th><?= !empty($detail->point) ? $detail->point : "0" ?></th>
                                            </tr>
                                            <!-- <tr>
                                                <th>Coupon Payment</th>
                                                <th><?= !empty($detail->coupon_as_payment) ? $detail->coupon_as_payment : "" ?></th>
                                            </tr> -->
                                            <tr>
                                                <th>Quantity</th>
                                                <th><?= !empty($detail->quantity) ? number_format($detail->quantity) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Item Value</th>
                                                <th><?= !empty($detail->item_value) ? number_format($detail->item_value) : "" ?></th>
                                            </tr>
                                            <tr>
                                                <th>Image</th>
                                                <th><?= !empty($detail->images) ? '<img class="img-thumbnail rounded" style="width: 200px;" src="'.json_decode($detail->images)[0].'">' : "" ?></th>
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
                                            Publish Catalog Mission
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="id" name="id" value="">
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
                                <div class="card-header">
                                    <div class="card-title">
                                        List History KYC Catalog Mission
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
                    
                        <!-- History Redeems -->
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                            List Mission <?= !empty($detail->name) ? '#'.$detail->name : "" ?>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-success pull-right addListMission" data-title="<?= !empty($detail->name) ? $detail->name : '' ?>" data-toggle="modal" data-target="#create-modal"><i class="fa fa-plus"></i> Create</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="datatablez table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Description</th>
                                                    <th>Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                
                                            <tbody>
                                                <?php if(!empty($list_mission)) : ?>
                                                    <?php $i=0; ?>
                                                    <?php foreach($list_mission->get() as $ls) : ?>
                                                    <?php $no = $i + 1; ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= isset($ls->description) ? $ls->description : "" ?></td>
                                                        <td><?= isset($ls->mission_type) ? setMissionListStatus($ls->mission_type) : "" ?></td>
                                                        <td>
                                                            <a class="btn btn-default btn-sm getupdateMission" data-id="<?= $ls->id ?>" data-title="<?= !empty($detail->name) ? $detail->name : '' ?>" data-toggle="modal" ><i class="fa fa-edit"></i></a>
                                                            <a class="btn btn-danger btn-sm deleteListMission" data-caid="<?= !empty($detail->id) ? $detail->id : "" ?>" data-id="<?= $ls->id ?>"><i class="fa fa-trash"></i></a>
                                                        </td>
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
{{-- modal add list mission --}}
    <div class="modal fade create-modal in" id="create-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="flaticon2-add text-success mr-2"></i>
                        <span>New Mission <?= !empty($detail->name) ? '#'.$detail->name : "" ?></span>
                    </h5>
                </div>
                <form class="form-horizontal" method="POST" id="modal_misssion" action="{{route("mission.addlistmission") }}">
                    @csrf
                    <div class="modal-body">
                        <div class="card card-custom gutter-b">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6" style="margin-bottom: 30px;">
                                        <h4>General Information</h4>
                                        <div class="form-horizontal" style="margin-top: 10px;">
                                            <label for="description">Description</label>
                                            <input type="text" class="form-control description" id="description" name="description" placeholder="Mission Short Description" value="" required>
                                            <div class="description_allert"></div>
                                        </div>
                                        <div class="form-horizontal" style="margin-top: 10px;">
                                            <label for="mission_count_needed">Mission Count Needed</label>
                                            <input type="number" class="form-control mission_count_needed" id="mission_count_needed" name="mission_count_needed" placeholder="(n) Action to Complete" value="" required>
                                            <div class="mission_count_needed_allert"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Type</h4>
                                        <div class="form-horizontal" style="margin-top: 10px;">
                                            <label for="switch_mission" class="switch_mission_label switch">Mission Type : Activity</label>
                                            <label class="switch">
                                                <input type="checkbox" name="switch_mission" id="switch_mission" onclick='handleClick(this);' class="js-switch switch showPercn" value="1">
                                                <span class="slider round"></span>
                                            </label>
                                            <input type="hidden" id="type" name="type" class="switchMission" value="1">
                                        </div>
                                        <div class="form-horizontal" style="margin-top: 10px;">
                                            <label for="activity" class="activity-label">Activity Name</label>
                                            <input type="text" class="form-control activity" id="activity" name="activity" placeholder="Activity Name" required>
                                            <div class="activity_allert"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="caid" name="caid" value="<?= !empty($detail->id) ? $detail->id : "" ?>" />
                        <input type="hidden" id="idmission" name="id" class="id" value="" />
                        <button type="submit" id="setParamGroup" class="btn btn-info HandlingError btnSubmit">Create</button>
                        <button type="button" class="btn btn-default btn-modal-cancel" data-dismiss="modal">Close</button>
                    </div>
                </form>
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
    $('#modal_misssion').attr('action','{{route("mission.addlistmission") }}');

    $('.approveMission').click( function() {
        var confirmModal = $("#id01");
        
        confirmModal.find(".modal-title > span").text("Warning : Promotion Mission Confirmation");
        confirmModal.find(".modal-body").text("Are you sure want to save this mission request?");
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
            $.post("{{route('mission.approve')}}",{_token:'{{ csrf_token() }}', id: id ,status : status ,staff : staff,subject: subject,reason: reason}, function(e){
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

    $('.addListMission').click(function () {
        var confirmModal = $("#create-modal");  
        confirmModal.modal("show");
    });
    
    $('.getupdateMission').click(function () {
        var confirmModal = $("#create-modal");  
        $id = $(this).attr('data-id');
        var url = '{{route("mission.editmission", ["id" => ":id"])}}';
        url = url.replace(':id', $id);
        $.get(url, function(e){
            
            if(!e.status){
                confirmModal.find(".modal-title > span").text("ERROR");
                confirmModal.find(".modal-body").text(e.message);
                confirmModal.modal("show");
                return false;
            }
            confirmModal.modal("show");
            confirmModal.find('#description').val(e.data.description);
            confirmModal.find('#mission_count_needed').val(e.data.mission_count_needed);
            confirmModal.find('#activity').val(e.data.mission_target);
            confirmModal.find("#idmission").val(e.data.id);
            $('#modal_misssion').attr('action','{{route("mission.updatemission")}}');

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

    $('.deleteListMission').click(function(){
        var confirmModal = $("#id01");
        
        confirmModal.find(".modal-title > span").text("Warning : List Mission Confirmation");
        confirmModal.find(".modal-body").text("Are you sure want to Delete this List Misssion request?");
        confirmModal.modal("show");
        $id = $(this).attr("data-id");
        console.log($id);

        confirmModal.find(".btn-modal-action").click(function(){
            var btn = $(this),
            initialText = btn.attr("data-initial-text"),
            loadingText = btn.attr("data-loading-text");

            var id = $id;

            btn.html(loadingText).addClass("disabled").prop("disabled",true);
            $.post("{{route('mission.deletemission')}}",{_token:'{{ csrf_token() }}', id: id }, function(e){
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

    $('.deleteMission').click(function(){
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
                window.location.href = "{{ route('mission')}}";
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
