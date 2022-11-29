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
                    <a href="{{ route('ticket-category-add') }}" class="btn btn-primary font-weight-bold">Add Parent Category</a>
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
                                <div id="kt_tree_2" class="tree-demo">
                                    <ul>
                                        @foreach ($parents as $pc)
                                            <li data-jstree='{ "opened" : false }'>
                                                {{ $pc->name }}
                                                <div class="btn-group btn-group-xs" role="group">
                                                    <button onclick="window.location.href = '{{ route('ticket-category-detail', ['id' => $pc->id]) }}'" class="btn btn-xs btn-icon btn-outline-secondary">
                                                        <i class="flaticon2-edit icon-xs"></i>
                                                    </button>
                                                    <button onclick="window.location.href = '{{ route('ticket-category-add', ['parent_id' => $pc->id]) }}'"
                                                        class="btn btn-xs btn-icon btn-outline-secondary">
                                                        <i class="flaticon2-plus icon-xs"></i>
                                                    </button>
                                                </div>
                                                <ul>
                                                    @foreach ($categories->where('parent', $pc->id) as $cc)
                                                        <li data-jstree='{ "type" : "file" }'>
                                                            {{ $cc->name }}
                                                            <button onclick="window.location.href = '{{ route('ticket-category-detail', ['id' => $cc->id]) }}'"
                                                                class="btn btn-xs btn-icon btn-outline-secondary">
                                                                <i class="flaticon2-edit icon-xs"></i>
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
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
@section('lib_css')
    <link rel="stylesheet" href="{{ asset('/assets/plugins/jstree/jstree.bundle.css') }}" />
@endsection
@section('lib_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
    <script src="{{ asset('/assets/plugins/jstree/jstree.bundle.js') }}"></script>
@endsection
@section('content_js')
    <script>
        $('#kt_tree_2').jstree({
            "core": {
                "themes": {
                    "responsive": true
                }
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder text-warning"
                },
                "file": {
                    "icon": "fa fa-file text-warning"
                }
            },
            "plugins": ["types"]
        });
    </script>
@endsection
