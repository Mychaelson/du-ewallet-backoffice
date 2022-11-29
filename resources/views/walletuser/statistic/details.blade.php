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
                        <i class="flaticon-exclamation-1 text-primary"></i>
                    </span>
                    <h3 class="card-label"> {{ $page_title }}
                </div>
                <div class="card-toolbar">

                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <!-- <div class="separator separator-dashed separator-border-1 mt-8"></div> -->
                        <div class="d-flex justify-content-between">
                            <div class="mt-1">
                                <select class="form-control selectpicker" title="Select Type" data-style="btn-info" data-width="200px" id="dt_select_type">
                                        <option value="login" selected>Login</option>
                                        <option value="register">Register</option>
                                </select>
                            </div>
                        </div>
                        <div class="separator separator-dashed separator-border-1 mb-8"></div>
                        <div id="transaction-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content_js')
<script>
// Shared Colors Definition
const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';
$(function(){
    $(".selectpicker").selectpicker();

    var loader_trc = function() {
        return {
            init: function () {
                $('#transaction-chart').html('');
                KTApp.block('#transaction-chart', {
                    overlayColor: '#FFFFFF',
                    state: 'primary',
                    message: 'Processing...'
                });
            },
            destroy: function() {
                KTApp.unblock('#transaction-chart');
            }
        }
    }();

    var trans_chart = function() {
        return {
            init: function(params) {
                loader_trc.init();
                $.get("{{ route('statistic.trans-chart') }}", {type:params.type}, function(e){
                    loader_trc.destroy();
                    if(!e.status){
                        $('#transaction-chart').html('<div class="alert alert-danger">'+ e.message +'</div>')
                        return false;
                    }
                    $('#transaction-chart').html(e.content)
                }).fail(function(xhr) {
                    loader_trc.destroy();
                    alertModal.find(".modal-title > span").text("ERROR");
                    alertModal.find(".modal-body").text(xhr.responseJSON.message);
                    alertModal.modal("show");
                });
            }
        }
    }();

    trans_chart.init({type:'login'});

    $('body').delegate('#dt_select_type', 'change', function(){
        trans_chart.init({type:$(this).val()});
    });
});
</script>
@endsection
