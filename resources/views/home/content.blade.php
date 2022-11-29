@extends('layouts.template.app')

@section('content_body')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid pt-4">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b" style="height: 250px; background-color: #1B283F; background-position: calc(100% + 0.5rem) calc(100% + 0.5rem); background-size: 600px auto; background-image: url({{ asset('template/media/svg/patterns/rhone-2.svg') }})">
                        <div class="card-body d-flex">
                            <div class="d-flex py-5 flex-column align-items-start flex-grow-1">
                                <div class="flex-grow-1">
                                    <p class="text-success font-weight-bolder font-size-h3">Welcome to {{ config('app.name') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
