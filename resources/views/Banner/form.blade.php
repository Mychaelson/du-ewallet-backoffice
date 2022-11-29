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
        
        <form method="POST" action="<?= (isset($detail)) ? route('banner.update',['id' => $detail->id]) : route('banner.save') ?>">
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
                        <a href="{{ route('banner') }}" class="btn btn-sm btn-danger font-weight-bold ml-2"><i class="fa fa-arrow-left"></i> Cancel</a>
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
                        <div class="col-md-9">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="field-name">Title</label>
                                              <input type="text" id="field-title" name="title" placeholder="Title" class="form-control" <?= (isset($detail->title) && !empty($detail->title)) ? "value = '".$detail->title."'" : "" ?> required="required" aria-describedby="field-name-help-block">
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="terms">Terms</label>
                                                <textarea class="editormce" name="terms" id="terms"><?= (isset($detail->terms) && !empty($detail->terms)) ? $detail->terms : "" ?></textarea>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                Highlight
                                                <textarea name="highlight" class="form-control" required="required" id="highlight" style="height:100px !important;"><?= (isset($detail->highlight) && !empty($detail->highlight)) ? $detail->highlight : "" ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                Time Starts
                                                <div class="input-group">
                                                    <input type="text" id="field-time_start" name="time_start" autocomplete="off" placeholder="Time Start" class="datetime-pickers form-control" <?= (isset($detail->time_start) && !empty($detail->time_start)) ? "value = '".$detail->time_start."'" : "" ?> aria-describedby="field-time_start-help-block" />
                                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                Image
                                                <div class="input-group imageRow">
                                                    <input type="text" id="field-image" required="required" name="image" placeholder="Image" class="form-control textURL" <?= (isset($detail->image) && !empty($detail->image)) ? "value = '".$detail->image."'" : "" ?> aria-describedby="field-image-help-block" />
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-outline-secondary np-image-picker"><i class="fa fa-folder-open"></i><input type="file" class="fileUpload" accept="image/*" style="position:absolute;top:0;left:0;width:40px;height:34px;opacity:0;cursor:pointer;"></button>
                                                    <a href="<?= (isset($detail->image) && !empty($detail->image)) ? $detail->image : "" ?>" class="btn btn-outline-secondary file-previewer" onclick="return modalizeMe(this);"><i class="fa fa-eye"></i><img src="<?= (isset($detail->image) && !empty($detail->image)) ? $detail->image : "" ?>?size=400xnull" style="display:none;"/></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                Cover
                                                <div class="input-group imageRow">
                                                    <input type="text" id="field-cover" required="required" name="cover" placeholder="Cover" class="form-control textURL" <?= (isset($detail->cover) && !empty($detail->cover)) ? "value = '".$detail->cover."'" : "" ?> aria-describedby="field-cover-help-block" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-outline-secondary np-image-picker"><i class="fa fa-folder-open"></i><input type="file" class="fileUpload" accept="image/*" style="position:absolute;top:0;left:0;width:40px;height:34px;opacity:0;cursor:pointer;"></button>
                                                        <a href="<?= (isset($detail->cover) && !empty($detail->cover)) ? $detail->cover : "" ?>" class="btn btn-outline-secondary file-previewer" onclick="return modalizeMe(this);"><i class="fa fa-eye"></i><img src="<?= (isset($detail->cover) && !empty($detail->cover)) ? $detail->cover : "" ?>?size=400xnull" style="display:none;"/></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                Time Ends
                                                <div class="input-group">
                                                    <input type="text" id="field-time_end" name="time_end" autocomplete="off" placeholder="Time End" class="datetime-pickers form-control" <?= (isset($detail->time_end) && !empty($detail->time_end)) ? "value = '".$detail->time_end."'" : "" ?> aria-describedby="field-time_end-help-block" />
                                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="field-phone">Phone</label>
                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-phone"  aria-hidden="true"></i></span>
                                          <input type="tel" id="field-phone" name="phone" required="required" placeholder="Phone" class="form-control" <?= (isset($detail->phone) && !empty($detail->phone)) ? "value = '".$detail->phone."'" : "" ?> />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                          <label for="field-email">Email</label>
                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                              <input type="email" id="field-email" required="required" name="email" placeholder="Email" class="form-control" <?= (isset($detail->email) && !empty($detail->email)) ? "value = '".$detail->email."'" : "" ?> />
                                          </div>
                                    </div>
                                    <div class="form-group">
                                          <label for="field-web">Website</label>
                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="fa fa-link" aria-hidden="true"></i></span>
                                              <input type="url" id="field-web" required="required" name="web" placeholder="Website" class="form-control" <?= (isset($detail->web) && !empty($detail->web)) ? "value = '".$detail->web."'" : "" ?> />
                                          </div>
                                    </div>
                                    <div class="form-group">
                                          <label for="field-group">Group</label>
                                          <select id="field-group" name="group" required="required" placeholder="Group" class="select2-search form-control">
                                              <option  <?= (!isset($detail->group) || (isset($detail->group) && empty($detail->group))) ? "selected" : "" ?> value="">-- Choose Group --</option>
                                              <option <?= (isset($detail->group) && $detail->group == "Yamisok") ? "selected" : "" ?> value="Yamisok">Yamisok</option>
                                              <option <?= (isset($detail->group) && $detail->group == "giiwallet-idr") ? "selected" : "" ?> value="giiwallet-idr">Gii-wallet IDR</option>
                                              <option <?= (isset($detail->group) && $detail->group == "giiwallet-usd") ? "selected" : "" ?> value="giiwallet-usd">Gii-wallet USD</option>
                                          </select>
                                    </div>
                                    <div class="form-group">
                                          <label for="field-activity">Activity</label>
                                          <select id="field-activity" required="required" name="activity" placeholder="Activity" class="select2-search form-control" >
                                              <option value="">-- Choose Activity --</option>
                                            @foreach ($activity as $item)
                                                <option <?= (isset($detail->activity) && $detail->activity == $item->name) ? "selected" : "" ?> value="{{$item->name}}">{{$item->name}}</option>
                                            @endforeach
                                              
                                          </select>
                                    </div>
                                    <div class="form-group">
                                          <label for="field-label">Label</label>
                                          <select id="field-label" required="required" name="label" placeholder="Label" class="select2-search form-control">
                                              <option  <?= (!isset($detail->label) || (isset($detail->label) && empty($detail->label))) ? "selected" : "" ?> value="">-- Choose Label --</option>
                                              <option <?= (isset($detail->label) && $detail->label == "game-page") ? "selected" : "" ?> value="game-page">game-page</option>
                                              <option <?= (isset($detail->label) && $detail->label == "pop-up") ? "selected" : "" ?> value="pop-up">pop-up</option>
                                          </select>
                                    </div>
                                    <div class="form-group">
                                          <label for="field-params">Params</label>
                                          <?php
                                            $str_param = "";
                                            $params = (isset($detail->params) && !empty($detail->params)) ? $detail->params : "";
                                            if(!empty($params)){
                                                $json_param = json_decode($params);
                                                if(!empty($json_param)){
                                                    $paramarr = array();
                                                    foreach($json_param as $jcode=>$jpar){
                                                        $paramarr [] = $jcode." : ".$jpar;
                                                    }
                                                    $str_param = implode("\n", $paramarr);
                                                }
                                            }
                                           ?>
                                          <textarea id="field-params" name="params" placeholder="Params" class="form-control"><?= (isset($detail->params) && !empty($str_param)) ? $str_param : "" ?></textarea>
                                    </div>
                                    <div>
                                        <small>
                                            Separate each <code>params</code> value by new line, key value separated by double colon. Example:
                                            <pre>id: 12 <br />product: 23</pre>
                                        </small>
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


    (function ($) {
        "use strict";
        tinymce.init({
            selector: ".editormce",
            menubar: false,
            height: 300,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor textcolor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste code help wordcount"
            ],
            toolbar: "insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help",
            content_css: [
                "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
                "//www.tinymce.com/css/codepen.min.css"]

        });
    })(window.jQuery);

    $('.datetime-pickers').datetimepicker({
        orientation: "top auto",
        format : "Y-m-d H:i:s",
        autoclose: true
    });

   

    $(document).on("change", ".fileUpload", function(){
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
                    disparent.find(".file-previewer").attr('href', data.data);
                }else{
                    $message = data.data['file'][0];
                    console.log($message);
                    alert($message);
                }
            }
        });
	  });
});

</script>
@endsection
