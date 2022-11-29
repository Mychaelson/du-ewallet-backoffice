@extends('layouts.template.app')

@section('content_body')
    <div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Label</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="{{ route('wallet-label') }}" class="btn btn-primary font-weight-bold">Back</a>
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
                                <form action="{{ route('wallet-label-store') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    @if (isset($id))
                                        <input type="hidden" name="label_id" value="{{$id}}">
                                    @endif
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Name</label>
                                        <div class="col-8 mb-2">
                                            <input type="text" class="form-control" placeholder="name" name="name" autocomplete="off" value="{{ isset($info->name) ? $info->name : '' }}" required />
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Icon (URL)</label>
                                        <div class="input-group mb-2 col-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                                        <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                                                        <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Icon URL" name="icon_url" value="{{ isset($info->icon) ? $info->icon : '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Background (URL)</label>
                                        <div class="input-group mb-2 col-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                                        <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                                                        <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Background URL" name="background_url" value="{{ isset($info->background) ? $info->background : '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Color</label>
                                        <div class="input-group mb-2 col-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eyedropper" viewBox="0 0 16 16">
                                                        <path d="M13.354.646a1.207 1.207 0 0 0-1.708 0L8.5 3.793l-.646-.647a.5.5 0 1 0-.708.708L8.293 5l-7.147 7.146A.5.5 0 0 0 1 12.5v1.793l-.854.853a.5.5 0 1 0 .708.707L1.707 15H3.5a.5.5 0 0 0 .354-.146L11 7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-.647-.646 3.147-3.146a1.207 1.207 0 0 0 0-1.708l-2-2zM2 12.707l7-7L10.293 7l-7 7H2v-1.293z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <input type="color" class="form-control" id="inlineFormInputGroup" name="color" required value="{{ isset($info->color) ? $info->color : '#ffffff' }}">
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="spending" id="spending" name="spending" {{isset($info->spending) ? $info->spending ? 'checked' : '' : '' }}>
                                            <label class="form-check-label" for="spending">
                                                is Spending
                                            </label>
                                        </div>
                                        <div class="form-check ml-4">
                                            <input class="form-check-input" type="checkbox" value="organization" id="organization" name="organization" {{isset($info->organization) ? $info->organization ? 'checked' : '' : '' }}>
                                            <label class="form-check-label" for="organization">
                                                is For Organization
                                            </label>
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
