@extends('layouts.template.app')
@section('content_css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css"/>

@endsection
@section('content_body')

<div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Detail User</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->
            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="{{route('user-list')}}" class="btn btn-default font-weight-bold">Back</a>
                <!--end::Button-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container" style="margin-left: 15px; margin-right: 15px;">
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-4">
                    <!--begin::Card-->
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card card-custom gutter-t">
                        <!--begin::Header-->
                        <div class="card-header h-auto py-4">
                            <div class="card-title">
                                <h3 class="card-label">Profile
                                <span class="d-block text-muted pt-2 font-size-sm">user profile preview</span></h3>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-4">
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Account:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext">
                                    <span class="font-weight-bolder">{{isset($user->username) ? $user->username : '-'}}</span>
                                    @if($user->verified == 1)
                                    <span class="label label-light-success label-inline font-weight-bolder mr-1">Premium</span>

                                    @else
                                    <span class="label label-light-dark label-inline font-weight-bolder mr-1">Basic</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Status:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if($user->status == 0)
                                    <span class="label label-light-dark label-inline font-weight-bolder mr-1">Not Activated</span>

                                    @elseif($user->status == 1)
                                    <span class="label label-light-success label-inline font-weight-bolder mr-1">Activated</span>


                                    @elseif($user->status == 2)
                                    <span class="label label-light-danger label-inline font-weight-bolder mr-1">Blocked</span>


                                    @elseif($user->status == 3)

                                    <span class="label label-light-warning label-inline font-weight-bolder mr-1">Closed</span>

                                    @elseif($user->status == 4)

                                    <span class="label label-light-info label-inline font-weight-bolder mr-1">Inactive 3 months</span>

                                    @elseif($user->status == 5)

                                    <span class="label label-light-info label-inline font-weight-bolder mr-1">Inactive 6 months</span>

                                    @elseif($user->status == 6)

                                    <span class="label label-light-info label-inline font-weight-bolder mr-1">Inactive 1 year</span>

                                    @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Name:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->name}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Cashtag:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->nickname}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Email:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    {{$user->email}}
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Phone:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->phone}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Whatsapp:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->whatsapp}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Place of Birth:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->place_of_birth}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Date of Birth:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->date_of_birth}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Gender:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if($user->gender == 1)
                                        Male
                                    @else
                                        Female
                                    @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">User Type:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if($user->user_type == 0)
                                    <span class="label label-light-dark label-inline font-weight-bolder mr-1">Inactive</span>

                                    @elseif($user->user_type == 1)
                                    <span class="label label-light-success label-inline font-weight-bolder mr-1">Reguler</span>


                                    @elseif($user->user_type == 3)

                                    <span class="label label-light-primary label-inline font-weight-bolder mr-1">Merchant</span>

                                    @elseif($user->user_type == 4)

                                    <span class="label label-light-warning label-inline font-weight-bolder mr-1">VIP</span>

                                    @elseif($user->user_type == 5)

                                    <span class="label label-light-dark label-inline font-weight-bolder mr-1">Inactive</span>

                                    @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Timezone:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->timezone}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Locale:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->locale}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Group:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->group_id}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Registered Date:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->created_at}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Latest Update:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->updated_at}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Approved Date:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->date_activated}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Last Login:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">{{$user->last_login}}</span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Mother Name:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if(isset($user_info) && isset($user_info->mother_name))
                                    {{$user_info->mother_name}}
                                    @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Nationality:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if(isset($user_info) && isset($user_info->nationality))
                                    {{$user_info->nationality}}
                                    @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Identity Type:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if(isset($user_info) && isset($user_info->identity_type))
                                    {{$user_info->identity_type}}
                                    @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">Identity Number:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if(isset($user_info) && isset($user_info->identity_number))
                                    {{$user_info->identity_number}}
                                    @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label class="col-4 col-form-label">NPWP Number:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext font-weight-bolder">
                                    @if(isset($user_info) && isset($user_info->npwp_number))
                                    {{$user_info->npwp_number}}
                                    @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <div class="col-xl-8">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b gutter-t">
                        <!--begin::Header-->
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-bold nav-tabs-line-3x" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1">
                                            <span class="nav-icon mr-2">
                                                <span class="svg-icon mr-3">
                                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Notification2.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="nav-text">Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_2">
                                            <span class="nav-icon mr-2">
                                                <span class="svg-icon mr-3">
                                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Chat-check.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M6.5,4 L6.5,20 L17.5,20 L17.5,4 L6.5,4 Z M7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,20 C19,21.1045695 18.1045695,22 17,22 L7,22 C5.8954305,22 5,21.1045695 5,20 L5,4 C5,2.8954305 5.8954305,2 7,2 Z" fill="#000000" fill-rule="nonzero"/>
                                                        <polygon fill="#000000" opacity="0.3" points="6.5 4 6.5 20 17.5 20 17.5 4"/>
                                                    </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="nav-text">Device</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_3">
                                            <span class="nav-icon mr-2">
                                                <span class="svg-icon mr-3">
                                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Devices/Display1.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <rect fill="#000000" opacity="0.3" x="2" y="2" width="10" height="12" rx="2"/>
                                                        <path d="M4,6 L20,6 C21.1045695,6 22,6.8954305 22,8 L22,20 C22,21.1045695 21.1045695,22 20,22 L4,22 C2.8954305,22 2,21.1045695 2,20 L2,8 C2,6.8954305 2.8954305,6 4,6 Z M18,16 C19.1045695,16 20,15.1045695 20,14 C20,12.8954305 19.1045695,12 18,12 C16.8954305,12 16,12.8954305 16,14 C16,15.1045695 16.8954305,16 18,16 Z" fill="#000000"/>
                                                    </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="nav-text">Wallet</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_4">
                                            <span class="nav-icon mr-2">
                                                <span class="svg-icon mr-3">
                                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Home/Globe.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M13,18.9450712 L13,20 L14,20 C15.1045695,20 16,20.8954305 16,22 L8,22 C8,20.8954305 8.8954305,20 10,20 L11,20 L11,18.9448245 C9.02872877,18.7261967 7.20827378,17.866394 5.79372555,16.5182701 L4.73856106,17.6741866 C4.36621808,18.0820826 3.73370941,18.110904 3.32581341,17.7385611 C2.9179174,17.3662181 2.88909597,16.7337094 3.26143894,16.3258134 L5.04940685,14.367122 C5.46150313,13.9156769 6.17860937,13.9363085 6.56406875,14.4106998 C7.88623094,16.037907 9.86320756,17 12,17 C15.8659932,17 19,13.8659932 19,10 C19,7.73468744 17.9175842,5.65198725 16.1214335,4.34123851 C15.6753081,4.01567657 15.5775721,3.39010038 15.903134,2.94397499 C16.228696,2.49784959 16.8542722,2.4001136 17.3003976,2.72567554 C19.6071362,4.40902808 21,7.08906798 21,10 C21,14.6325537 17.4999505,18.4476269 13,18.9450712 Z" fill="#000000" fill-rule="nonzero" />
                                                            <circle fill="#000000" opacity="0.3" cx="12" cy="10" r="6" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="nav-text">Statistic</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_5">
                                            <span class="nav-icon mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"/>
                                                </g>
                                            </svg><!--end::Svg Icon--></span>
                                            </span>
                                            <span class="nav-text">KYC History</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_6">
                                            <span class="nav-icon mr-2">
                                                <span class="svg-icon mr-3">
                                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Home/Globe.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M13,18.9450712 L13,20 L14,20 C15.1045695,20 16,20.8954305 16,22 L8,22 C8,20.8954305 8.8954305,20 10,20 L11,20 L11,18.9448245 C9.02872877,18.7261967 7.20827378,17.866394 5.79372555,16.5182701 L4.73856106,17.6741866 C4.36621808,18.0820826 3.73370941,18.110904 3.32581341,17.7385611 C2.9179174,17.3662181 2.88909597,16.7337094 3.26143894,16.3258134 L5.04940685,14.367122 C5.46150313,13.9156769 6.17860937,13.9363085 6.56406875,14.4106998 C7.88623094,16.037907 9.86320756,17 12,17 C15.8659932,17 19,13.8659932 19,10 C19,7.73468744 17.9175842,5.65198725 16.1214335,4.34123851 C15.6753081,4.01567657 15.5775721,3.39010038 15.903134,2.94397499 C16.228696,2.49784959 16.8542722,2.4001136 17.3003976,2.72567554 C19.6071362,4.40902808 21,7.08906798 21,10 C21,14.6325537 17.4999505,18.4476269 13,18.9450712 Z" fill="#000000" fill-rule="nonzero" />
                                                            <circle fill="#000000" opacity="0.3" cx="12" cy="10" r="6" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="nav-text">Change PIN History</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body px-0">
                            <div class="tab-content pt-5">
                                <!--begin::Tab Content-->
                                <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">
                                        <div class="flex-row-fluid ml-lg-8">
                                            <!--begin::Card-->
                                            <div class="">
                                                <div class="card-body">
                                                    <!--begin::Section-->
                                                    <div class="card card-custom">
                                                        <div class="card-body p-0">
                                                            <div class="row">
                                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                                    <!--begin::Featured Category-->
                                                                    <div class="card card-custom card-stretch card-stretch-half gutter-b">
                                                                        <div class="card-body p-0 d-flex rounded" style="background:yellow;">
                                                                            <div class="row m-0">
                                                                                @if(isset($user->avatar))
                                                                                <div class="col-7 p-0">
                                                                                    <div class="card card-custom card-stretch card-transparent card-shadowless">
                                                                                        <div class="card-body d-flex flex-column justify-content-center pr-0">
                                                                                            <h3 class="font-size-h4 font-size-h1-sm font-size-h4-lg font-size-h1-xl mb-0">
                                                                                                <span href="#" class="text-dark font-weight-bolder">Avatar</span>
                                                                                            </h3>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex flex-center col-5 p-0">
                                                                                    <a href="{{$user->avatar}}" target="_blank">
                                                                                        <img src="{{$user->avatar}}" class="d-flex flex-row-fluid w-100" style="transform: scale(1.2);"/>
                                                                                    </a>
                                                                                </div>
                                                                                @else
                                                                                <div class="col-7 p-0">
                                                                                    <div class="card card-custom card-stretch card-transparent card-shadowless">
                                                                                        <div class="card-body d-flex flex-column justify-content-center pr-0">
                                                                                            <h3 class="font-size-h4 font-size-h1-sm font-size-h4-lg font-size-h1-xl mb-0">
                                                                                                <span href="#" class="text-dark font-weight-bolder">No Avatar Found</span>
                                                                                            </h3>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Featured Category-->
                                                                    <!--begin::Featured Category-->
                                                                    <div class="card card-custom card-stretch card-stretch-half gutter-b">
                                                                        <div class="card-body p-0 d-flex rounded" style="background: radial-gradient(110.23% 110.23% at 50% 50%, rgba(255, 255, 255, 0.27) 0%, rgba(255, 255, 255, 0) 100%), #8950FC;">
                                                                            <div class="row m-0">
                                                                                @if(isset($user_info->identity_image))
                                                                                <div class="col-7 p-0">
                                                                                    <div class="card card-custom card-stretch card-transparent card-shadowless">
                                                                                        <div class="card-body d-flex flex-column justify-content-center pr-0">
                                                                                            <h3 class="font-size-h4 font-size-h1-sm font-size-h4-lg font-size-h1-xl mb-0">
                                                                                                <span href="#" class="text-white font-weight-bolder">Identity</span>
                                                                                            </h3>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-5 p-0 d-flex flex-center">
                                                                                    <a href="{{isset($user_info->identity_image) ? $user_info->identity_image : '#'}}" target="_blank">
                                                                                        <img src="{{isset($user_info->identity_image) ? $user_info->identity_image : '#'}}" class="d-flex flex-row-fluid w-100" style="transform: scale(1.2);"/>
                                                                                    </a>
                                                                                </div>
                                                                                @else
                                                                                <div class="col-7 p-0">
                                                                                    <div class="card card-custom card-stretch card-transparent card-shadowless">
                                                                                        <div class="card-body d-flex flex-column justify-content-center pr-0">
                                                                                            <h3 class="font-size-h4 font-size-h1-sm font-size-h4-lg font-size-h1-xl mb-0">
                                                                                                <span href="#" class="text-white font-weight-bolder">No Identity Found</span>
                                                                                            </h3>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Featured Category-->
                                                                </div>
                                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                                    <!--begin::Featured Category-->
                                                                    <div class="card card-custom card-stretch gutter-b">
                                                                        <div class="card-body d-flex flex-column rounded justify-content-between p-14" style="background: radial-gradient(83.15% 83.15% at 50% 50%, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0) 100%), #1BC5BD;">
                                                                            <div class="text-center">
                                                                                @if(isset($user_info->photo))
                                                                                <h3 class="font-size-h1 mb-0">
                                                                                    <a href="{{isset($user_info->photo) ? $user_info->photo : '#'}}" target="_blank">
                                                                                        <img src="{{isset($user_info->photo) ? $user_info->photo : '#'}}" class="d-flex flex-row-fluid w-100" style="transform: scale(1.2);"/>
                                                                                    </a>
                                                                                    <span class="text-dark font-weight-bolder">Photo</span>
                                                                                </h3>
                                                                                @else
                                                                                <h3 class="font-size-h1 mb-0">
                                                                                    <span class="text-dark font-weight-bolder">No Photo Found</span>
                                                                                </h3>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Featured Category-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <!--end::Section-->
                                                    <!--begin::Section Address-->
                                                    <div class="row">
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <div class="card card-custom gutter-t">
                                                            <!--begin::Header-->
                                                            <div class="card-header h-auto py-4">
                                                                <div class="card-title">
                                                                    <h3 class="card-label">Address
                                                                </div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Address-->
                                                            <div class="card-body py-4">
                                                                @if(!empty($address))
                                                                @foreach($address as $add)
                                                                <div class="form-group row my-2">
                                                                    <label class="col-4 col-form-label font-weight-bolder">{{$add->name}}</label>
                                                                    <div class="col-8">
                                                                        <span class="form-control-plaintext">
                                                                        <span>{{isset($add->address) ? $add->address : '-'}}, {{isset($add->subdistrict_name) ? $add->subdistrict_name : '-'}}, {{isset($add->city_name) ? $add->city_name : '-'}}, {{isset($add->province_name) ? $add->province_name : '-'}}, {{isset($add->postal_code) ? $add->postal_code : '-'}}</span>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                <div class="form-group row my-2">
                                                                    <label class="col-4 col-form-label font-weight-bolder">No address found</label>
                                                                    <div class="col-8">
                                                                        <span class="form-control-plaintext">
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <!--end::Address-->
                                                        </div>
                                                        <!--end::Section Address-->
                                                        <!--begin::Section Jobs-->
                                                        <div class="card card-custom gutter-t">
                                                            <!--begin::Header-->
                                                            <div class="card-header h-auto py-4">
                                                                <div class="card-title">
                                                                    <h3 class="card-label">Jobs
                                                                </div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Address-->
                                                            <div class="card-body py-4">
                                                                @foreach($jobs as $jo)
                                                                <div class="form-group row my-2">
                                                                    <div class="col-8">
                                                                        <span class="form-control-plaintext">
                                                                        <span>{{isset($jo->name) ? $jo->name : '-'}}</span>
                                                                        <br>
                                                                        <span>Risk : {{isset($jo->type) ? $jo->type : '-'}}</span>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                @endforeach
                                                            </div>
                                                            <!--end::Address-->
                                                        </div>
                                                        <!--end::Section Jobs-->
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <div class="container">
                                                            @if($user->status != 2)
                                                            <a href="{{route('user.banview', ['id' => $user->id])}}">
                                                            <button type="button" class="btn btn-outline-primary btn-lg btn-block">Block Account</button>
                                                            </a>
                                                            @else
                                                            <a href="{{route('user.unbanview', ['id' => $user->id])}}">
                                                            <button type="button" class="btn btn-outline-danger btn-lg btn-block">Unblock Account</button>
                                                            </a>
                                                            @endif
                                                            <a href="{{route('user.forcepinview', ['id' => $user->id])}}">
                                                            <button type="button" class="btn btn-outline-primary btn-lg btn-block">Force New PIN</button>
                                                            </a>
                                                            <a href="{{route('user.unkycview', ['id' => $user->id])}}">
                                                            <button type="button" class="btn btn-outline-primary btn-lg btn-block">UnKYC Account</button>
                                                            </a>
                                                            <a href="{{route('user.forcelogoutview', ['id' => $user->id])}}">
                                                            <button type="button" class="btn btn-outline-primary btn-lg btn-block">Force Logout</button>
                                                            </a>
                                                            <a href="{{route('user.revokedeviceview', ['id' => $user->id])}}">
                                                            <button type="button" class="btn btn-outline-primary btn-lg btn-block">Revoke Main Device</button>
                                                            </a>
                                                            <a href="{{route('user.watchlistview', ['id' => $user->id])}}">
                                                            <button type="button" class="btn btn-outline-primary btn-lg btn-block">Watchlist</button>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    </div>
                                                    <!--end::Section-->
                                            </div>
                                            <!--end::Card-->
                                        </div>
                                </div>
                                <!--end::Tab Content-->
                                <!--begin::Tab Content-->
                                <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                                    <div class="rows">
                                        <div class="col-md-12">
                                            <?php if(!empty($user->main_device)){ ?>
                                                <table class="table table-bordered">
                                                <thead>
                                                    <tr style="background:#f7f7f7">
                                                        <th>Main Device</th>
                                                        <th>Main Device Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?= $user->main_device ?></td>
                                                    <td><?= $user->main_device_name ?></td>
                                                </tr>
                                                </tbody>
                                                </table>
                                                <br />
                                            <?php } ?>
                                                <div class="panel panel-default">
                                                        <?php if(isset($user_device) && !empty($user_device)){ ?>
                                                        <table class="datatablez table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Name</th>
                                                                <th>IMEI</th>
                                                                <th>Location</th>
                                                                <th>Updated</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $no=1;
                                                            foreach($user_device as $dkey=>$deval){
                                                                $arr_loc = json_decode($deval->location);
                                                                $location_name = (!empty($arr_loc) && isset($arr_loc->city)) ? $arr_loc->city : "";
                                                            ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= $deval->device_name ?></td>
                                                                <td><?= $deval->imei ?></td>
                                                                <td ><?= $location_name ?></td>
                                                                <td><?= (!empty($deval->updated_at)) ? date("F d, Y H:i:s", strtotime($deval->updated_at)) : $deval->updated_at ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php } ?>

                                                </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="rows">
                                        <div class='col-xs-12 col-md-12 col-sm-12'>
                                            <?php if(isset($user_connect) && !empty($user_connect)) : ?>
                                            <div class="panel panel-white">
                                                <div class="panel-heading clearfix">
                                                <div class="panel-title">
                                                    User Connection Network
                                                </div>
                                                </div>
                                                <div class="panel-body">
                                                <table id="networkUsers" class="table table-bordered" style="border:1px solid #eee; width:100%">
                                                    <thead>
                                                    <tr>
                                                    <th>No</th>
                                                    <th>Network Type</th>
                                                    <th>Provider</th>
                                                    <th>IP Address</th>
                                                    <th>Updated</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <?php
                                                $no=1;
                                                foreach($user_connect as $dkey=>$deval){
                                                ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $deval->type ?></td>
                                                    <td><?= $deval->provider ?></td>
                                                    <td ><?= $deval->ip ?></td>
                                                    <td><?= (!empty($deval->created_at)) ? date("F d, Y H:i:s", strtotime($deval->created_at)) : $deval->created_at ?></td>
                                                </tr>
                                                <?php } ?>
                                                </tbody>
                                                </table>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Tab Content-->
                                <!--begin::Tab Content-->
                                <div class="tab-pane" id="kt_apps_contacts_view_tab_3" role="tabpanel">
                                    <div class="row mb-2">
                                      <div class="col-8">
                                        <div class="card ml-4">
                                            <div class="card-body">
                                                E-Money Virtual Account
                                                <table class="table" id="e-money">
                                                    <thead>
                                                      <tr>
                                                        <th scope="col">Bank Name</th>
                                                        <th scope="col">Account Number</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data_emoney as $de)
                                                        <tr>
                                                            <td>{{$de->name}}</td>
                                                            <td>{{$de->code}}{{$user->username}}</td>
                                                          </tr>
                                                        @endforeach
                                                    </tbody>
                                                  </table>
                                            </div>
                                          </div>
                                      </div>
                                      <div class="col-4">
                                        <a href="/wallet/history/" class="btn btn-sm btn-outline-primary w-75">Transactions</a><br>
                                        <a href="/wallet/history/" class="btn btn-sm btn-outline-primary w-75">All Payments</a><br>
                                        <a href="/wallet/history/" class="btn btn-sm btn-outline-primary w-75">PPOB Transactions</a><br>
                                      </div>
                                    </div>

                                    <div class="card m-4">
                                        <h5 class="card-header bg bg-dark text-white text-center">E Money</h5>
                                        <div class="card-body">
                                          <h5 class="card-title">Resume Wallet {{$data_user_emoney[0]->currency}}</h5>
                                          <div class="row mb-4">
                                            <div class="col">
                                                <label><strong>Balance</strong></label><br>
                                                <span>
                                                    {{ number_format($wallet_summary->balance, 0, ',', '.') }} /
                                                    {{ number_format($wallet_summary->max_balance, 0, ',', '.') }}
                                                </span>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="<?= $wallet_summary->balance / $wallet_summary->max_balance * 100; ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">{{$wallet_summary->balance / $wallet_summary->max_balance * 100}}%</div>
                                                  </div>
                                            </div>
                                            <div class="col">
                                                <label><strong>Monthly Transaction IN</strong></label><br>
                                                <span>
                                                    {{ number_format($wallet_summary->sum_transaction_in, 0, ',', '.') }} /
                                                    {{ number_format($wallet_summary->transaction_monthly, 0, ',', '.') }}
                                                </span>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?= $wallet_summary->sum_transaction_in / $wallet_summary->transaction_monthly * 100; ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">{{ $wallet_summary->sum_transaction_in / $wallet_summary->transaction_monthly * 100}}%</div>
                                                  </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col">
                                                <label><strong>Monthly Transaction OUT</strong></label><br>
                                                <span>
                                                    {{$wallet_summary->sum_transaction_out ? number_format($wallet_summary->sum_transaction_out, 0, ',', '.') : 0}}
                                        / ~
                                                </span>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                  </div>
                                            </div>
                                            <div class="col">
                                                <label><strong>Reversal Fund(s)</strong></label><br>
                                                <span></span>

                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="card m-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Latest Transaction</h5>
                                            <hr>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="align-middle text-center">Type</th>
                                                            <th class="align-middle text-center">Amount</th>
                                                            <th class="align-middle text-center">Balance</th>
                                                            <th class="text-center">Created</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($latest_transaction as $val)
                                                        <tr class="daily-report pointer">
                                                            <td class="text-center">
                                                                {{ $val->transaction_type }}
                                                                <br>
                                                                @if ($val->status == 0)
                                                                <span class="text-danger">Deleted</span>
                                                                @elseif ($val->status == 1)
                                                                <span class="text-warning">Canceled</span>
                                                                @elseif ($val->status == 2)
                                                                <span class="text-primary">Pending</span>
                                                                @elseif ($val->status == 3)
                                                                <span class="text-success">Success</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-right align-middle">IDR
                                                                {{ number_format($val->amount, 2, ',', '.') }}</td>
                                                            <td class="text-right align-middle">IDR
                                                                {{ number_format($val->balance, 2, ',', '.') }}</td>
                                                            <td class="text-center align-middle">
                                                                {{ $val->created_at }}
                                                                <br>
                                                                <small class="text-muted">Updated: {{$val->updated_at}}</small>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <a href="{{route('wallet-history', ['wallet' => $user->id])}}">
                                                <p class="text-right">
                                                    More <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                    <form class="form">
                                        <div class="row">
                                            <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                <!--begin::Notice-->
                                                <div class="alert alert-custom alert-light-danger fade show mb-9" role="alert">
                                                    <div class="alert-icon">
                                                        <i class="flaticon-warning"></i>
                                                    </div>
                                                    <div class="alert-text">Configure user passwords to expire periodically.
                                                    <br />Users will need warning that their passwords are going to expire, or they might inadvertently get locked out of the system!</div>
                                                    <div class="alert-close">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">
                                                                <i class="ki ki-close"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--end::Notice-->
                                            </div>
                                        </div>
                                        <!--begin::Heading-->
                                        <div class="row">
                                            <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                <h3 class="font-size-h6 mb-5">Account:</h3>
                                            </div>
                                        </div>
                                        <!--end::Heading-->
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Username</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="spinner spinner-sm spinner-success spinner-right">
                                                    <input class="form-control form-control-lg form-control-solid" type="text" value="nick84" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Email Address</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-at"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-lg form-control-solid" value="nick.watson@loop.com" placeholder="Email" />
                                                </div>
                                                <span class="form-text text-muted">Email will not be publicly displayed.
                                                <a href="#">Learn more</a>.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Language</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select class="form-control form-control-lg form-control-solid">
                                                    <option>Select Language...</option>
                                                    <option value="id">Bahasa Indonesia - Indonesian</option>
                                                    <option value="msa">Bahasa Melayu - Malay</option>
                                                    <option value="ca">Català - Catalan</option>
                                                    <option value="cs">Čeština - Czech</option>
                                                    <option value="da">Dansk - Danish</option>
                                                    <option value="de">Deutsch - German</option>
                                                    <option value="en" selected="selected">English</option>
                                                    <option value="en-gb">English UK - British English</option>
                                                    <option value="es">Español - Spanish</option>
                                                    <option value="eu">Euskara - Basque (beta)</option>
                                                    <option value="fil">Filipino</option>
                                                    <option value="fr">Français - French</option>
                                                    <option value="ga">Gaeilge - Irish (beta)</option>
                                                    <option value="gl">Galego - Galician (beta)</option>
                                                    <option value="hr">Hrvatski - Croatian</option>
                                                    <option value="it">Italiano - Italian</option>
                                                    <option value="hu">Magyar - Hungarian</option>
                                                    <option value="nl">Nederlands - Dutch</option>
                                                    <option value="no">Norsk - Norwegian</option>
                                                    <option value="pl">Polski - Polish</option>
                                                    <option value="pt">Português - Portuguese</option>
                                                    <option value="ro">Română - Romanian</option>
                                                    <option value="sk">Slovenčina - Slovak</option>
                                                    <option value="fi">Suomi - Finnish</option>
                                                    <option value="sv">Svenska - Swedish</option>
                                                    <option value="vi">Tiếng Việt - Vietnamese</option>
                                                    <option value="tr">Türkçe - Turkish</option>
                                                    <option value="el">Ελληνικά - Greek</option>
                                                    <option value="bg">Български език - Bulgarian</option>
                                                    <option value="ru">Русский - Russian</option>
                                                    <option value="sr">Српски - Serbian</option>
                                                    <option value="uk">Українська мова - Ukrainian</option>
                                                    <option value="he">עִבְרִית - Hebrew</option>
                                                    <option value="ur">اردو - Urdu (beta)</option>
                                                    <option value="ar">العربية - Arabic</option>
                                                    <option value="fa">فارسی - Persian</option>
                                                    <option value="mr">मराठी - Marathi</option>
                                                    <option value="hi">हिन्दी - Hindi</option>
                                                    <option value="bn">বাংলা - Bangla</option>
                                                    <option value="gu">ગુજરાતી - Gujarati</option>
                                                    <option value="ta">தமிழ் - Tamil</option>
                                                    <option value="kn">ಕನ್ನಡ - Kannada</option>
                                                    <option value="th">ภาษาไทย - Thai</option>
                                                    <option value="ko">한국어 - Korean</option>
                                                    <option value="ja">日本語 - Japanese</option>
                                                    <option value="zh-cn">简体中文 - Simplified Chinese</option>
                                                    <option value="zh-tw">繁體中文 - Traditional Chinese</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Time Zone</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select class="form-control form-control-lg form-control-solid">
                                                    <option data-offset="-39600" value="International Date Line West">(GMT-11:00) International Date Line West</option>
                                                    <option data-offset="-39600" value="Midway Island">(GMT-11:00) Midway Island</option>
                                                    <option data-offset="-39600" value="Samoa">(GMT-11:00) Samoa</option>
                                                    <option data-offset="-36000" value="Hawaii">(GMT-10:00) Hawaii</option>
                                                    <option data-offset="-28800" value="Alaska">(GMT-08:00) Alaska</option>
                                                    <option data-offset="-25200" value="Pacific Time (US &amp; Canada)">(GMT-07:00) Pacific Time (US &amp; Canada)</option>
                                                    <option data-offset="-25200" value="Tijuana">(GMT-07:00) Tijuana</option>
                                                    <option data-offset="-25200" value="Arizona">(GMT-07:00) Arizona</option>
                                                    <option data-offset="-21600" value="Mountain Time (US &amp; Canada)">(GMT-06:00) Mountain Time (US &amp; Canada)</option>
                                                    <option data-offset="-21600" value="Chihuahua">(GMT-06:00) Chihuahua</option>
                                                    <option data-offset="-21600" value="Mazatlan">(GMT-06:00) Mazatlan</option>
                                                    <option data-offset="-21600" value="Saskatchewan">(GMT-06:00) Saskatchewan</option>
                                                    <option data-offset="-21600" value="Central America">(GMT-06:00) Central America</option>
                                                    <option data-offset="-18000" value="Central Time (US &amp; Canada)">(GMT-05:00) Central Time (US &amp; Canada)</option>
                                                    <option data-offset="-18000" value="Guadalajara">(GMT-05:00) Guadalajara</option>
                                                    <option data-offset="-18000" value="Mexico City">(GMT-05:00) Mexico City</option>
                                                    <option data-offset="-18000" value="Monterrey">(GMT-05:00) Monterrey</option>
                                                    <option data-offset="-18000" value="Bogota">(GMT-05:00) Bogota</option>
                                                    <option data-offset="-18000" value="Lima">(GMT-05:00) Lima</option>
                                                    <option data-offset="-18000" value="Quito">(GMT-05:00) Quito</option>
                                                    <option data-offset="-14400" value="Eastern Time (US &amp; Canada)">(GMT-04:00) Eastern Time (US &amp; Canada)</option>
                                                    <option data-offset="-14400" value="Indiana (East)">(GMT-04:00) Indiana (East)</option>
                                                    <option data-offset="-14400" value="Caracas">(GMT-04:00) Caracas</option>
                                                    <option data-offset="-14400" value="La Paz">(GMT-04:00) La Paz</option>
                                                    <option data-offset="-14400" value="Georgetown">(GMT-04:00) Georgetown</option>
                                                    <option data-offset="-10800" value="Atlantic Time (Canada)">(GMT-03:00) Atlantic Time (Canada)</option>
                                                    <option data-offset="-10800" value="Santiago">(GMT-03:00) Santiago</option>
                                                    <option data-offset="-10800" value="Brasilia">(GMT-03:00) Brasilia</option>
                                                    <option data-offset="-10800" value="Buenos Aires">(GMT-03:00) Buenos Aires</option>
                                                    <option data-offset="-9000" value="Newfoundland">(GMT-02:30) Newfoundland</option>
                                                    <option data-offset="-7200" value="Greenland">(GMT-02:00) Greenland</option>
                                                    <option data-offset="-7200" value="Mid-Atlantic">(GMT-02:00) Mid-Atlantic</option>
                                                    <option data-offset="-3600" value="Cape Verde Is.">(GMT-01:00) Cape Verde Is.</option>
                                                    <option data-offset="0" value="Azores">(GMT) Azores</option>
                                                    <option data-offset="0" value="Monrovia">(GMT) Monrovia</option>
                                                    <option data-offset="0" value="UTC">(GMT) UTC</option>
                                                    <option data-offset="3600" value="Dublin">(GMT+01:00) Dublin</option>
                                                    <option data-offset="3600" value="Edinburgh">(GMT+01:00) Edinburgh</option>
                                                    <option data-offset="3600" value="Lisbon">(GMT+01:00) Lisbon</option>
                                                    <option data-offset="3600" value="London">(GMT+01:00) London</option>
                                                    <option data-offset="3600" value="Casablanca">(GMT+01:00) Casablanca</option>
                                                    <option data-offset="3600" value="West Central Africa">(GMT+01:00) West Central Africa</option>
                                                    <option data-offset="7200" value="Belgrade">(GMT+02:00) Belgrade</option>
                                                    <option data-offset="7200" value="Bratislava">(GMT+02:00) Bratislava</option>
                                                    <option data-offset="7200" value="Budapest">(GMT+02:00) Budapest</option>
                                                    <option data-offset="7200" value="Ljubljana">(GMT+02:00) Ljubljana</option>
                                                    <option data-offset="7200" value="Prague">(GMT+02:00) Prague</option>
                                                    <option data-offset="7200" value="Sarajevo">(GMT+02:00) Sarajevo</option>
                                                    <option data-offset="7200" value="Skopje">(GMT+02:00) Skopje</option>
                                                    <option data-offset="7200" value="Warsaw">(GMT+02:00) Warsaw</option>
                                                    <option data-offset="7200" value="Zagreb">(GMT+02:00) Zagreb</option>
                                                    <option data-offset="7200" value="Brussels">(GMT+02:00) Brussels</option>
                                                    <option data-offset="7200" value="Copenhagen">(GMT+02:00) Copenhagen</option>
                                                    <option data-offset="7200" value="Madrid">(GMT+02:00) Madrid</option>
                                                    <option data-offset="7200" value="Paris">(GMT+02:00) Paris</option>
                                                    <option data-offset="7200" value="Amsterdam">(GMT+02:00) Amsterdam</option>
                                                    <option data-offset="7200" value="Berlin">(GMT+02:00) Berlin</option>
                                                    <option data-offset="7200" value="Bern">(GMT+02:00) Bern</option>
                                                    <option data-offset="7200" value="Rome">(GMT+02:00) Rome</option>
                                                    <option data-offset="7200" value="Stockholm">(GMT+02:00) Stockholm</option>
                                                    <option data-offset="7200" value="Vienna">(GMT+02:00) Vienna</option>
                                                    <option data-offset="7200" value="Cairo">(GMT+02:00) Cairo</option>
                                                    <option data-offset="7200" value="Harare">(GMT+02:00) Harare</option>
                                                    <option data-offset="7200" value="Pretoria">(GMT+02:00) Pretoria</option>
                                                    <option data-offset="10800" value="Bucharest">(GMT+03:00) Bucharest</option>
                                                    <option data-offset="10800" value="Helsinki">(GMT+03:00) Helsinki</option>
                                                    <option data-offset="10800" value="Kiev">(GMT+03:00) Kiev</option>
                                                    <option data-offset="10800" value="Kyiv">(GMT+03:00) Kyiv</option>
                                                    <option data-offset="10800" value="Riga">(GMT+03:00) Riga</option>
                                                    <option data-offset="10800" value="Sofia">(GMT+03:00) Sofia</option>
                                                    <option data-offset="10800" value="Tallinn">(GMT+03:00) Tallinn</option>
                                                    <option data-offset="10800" value="Vilnius">(GMT+03:00) Vilnius</option>
                                                    <option data-offset="10800" value="Athens">(GMT+03:00) Athens</option>
                                                    <option data-offset="10800" value="Istanbul">(GMT+03:00) Istanbul</option>
                                                    <option data-offset="10800" value="Minsk">(GMT+03:00) Minsk</option>
                                                    <option data-offset="10800" value="Jerusalem">(GMT+03:00) Jerusalem</option>
                                                    <option data-offset="10800" value="Moscow">(GMT+03:00) Moscow</option>
                                                    <option data-offset="10800" value="St. Petersburg">(GMT+03:00) St. Petersburg</option>
                                                    <option data-offset="10800" value="Volgograd">(GMT+03:00) Volgograd</option>
                                                    <option data-offset="10800" value="Kuwait">(GMT+03:00) Kuwait</option>
                                                    <option data-offset="10800" value="Riyadh">(GMT+03:00) Riyadh</option>
                                                    <option data-offset="10800" value="Nairobi">(GMT+03:00) Nairobi</option>
                                                    <option data-offset="10800" value="Baghdad">(GMT+03:00) Baghdad</option>
                                                    <option data-offset="14400" value="Abu Dhabi">(GMT+04:00) Abu Dhabi</option>
                                                    <option data-offset="14400" value="Muscat">(GMT+04:00) Muscat</option>
                                                    <option data-offset="14400" value="Baku">(GMT+04:00) Baku</option>
                                                    <option data-offset="14400" value="Tbilisi">(GMT+04:00) Tbilisi</option>
                                                    <option data-offset="14400" value="Yerevan">(GMT+04:00) Yerevan</option>
                                                    <option data-offset="16200" value="Tehran">(GMT+04:30) Tehran</option>
                                                    <option data-offset="16200" value="Kabul">(GMT+04:30) Kabul</option>
                                                    <option data-offset="18000" value="Ekaterinburg">(GMT+05:00) Ekaterinburg</option>
                                                    <option data-offset="18000" value="Islamabad">(GMT+05:00) Islamabad</option>
                                                    <option data-offset="18000" value="Karachi">(GMT+05:00) Karachi</option>
                                                    <option data-offset="18000" value="Tashkent">(GMT+05:00) Tashkent</option>
                                                    <option data-offset="19800" value="Chennai">(GMT+05:30) Chennai</option>
                                                    <option data-offset="19800" value="Kolkata">(GMT+05:30) Kolkata</option>
                                                    <option data-offset="19800" value="Mumbai">(GMT+05:30) Mumbai</option>
                                                    <option data-offset="19800" value="New Delhi">(GMT+05:30) New Delhi</option>
                                                    <option data-offset="19800" value="Sri Jayawardenepura">(GMT+05:30) Sri Jayawardenepura</option>
                                                    <option data-offset="20700" value="Kathmandu">(GMT+05:45) Kathmandu</option>
                                                    <option data-offset="21600" value="Astana">(GMT+06:00) Astana</option>
                                                    <option data-offset="21600" value="Dhaka">(GMT+06:00) Dhaka</option>
                                                    <option data-offset="21600" value="Almaty">(GMT+06:00) Almaty</option>
                                                    <option data-offset="21600" value="Urumqi">(GMT+06:00) Urumqi</option>
                                                    <option data-offset="23400" value="Rangoon">(GMT+06:30) Rangoon</option>
                                                    <option data-offset="25200" value="Novosibirsk">(GMT+07:00) Novosibirsk</option>
                                                    <option data-offset="25200" value="Bangkok">(GMT+07:00) Bangkok</option>
                                                    <option data-offset="25200" value="Hanoi">(GMT+07:00) Hanoi</option>
                                                    <option data-offset="25200" value="Jakarta">(GMT+07:00) Jakarta</option>
                                                    <option data-offset="25200" value="Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                                                    <option data-offset="28800" value="Beijing">(GMT+08:00) Beijing</option>
                                                    <option data-offset="28800" value="Chongqing">(GMT+08:00) Chongqing</option>
                                                    <option data-offset="28800" value="Hong Kong">(GMT+08:00) Hong Kong</option>
                                                    <option data-offset="28800" value="Kuala Lumpur">(GMT+08:00) Kuala Lumpur</option>
                                                    <option data-offset="28800" value="Singapore">(GMT+08:00) Singapore</option>
                                                    <option data-offset="28800" value="Taipei">(GMT+08:00) Taipei</option>
                                                    <option data-offset="28800" value="Perth">(GMT+08:00) Perth</option>
                                                    <option data-offset="28800" value="Irkutsk">(GMT+08:00) Irkutsk</option>
                                                    <option data-offset="28800" value="Ulaan Bataar">(GMT+08:00) Ulaan Bataar</option>
                                                    <option data-offset="32400" value="Seoul">(GMT+09:00) Seoul</option>
                                                    <option data-offset="32400" value="Osaka">(GMT+09:00) Osaka</option>
                                                    <option data-offset="32400" value="Sapporo">(GMT+09:00) Sapporo</option>
                                                    <option data-offset="32400" value="Tokyo">(GMT+09:00) Tokyo</option>
                                                    <option data-offset="32400" value="Yakutsk">(GMT+09:00) Yakutsk</option>
                                                    <option data-offset="34200" value="Darwin">(GMT+09:30) Darwin</option>
                                                    <option data-offset="34200" value="Adelaide">(GMT+09:30) Adelaide</option>
                                                    <option data-offset="36000" value="Canberra">(GMT+10:00) Canberra</option>
                                                    <option data-offset="36000" value="Melbourne">(GMT+10:00) Melbourne</option>
                                                    <option data-offset="36000" value="Sydney">(GMT+10:00) Sydney</option>
                                                    <option data-offset="36000" value="Brisbane">(GMT+10:00) Brisbane</option>
                                                    <option data-offset="36000" value="Hobart">(GMT+10:00) Hobart</option>
                                                    <option data-offset="36000" value="Vladivostok">(GMT+10:00) Vladivostok</option>
                                                    <option data-offset="36000" value="Guam">(GMT+10:00) Guam</option>
                                                    <option data-offset="36000" value="Port Moresby">(GMT+10:00) Port Moresby</option>
                                                    <option data-offset="36000" value="Solomon Is.">(GMT+10:00) Solomon Is.</option>
                                                    <option data-offset="39600" value="Magadan">(GMT+11:00) Magadan</option>
                                                    <option data-offset="39600" value="New Caledonia">(GMT+11:00) New Caledonia</option>
                                                    <option data-offset="43200" value="Fiji">(GMT+12:00) Fiji</option>
                                                    <option data-offset="43200" value="Kamchatka">(GMT+12:00) Kamchatka</option>
                                                    <option data-offset="43200" value="Marshall Is.">(GMT+12:00) Marshall Is.</option>
                                                    <option data-offset="43200" value="Auckland">(GMT+12:00) Auckland</option>
                                                    <option data-offset="43200" value="Wellington">(GMT+12:00) Wellington</option>
                                                    <option data-offset="46800" value="Nuku'alofa">(GMT+13:00) Nuku'alofa</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center mb-0">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Communication</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                    <input type="checkbox" />
                                                    <span></span>Email</label>
                                                    <label class="checkbox">
                                                    <input type="checkbox" />
                                                    <span></span>SMS</label>
                                                    <label class="checkbox">
                                                    <input type="checkbox" />
                                                    <span></span>Phone</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-10"></div>
                                        <!--begin::Heading-->
                                        <div class="row">
                                            <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                <h3 class="font-size-h6 mb-5">Security:</h3>
                                            </div>
                                        </div>
                                        <!--end::Heading-->
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Login verification</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <button type="button" class="btn btn-light-primary font-weight-bold btn-sm">Setup login verification</button>
                                                <span class="form-text text-muted">After you log in, you will be asked for additional information to confirm your identity and protect your account from being compromised.
                                                <a href="#">Learn more</a>.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Password reset verification</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                    <input type="checkbox" />Require personal information to reset your password.
                                                    <span></span></label>
                                                </div>
                                                <span class="form-text text-muted">For extra security, this requires you to confirm your email or phone number when you reset your password.
                                                <a href="#">Learn more</a>.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <button type="button" class="btn btn-light-danger font-weight-bold btn-sm">Deactivate your account ?</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--end::Tab Content-->
                                <!--begin::Tab Content-->
                                <div class="tab-pane" id="kt_apps_contacts_view_tab_4" role="tabpanel">
                                    <div class="rows">
                                        <div class="col-md-12">
                                            <?php if(isset($statistic_user) && !empty($statistic_user)){ ?>
                                            <div class="panel panel-white">
                                                        <div class="panel-heading clearfix">
                                                                        <div class="panel-title">
                                                                        Statistic User
                                                                        </div>
                                                        </div>
                                                        <div class="panel-body">
                                                        <table class="table table-bordered" style="border:1px solid #eee;">
                                                            <tr>
                                                            <th width="30%">Total Login</th>
                                                            <th><?= $statistic_user->total_login; ?></th>
                                                            </tr>

                                                        </table>
                                                        </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="rows">
                                        <div class='col-xs-12 col-md-12 col-sm-12'>
                                            <?php if(isset($activity_user) && !empty($activity_user)){ ?>
                                            <div class="panel panel-white">
                                                        <div class="panel-heading clearfix">
                                                                        <div class="panel-title">
                                                                        Activity User
                                                                        </div>
                                                        </div>
                                                        <div class="panel-body">
                                                        <table id="activityUsers" class="table table-bordered table-responsive" style="border:1px solid #eee; width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Activity Screen</th>
                                                                <th>Open Time</th>
                                                                <th>Leave Time</th>
                                                                <th>Next Activity</th>
                                                                <th>Created</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            $noac=1;
                                                            foreach($activity_user as $actval){
                                                                $actscreen = (!empty($actval->activity_screen)) ? $actval->activity_screen : "-";
                                                                ?><tr>
                                                                    <th><?= $noac++ ?></th>
                                                                    <th><?= $actscreen ?></th>
                                                                    <th><?= $actval->open_time ?></th>
                                                                    <th><?= $actval->leave_time ?></th>
                                                                    <th><?= $actval->next_activity_screen ?></th>
                                                                    <th><?= $actval->created_at ?></th>
                                                                </tr><?php

                                                            }

                                                            ?>
                                                        </tbody>
                                                        </table>
                                                        </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Tab Content-->
                                <!--begin::Tab Content-->
                                <div class="tab-pane" id="kt_apps_contacts_view_tab_5" role="tabpanel">
                                    <div class="rows">
                                        <div class="col-md-12">
                                            <?php // if(isset($kyc_history) && !empty($kyc_history)){ ?>
                                            <div class="panel panel-white">
                                                        <div class="panel-heading clearfix">
                                                                        <div class="panel-title">
                                                                        KYC History
                                                                        </div>
                                                        </div>
                                                        <table class="table table-bordered" style="border:1px solid #eee;">

                                                        <?php
                                                        if(!empty($kyc_history)){
                                                        foreach($kyc_history as $kych){
                                                        // if(empty($kych->type)){
                                                        //
                                                        //   $stats_rej = (!empty($kych->rejection)) ? "rejected" : "verified";
                                                        //   if($is_verif > 0) $stats_rej = "approved";
                                                        //   if($stats_rej == "verified") $is_verif++;
                                                        // }else $stats_rej = "unykc";

                                                        switch($kych->type){
                                                            case "requestEdit_kyc" : $stats_rej = "request approved by";break;
                                                            case "unkyc_account" : $stats_rej = "unkyc";break;
                                                            case "approve_kyc" : $stats_rej = "approved";break;
                                                            case "reject_kyc" : $stats_rej = "rejected";break;
                                                            default : $stats_rej = "request approved by";break;
                                                        }
                                                        $reason = false;
                                                        $contents = (!empty($kych->content)) ? json_decode($kych->content, TRUE) : null;
                                                        if($stats_rej == "rejected" && isset($contents->rejection)){
                                                            $reason = array_search($contents->rejection, array_column($kyc_reason, 'id'));
                                                            if ($reason !== false) $reason = $kyc_reason[$reason];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th><b><?= $stats_rej; ?></b> by : <?= (isset($operator_name) && !empty($operator_name)) ? $operator_name: "-" ?></th>
                                                            <th><i class="fa fa-calendar"></i> <?=  date("M d, Y H:i:s", strtotime($kych->created)); ?></th>
                                                        </tr>
                                                            <?php if($reason) :?>
                                                        <tr>
                                                            <th colspan="2"><b> <?= ucwords($reason->subject) ?? '-'; ?> </b> <br><b>Reason :</b>  <?= $reason->content ?? '-' ?></th>
                                                        </tr>
                                                            <?php endif;?>
                                                        <?php }
                                                    }else{
                                                        $is_verif = 0;
                                                        foreach($kyc_history2 as $kych){
                                                        if(empty($kych->type)){
                                                            $stats_rej = (!empty($kych->rejection)) ? "rejected" : "verified";
                                                            if($is_verif > 0) $stats_rej = "approved";
                                                            if($stats_rej == "verified") $is_verif++;
                                                        }else $stats_rej = "unykc";
                                                        $reason = false;
                                                        if(!empty($kych->rejection)){
                                                            $reason = array_search($kych->rejection, array_column($kyc_reason, 'id'));
                                                            if ($reason !== false) $reason = $kyc_reason[$reason];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th><b><?= $stats_rej; ?></b> by : <?= (!empty($kych->name)) ? $kych->name : "-" ?></th>
                                                            <th><i class="fa fa-calendar"></i> <?=  datePlus7($kych->created); ?></th>
                                                        </tr>
                                                            <?php if($reason) :?>
                                                        <tr>
                                                            <th colspan="2"><b> <?= ucwords($reason->subject) ?? '-'; ?> </b> <br><b>Reason :</b>  <?= $reason->content ?? '-' ?></th>
                                                        </tr>
                                                        <?php endif;?>
                                                        <?php
                                                        }
                                                    } ?>
                                                        </table>
                                                </div>
                                            <?php // } ?>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <?php if(isset($list_media) && !empty($list_media)) : ?>
                                    <div class="rows">
                                        <div class="col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading clearfix">
                                            <div class="panel-title">History Media Upload</div>
                                            </div>
                                            <div class="panel-body">
                                            <div id="histMediaPicture" class="row" style="display: flex;flex-wrap: wrap;">
                                                <?php if(count($list_media['data']) > 0) : ?>
                                                <?php foreach($list_media['data'] as $item) : ?>
                                                    <div class="col-md-4">
                                                    <?php if(!empty($item->url)) : ?>
                                                        <a href="<?= $item->url ?>" class="thumbnail" onclick="return modalizeMe(this);">
                                                        <div style="overflow:hidden;">
                                                            <?= !empty($item->name) ? $item->name."<br/>" : "" ?>
                                                            <?= !empty($item->created_at) ? "<small>created : ".$item->created_at."</small>" : "" ?>
                                                        </div>
                                                        <img src="<?= $item->url ?>?size=300xnull" style="width: -webkit-fill-available;max-height: 300px;object-fit: fill;"/>
                                                        </a>
                                                    <?php else: ?>
                                                        <div class="panel panel-default">
                                                        <em>Photo Image not found</em>
                                                        </div>
                                                    <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="float:right;">
                                                <ul class="pagination" style="float:right;">
                                                    <?php if(isset($list_media['previous'])) : ?>
                                                    <li class="<?= ($list_media['previous'] == 0) ? 'disabled' : '' ?>">
                                                        <a href="javascript:void(0)" aria-label="Previous" class="showMediaUsers" data-id="<?= $user->id ?>" data-pages="<?= $list_media['previous'] ?>">
                                                        <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <?php endif; ?>

                                                    <?php if(isset($list_media['pagination'])): ?>
                                                    <?php for($i=0 ;$i < $list_media['pagination']; $i++) : ?>
                                                        <li id="active-<?= ($i+1)?>" class="histMediaPaginate <?= ($list_media['active'] == ($i+1)) ? 'active' : '' ?>"><a href="javascript:void(0)" class="showMediaUsers" data-id="<?= $user->id ?>" data-pages="<?= ($i+1) ?>"><?= $i+1 ?><span class="sr-only">(current)</span></a></li>
                                                    <?php endfor; ?>
                                                    <?php endif; ?>

                                                    <?php if(isset($list_media['next'])) : ?>
                                                    <li class="<?= ($list_media['next'] == 0) ? 'disabled' : '' ?>">
                                                        <a href="javascript:void(0)" aria-label="Next" class='showMediaUsers' data-id="<?= $user->id ?>" data-pages="<?= $list_media['next'] ?>">
                                                        <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                    <?php endif; ?>
                                                </ul>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <!--end::Tab Content-->
                                <!--begin::Tab Content-->
                                <div class="tab-pane" id="kt_apps_contacts_view_tab_6" role="tabpanel">
                                    <div class="rows">
                                        <div class="col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading clearfix">
                                                    <div class="panel-title">Change Pin History</div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive" style="padding-right: 15px;max-height: 300px">
                                                        <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                            <th>Change</th>
                                                            <th>IP Address</th>
                                                            <th>Location</th>
                                                            <th>Devices</th>
                                                            <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(!empty($pinHistory)) : ?>
                                                            <?php $i= count($pinHistory); ?>
                                                            <?php foreach($pinHistory as $item) : ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td><?= !empty($item->ip) ? $item->ip : "-" ?></td>
                                                                    <td><?= !empty($item->location) ? (!empty($item->location) ? $item->location : "-" ) : "-" ?></td>
                                                                    <td><?= !empty($item->device_name) ? $item->device_name : "-" ?></td>
                                                                    <td><i class="fa fa-calendar"></i> <?= date("M d, Y H:i:s", strtotime('+7 hours', strtotime($item->created_at))) ?></td>
                                                                </tr>
                                                                <?php $i--; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rows">
                                        <div class="col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading clearfix">
                                                    <div class="panel-title">History for Wrong PIN Attempt</div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive" style="padding-right: 15px;max-height: 300px">
                                                        <table class="table table-bordered ">
                                                        <thead>
                                                            <tr>
                                                            <th>Attempt</th>
                                                            <th>IP Address</th>
                                                            <th>Location</th>
                                                            <th>Devices</th>
                                                            <th>Reason</th>
                                                            <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(!empty($wrongPinHistory)) : ?>
                                                            <?php $i= count($wrongPinHistory); ?>
                                                            <?php foreach($wrongPinHistory as $item) : ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td><?= !empty($item->ip) ? $item->ip : "-" ?></td>
                                                                    <td><?= !empty($item->location) ? (!empty($item->location) ? $item->location : "-" ) : "-" ?></td>
                                                                    <td><?= !empty($item->device_name) ? $item->device_name : "-" ?></td>
                                                                    <td><?= !empty($item->message) ? $item->message : "-" ?></td>
                                                                    <td><i class="fa fa-calendar"></i> <?= date("M d, Y H:i:s", strtotime('+7 hours', strtotime($item->created_at))) ?></td>
                                                                </tr>
                                                                <?php $i--; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Tab Content-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
@endsection
@section('content_js')


<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script>
<script>
    $(document).ready( function () {
    $('#e-money').DataTable({
    "bLengthChange": false,
    "searching": false,
    "pageLength" : 5,
    });
} );
</script>
@endsection
