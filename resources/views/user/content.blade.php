@extends('layouts.template.app')

@section('content_body')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-7">
        <!--begin::Container-->
        <div class="container-fluid">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-share text-primary"></i>
                        </span>
                        <h3 class="card-label"> {{ $page_title }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('users.log') }}" class="btn btn-sm btn-primary font-weight-bold mr-2">
                            <i class="flaticon-menu-button"></i>User Log
                        </a>
                        <a href="{{ route('users.add') }}" class="btn btn-sm btn-primary font-weight-bold mr-2">
                            <i class="flaticon2-plus-1"></i>Add User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

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
