@extends('layouts.template.app')

@section('content_body')
    <div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add Parent Category</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="{{ route('ticket-category-list') }}" class="btn btn-primary font-weight-bold">Back</a>
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
                                <form action="{{ route('ticket-category-update', ['id' => $category->id]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Category Name:</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" placeholder="Category Name" name="category_name" autocomplete="off" value="{{ $category->name }}" />
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Category Activity:</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" placeholder="Category Activity" name="category_activity" autocomplete="off" value="{{ $category->activity }}" />
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Category Priority:</label>
                                        <div class="col-8">
                                            <select class="form-control select2-search" name="category_priority" id="category_priority" value="{{ $category->priority }}">
                                                <option value="1" @selected($category->scope == 1)>Low</option>
                                                <option value="2" @selected($category->scope == 2)>Medium</option>
                                                <option value="3" @selected($category->scope == 3)>High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Category Scope:</label>
                                        <div class="col-8">
                                            <select class="form-control select2-search" name="category_scope" id="category_scope" value="{{ $category->scope }}">
                                                <option value="1" @selected($category->scope == 1)>Finance</option>
                                                <option value="2" @selected($category->scope == 2)>Legal</option>
                                                <option value="3" @selected($category->scope == 3)>Business</option>
                                                <option value="4" @selected($category->scope == 4)>IT</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if ($category->parent != 0)
                                        <div class="form-group row my-2">
                                            <label class="col-4 col-form-label">Category Parent:</label>
                                            <div class="col-8">
                                                <select class="form-control select2-search" name="category_parent" id="category_parent" value="{{ $category->parent }}">
                                                    @foreach ($parents as $parent)
                                                        <option value="{{ $parent->id }}" @selected($category->parent == $parent->id)>{{ $parent->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Category Status:</label>
                                        <div class="col-8">
                                            <select class="form-control select2-search" name="category_status" id="category_status" value="{{ $category->status }}">
                                                <option value="0" @selected($category->scope == 0)>Not Active</option>
                                                <option value="1" @selected($category->scope == 1)>Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <div class="col text-right">
                                            <button class="btn btn-light-success" type="submit"><i class="flaticon2-check-mark"></i> Save</button>
                                            <a href="{{ route('ticket-category-delete', ['id' => $category->id]) }}" class="btn btn-light-danger font-weight-bold">Delete</a>
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
