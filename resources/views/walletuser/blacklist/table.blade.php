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
                            <i class="flaticon2-user text-primary"></i>
                        </span>
                        <h3 class="card-label"> {{ $page_title }}
                    </div>
                    <div class="card-toolbar">
                        @if($page->mod_action_roles($mod_alias, 'create'))
                        <a href="{{ route('blacklist.add') }}" class="btn btn-sm btn-primary font-weight-bold">
                            <i class="flaticon2-plus-1"></i>Add New
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (session('msg_error'))
                                <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">{{session('msg_error')}}</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if (session('msg_success'))
                                <div class="alert alert-custom alert-notice alert-light-success fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">{{session('msg_success')}}</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-7">
                                <div class="row align-items-center">
                                    <div class="col-lg-9 col-xl-8">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 col-xxl-6 col-lg-8 my-2 my-md-0">
                                                <div class="d-xxl-flex">
                                                    {{-- kt_datatable_reload --}}
                                                    <button class="btn btn-light-success font-weight-bold mr-2 mb-4 mb-lg-2 mb-xl-0 mb-xxl-0" type="button" id="submit-data"><i class="flaticon2-refresh"></i> Reload Data</button>
                                                    <div class="input-icon flex-grow-1">
                                                        <input type="text" class="form-control" placeholder="Search..." id="dt_search_blacklist" name="search" autocomplete="off" />
                                                        <span>
                                                            <i class="flaticon2-search-1 text-muted"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! $table->table(['class' => 'datatable datatable-bordered datatable-head-custom show-table', 'selector' => TRUE]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('lib_js')

@endsection

@section('content_js')
{!! $table->scripts() !!}

<script>
    $(function () {
        var dt = $('#kt-datatable').KTDatatable();
        $('#submit-data').click(function(){
            loader_dt.init();
            var e=dt.getDataSourceQuery(),
            p=dt.getDataSourceParam();
            p.pagination.page=1;
            e.generalSearch=$("#dt_search_blacklist").val().toLowerCase(),
            dt.setDataSourceQuery(e),
            dt.load();
        });
        $('#dt_search_games').keyup(function(e){
            $('#submit-data').trigger('click');
        });

    })
</script>

@endsection
