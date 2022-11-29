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
        
        <form method="POST" action="<?= (isset($detail)) ? route('catalogue.update',['id' => $detail->id]) : route('catalogue.save') ?>">
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
                        <a href="<?= (isset($detail)) ? route('catalogue.detail',['id' => $detail->id]) : route('catalogue') ?>" class="btn btn-sm btn-danger font-weight-bold ml-2"><i class="fa fa-arrow-left"></i> Cancel</a>
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
                                        <div class="col-md-6 text-center">
                                            <h4 style="text-align: left">General Information</h4>
                                            <div class="form-group imageRow" style="width:100%;">
                                                <label for="image">
                                                    @if (isset($detail))
                                                        <img class="img-thumbnail rounded textURL" style="width: 150px; cursor: pointer;" src="{{json_decode($detail->images)[0]}}">
                                                    @else
                                                        <div class="replace" style="margin-top: 50px;"><a class="btn btn-primary"><i class="fa fa-plus"></i> Insert Picture</a></div>
                                                    @endif
                                                    <input type="file" class="form-control imageMerchantUpload" id="image" name="image" style="visibility:hidden;" accept="image/*" value="<?= (isset($detail)) ? json_decode($detail->images)[0] : "" ?>" >
                                                    <input type="hidden" class="form-control textURL" id="logo" name="logo" style="visibility:hidden;" value="<?= (isset($detail)) ? json_decode($detail->images)[0] : "" ?>" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= (isset($detail)) ? $detail->name : "" ?>" required>
                                                <div class="name"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Slug</label>
                                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="<?= (isset($detail)) ? $detail->slug : "" ?>" required>
                                                <div class="name"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="point">Point (worth for x Points)</label>
                                                <input type="number" class="form-control" id="point" name="point" placeholder="100 Point" value="<?= (isset($detail)) ? $detail->point : "" ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="provider">Provider</label>
                                                <select class="form-control select2-search" name="provider" id="provider" required>
                                                    <option value="" >-- Select Provider --</option>
                                                    @foreach($provider->get() as $p)
                                                        <option value="{{$p->id}}"  <?= (isset($detail->provider_id) && $detail->provider_id == $p->id) ? "selected" : "" ?> > {{ "['".$p->code."'] ".$p->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select class="form-control select2-search" name="category" id="category" required>
                                                    <option value="" >-- Select Category --</option>
                                                    @foreach($category->get() as $c)
                                                        <option value="{{$c->id}}" <?= (isset($detail->category) && $detail->category == $c->id) ? "selected" : "" ?>>{{ $c->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="description">Description</label>
                                            <textarea rowspan="5" type="text" class="form-control" id="description" name="description" placeholder="Description" required><?= (isset($detail)) ? $detail->description : "" ?></textarea>
                                            <div class="description"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="terms">Terms</label>
                                            <textarea rowspan="5" type="text" class="form-control" id="terms" name="terms" placeholder="Terms" required><?= (isset($detail)) ? $detail->terms : "" ?></textarea>
                                            <div class="terms"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Coupon</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="max_coupon">Maximum Coupon Period (Max Coupon Released)</label>
                                            <input type="number" class="form-control" id="max_coupon" name="max_coupon" placeholder="Maximum Coupon Release" value="<?= (isset($detail->coupon_as_payment)) ? $detail->coupon_as_payment : "" ?>" required>
                                            <div class="max_coupon"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="coupon_value">Coupon Value (IDR)</label>
                                            <input type="number" class="form-control" id="coupon_value" name="coupon_value" placeholder="IDR 120.000" value="<?= (isset($detail)) ? $detail->item_value : "" ?>" required>
                                            <div class="coupon_value"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label  for="show_coupon_id">Coupon as payment</label><br>
                                            <label class="switch">
                                                <input type="checkbox" name="show_coupon_id" onclick='handleClick(this);' <?= ((isset($detail) && $detail->product != "") ? "checked" : "") ?>  class="js-switch switch showCoupon" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="show_coupon_id">
                                                <label for="coupon_product">Coupon for product (ID Number)</label>
                                                <input type="number" class="form-control" id="coupon_product" name="coupon_product" placeholder="ex: 1" value="<?= (isset($detail)) ? $detail->product : "" ?>">
                                                <div class="coupon_product"></div>
                                            </div>
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
                                                <input type="text" class="datetime-pickers form-control" autocomplete="off" value="<?= (isset($detail->start_at)) ? $detail->start_at : "" ?>" id="date_from" name="date_from" placeholder="Select Date" required>
                                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="date_to">To</label>
                                            <div class="input-group">
                                                <input type="text" class="datetime-pickers form-control" autocomplete="off" value="<?= (isset($detail)) ? $detail->end_at : "" ?>" id="date_to" name="date_to" placeholder="Select Date" required>
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
    $('.show_coupon_id').hide();

    $('.datetime-pickers').datetimepicker({
        orientation: "top auto",
        format : "Y-m-d H:i:s",
        autoclose: true
    });
    // $('.showCoupon').
    if($('.showCoupon').get(0)){
        if($('.showCoupon').is(':checked')) $('.show_coupon_id').show()
    }

    $(document).on("change", ".imageMerchantUpload", function(){
        var disparent = $(this).parents(".imageRow");
        var formData = new FormData();
        // Since this is the file only, we send it to a specific location
        var action_uri = "{{ route('image.uploads3') }}";
        // FormData only has the file
        var file = this.files[0];
        var formData = new FormData();
        formData.append('file', file);

        $.ajax({
            type: "POST",
            url: action_uri,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (data) {
                console.log(data.success);
                if(data.success) {
                    disparent.find(".textURL").val(data.data);
                    disparent.find(".textURL").attr('src', data.data);
                    $('.replace').html('<img class="img-thumbnail rounded textURL" style="width: 150px; cursor: pointer;" src="'+data.data+'">')
                }else{
                    $message = data.data['file'][0];
                    toastr.error(data.message, data.status);
                }
            },
            error(err) {
            console.log(err)
            }
        });
    });
});

    function handleClick(cb) {
      if(cb.checked){
        $(this).parent().fadeTo('slow', 0.5)
        $('.show_coupon_id').show()
      }else{
        $(this).parent().fadeTo('slow', 1)
        $('.show_coupon_id').hide()
      }
    };

</script>
@endsection
