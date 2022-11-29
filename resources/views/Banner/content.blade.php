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
                        <a href="{{route('banner.create')}}" class="btn btn-sm btn-primary font-weight-bold mr-2">
                            <i class="flaticon2-plus-1"></i>
                            Add Banner 
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
                                    <div class="col-md-8 col-xxl-3 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                        <div class="d-xxl-flex">
                                            <button class="btn btn-light-success mr-2 mr-xxl-6 mb-4 mb-lg-2 mb-xl-4 mb-xxl-0" type="button" id="submit-data"><i class="flaticon2-refresh"></i> Reload Data</button>
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

@section('content_js')
{!! $table->scripts() !!}
@endsection
