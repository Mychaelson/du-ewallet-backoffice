@extends('layouts.template.app')

@section('content_body')
    <div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Setting</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="{{ route('wallet-setting') }}" class="btn btn-primary font-weight-bold">Back</a>
                    <!--end::Button-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Row-->
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-t">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">{{ $page_title }}</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <form action="{{ route('wallet-setting-store') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    @if (isset($id))
                                        <input type="hidden" name="setting_id" value="{{$id}}">
                                    @endif
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Name</label>
                                        <div class="col-8 mb-2">
                                            <input type="text" class="form-control" placeholder="name" name="name" autocomplete="off" value="{{ isset($info->name) ? $info->name : '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Value</label>
                                        <div class="col-8 mb-2">
                                            <input type="text" class="form-control" placeholder="name" name="value" autocomplete="off" value="{{ isset($info->value) ? $info->value : '' }}" required />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row my-2">
                                        <div class="col text-right">
                                            <button class="btn btn-light-success" type="submit"><i class="flaticon2-check-mark"></i> Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
    </div>
@endsection
