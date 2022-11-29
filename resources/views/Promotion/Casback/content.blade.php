@extends('layouts.template.app')

@section('content_body')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-7" >
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-line-graph text-primary"></i>
                        </span>
                        <h3 class="card-label"> {{ $page_title }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('cashback.create')}}" class="btn btn-sm btn-primary font-weight-bold mr-2">
                            <i class="flaticon2-plus-1"></i>
                            Add Cashback 
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
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

                            <div class="mb-7">
                                <div class="row align-items-center align-items-sm-start">
                                    <div class="col-md-6">
                                        <div class="d-xxl-flex">
                                            <button class="btn btn-light-success mr-2" type="button" id="submit-data"><i class="flaticon2-refresh"></i> Reload Data</button>
                                            <div class="flex-grow-1">
                                                <div class="input-daterange input-group date-range-period">
                                                    <input type="text" class="m-input form-control" readonly="" id="start" placeholder="{{ \Carbon\Carbon::now()->format('d M Y') }}" data-selected="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <span class="input-group-append pointer">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </span>
                                                    <input type="text" class="m-input form-control" readonly="" id="end" placeholder="{{ \Carbon\Carbon::now()->format('d M Y') }}" data-selected="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-6 mb-4">
                                            <select class="form-control select2-search" id="dt_select_status">
                                                <option value="">-- Filter By Status --</option>
                                                <option value="0" >Moderation</option>
                                                <option value="1" >Active</option>
                                                <option value="2" >Deleted</option>
                                                <option value="3" >re_Draft</option>
                                                <option value="4" >Staff Follow Up</option>
                                                <option value="5" >Request to Approve</option>
                                                <option value="6" >On Hold</option>
                                                <option value="7" >On Rejected</option>
                                                <option value="8" >Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! $table->table(['class' => 'datatable datatable-bordered datatable-head-custom show-table', 'selector' => TRUE]) !!}
                            {{-- <div id="report-table">
                                <x-alert type="danger" message="{{ 'No records found' }}" dismissible="TRUE"/>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            btn_opened.find("span").text("Open All Details");
        }
    });
    dt.on("datatable-on-ajax-done", function (t,x) {
        $("#open-details").prop('disabled',false);
        if(x.length==0){
            $("#open-details").prop('disabled',true);
        }
    });

    $('#submit-data').click(function(){
        loader_dt.init();
        var e=dt.getDataSourceQuery(),
        p=dt.getDataSourceParam();
        p.pagination.page=1;
        e.time=$(".date-range-period #start").attr('data-selected') + '/' + $(".date-range-period #end").attr('data-selected'),
        e.selectStatus=$("#dt_select_status").val().toLowerCase(),
        dt.setDataSourceQuery(e),
        dt.load();
    });
});

</script>
@endsection

