@extends('layouts.template.app')

@section('content_body')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
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
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                        <form class="form-inline" id="myForm">
                            <label>
                                From:
                                <input type="date" name="date_from" id="date_from"/>
                                <span></span>                                    
                            </label>
                            <label>
                                To:
                                <input type="date" name="date_to" id="date_to"/>
                                <span></span>                                    
                            </label>
                            &nbsp;
                            <button type="button" id="submit-data" class="btn btn-success">Submit</button>
                        </form>
                            
                        </div>
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

                            <div class="mb-5">
                                <div class="row align-items-center align-items-sm-start">
                                    <div class="col-md-8 col-xxl-3 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                        <div class="d-xxl-flex">
                                            <button class="btn btn-light-success mr-2 mr-xxl-6 mb-4 mb-lg-2 mb-xl-4 mb-xxl-0" type="button" id="submit-data"><i class="flaticon2-refresh"></i> Reload Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="report-table">
                                <div class="alert alert-secondary" role="alert">
                                    No Record Founds!
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
<script>

var dt_load = function() {
    return {
        param: function() {
            var e = {};
            // e.period=$(".date-range-period #start").attr('data-selected') + '/' + $(".date-range-period #end").attr('data-selected'),
            /* e.group=$("#dt_select_group").val().toLowerCase(),
            e.job=$("#dt_select_job").val().toLowerCase(),
            e.searchNickname=$("#dt_search_nickname").val().toLowerCase(), */
            e.date_from=$('#date_from').val(),
            e.date_to=$('#date_to').val(),
            e.pagination = {'perpage': $('#pagination-perpage').val()};
            console.log(e);
            return e;
        },
        init: function($params) {
            loader_tb.init();
            $data = {_token:'{{ csrf_token() }}',query:{},pagination:{}};
            if(typeof $params === 'object'){
                for (var key in $params) {
                    var obj = $params[key];
                    if(key!='pagination'){
                        $data['query'][key] = obj;
                    }
                    else{
                        $data[key] = obj;
                    }
                }
            }
            $.post("{{ route('wallet-inout.dt') }}",$data,function(e){
                $('#report-table').find('#table-area').remove();
                loader_tb.destroy();
                if(!e.status){
                    alertModal.find(".modal-title > span").text("ERROR");
                    alertModal.find(".modal-body").text(e.message);
                    alertModal.modal("show");
                    return false;
                }
				if(e.total_row > 0){
					$('#report-table .alert').hide();
					$('#report-table').append(e.content);
                    console.log(e);
				}
				else{
					$('#report-table .alert').show().find('.alert-text').text(e.message ? e.message : 'No records found');
				}
            }).fail(function(xhr) {
                loader_tb.destroy();
                alertModal.find(".modal-title > span").text("ERROR");
                alertModal.find(".modal-body").text(xhr.responseJSON.message);
                alertModal.modal("show");
            });
        }
    }
}();

$(function(){
    var e = dt_load.param();
    dt_load.init(e);

    $('#submit-data').click(function(){
        var e = dt_load.param();
        dt_load.init(e);
    });


    $('.search-text').keypress(function(e){
        if(e.keyCode==13){
            $('#submit-data').trigger('click');
        }
    });


    $('body').delegate('#refresh-table', 'click', function(){
        var e = dt_load.param(),$this=$(this);
        e.pagination = {'perpage': $(this).attr('data-limit'), 'page': $(this).attr('data-pagination')};
        dt_load.init(e);
    });


    $('body').delegate('#pagination a', 'click', function(p){
        p.preventDefault();
        var e = dt_load.param();
        e.pagination = {'perpage': $('#pagination-perpage').val(), 'page': $(this).attr('data-page')};
        dt_load.init(e);
    });

    $('body').delegate('#pagination-perpage', 'change', function(p){
        p.preventDefault();
        var e = dt_load.param();
        e.pagination = {'perpage': $(this).val()};
        dt_load.init(e);
    });
});
</script>
@endsection
