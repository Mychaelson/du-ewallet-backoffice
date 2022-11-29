@extends('layouts.template.app') @section('content_body')
<!--begin::Entry-->
  <div class="d-flex flex-column-fluid mt-7">
  <!--begin::Container-->
  <div class="container-fluid"> @if(session()->has('message')) <div class="alert alert-success">
      {{ session()->get('message') }}
    </div> @endif <div class="card card-custom gutter-b">
      <div class="card-header">
        <div class="card-title">
          <span class="card-icon">
            <i class="flaticon-share text-primary"></i>
          </span>
          <h3 class="card-label"> {{ $page_title }}
        </div>
        <div class="card-toolbar">
        <a href="{{ route('users') }}" class="btn btn-sm btn-danger font-weight-bold ml-2">
                  <i class="flaticon-close"></i> Back </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="mb-7">
              <div class="row align-items-center">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-12">
                      <select class="form-control select2-search" id="dt_select_user" name="user">
                        <option value="">-- Select User --</option>
                        @foreach($users as $value)
                          <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-12">
                      <select class="form-control select2-search" id="dt_select_type" name="type">
                        <option value="">-- Select Type --</option>
                        @foreach($types as $value)
                          <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-5">
                      <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="date start" name="datestart" id="datestart">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="date end" name="dateend" id="dateend">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <button class="btn btn-light-success mr-2 mr-xxl-6 mb-4 mb-lg-2 mb-xl-4 mb-xxl-0" type="button" id="submit-data" style="width:100%"><i class="flaticon2-refresh"></i> Reload Data</button>
                    </div>
                  </div>
                </div>
              </div>

              
              <!-- <br>
              <div class="mb-7">
                  <div class="row align-items-center">
                      <div class="col-lg-9 col-xl-8">
                          <div class="row align-items-center">
                              <div class="col-md-6 col-xxl-6 col-lg-8 my-2 my-md-0">
                                  <div class="d-xxl-flex">
                                      <div class="input-icon flex-grow-1">
                                          <input type="text" class="form-control" placeholder="Search..." id="dt_search_query" name="search" autocomplete="off" />
                                          <span>
                                              <i class="flaticon2-search-1 text-muted"></i>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div> -->
                  {!! $table->table(['class' => 'datatable datatable-bordered datatable-head-custom show-table', 'selector' => TRUE]) !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 

  @section('content_css')
  <style>
    span.select2 {
      width: 100%!important
    }
  </style>
  @endsection
  
  @endsection 
  @section('content_js') 

  {!! $table->scripts() !!}
  <script>
$(function(){
    var dt = $('#kt-datatable').KTDatatable();
    dt.on("datatable-on-layout-updated", function (t,x) {
        var btn_opened=$("#open-details");
        if(btn_opened.attr("data-opened")=="yes"){
            btn_opened.attr("data-opened", "no");
            btn_opened.find("i").addClass("flaticon2-next").removeClass("flaticon2-down");
            btn_opened.find("span").text("Open");
        }
    });


    dt.on("datatable-on-ajax-done", function (t,x) {
        $("#open-details").prop('disabled',false);
        if(x.length==0){
            $("#open-details").prop('disabled',true);
        }
    });

    $(".btn-search-by .dropdown-item").on("click", function(){
        var $this=$(this),$parent=$this.parents(".btn-search-by");
        $parent.find(".dropdown-toggle").text($this.text());
    });

    $("#open-details").on("click", function(){
        if($(this).attr("data-opened")=="yes"){
            $(this).attr("data-opened", "no");
            $(this).find("i").addClass("flaticon2-next").removeClass("flaticon2-down");
            $(this).find("span").text("Open");
        }
        else{
            $(this).attr("data-opened", "yes");
            $(this).find("i").addClass("flaticon2-down").removeClass("flaticon2-next");
            $(this).find("span").text("Close");
        }
        $(".datatable-toggle-subtable").trigger("click");
    });

    $('#submit-data').click(function(){
        loader_dt.init();
        var e=dt.getDataSourceQuery(),
        p=dt.getDataSourceParam();
        p.pagination.page=1;
        e.user=$("#dt_select_user").val(),
        e.type=$("#dt_select_type").val(),
        e.dateStart=$("#datestart").val(),
        e.dateEnd=$("#dateend").val(),
        dt.setDataSourceQuery(e),
        dt.load();
    });

    $('.search-text').keypress(function(e){
        if(e.keyCode==13){
            $('#submit-data').trigger('click');
        }
    });

});
  </script>

@endsection