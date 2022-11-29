@extends('layouts.template.app')

@section('content_body')
    <div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ $page_title }}</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="{{ route('user-close-accounts') }}" class="btn btn-primary font-weight-bold">Back</a>
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

                <!-- user information -->
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-t">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Account Information</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <div class="row my-2">
                                    <label class="col-4">username:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder"><a href="/user/list/{{$info->user_id}}">{{isset($info->username) ? $info->username : '-'}}</a></span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Name:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($info->name) ? $info->name : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">email:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($info->email) ? $info->email : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Email Verified:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($info->email) ? $info->email == 1 ? 'Yes' : 'No' : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Phone Number:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">+{{isset($info->phone) ? $info->phone : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">User Type:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($info->user_type) ? $info->user_type : '-'}}</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Row-->
                </div>

                <!-- request close account info -->
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-t">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Close Account Information</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <div class="row my-2">
                                    <label class="col-4">Request status:</label>
                                    <div class="col-6">
                                        @if ($info->status == 1)
                                            <span class="text-secondary font-weight-bolder">Requested</span>
                                        @elseif ($info->status == 2)
                                            <span class="text-warning font-weight-bolder">Pending</span>
                                        @elseif ($info->status == 3)
                                            <span class="text-warning font-weight-bolder">On Prosess</span>
                                        @elseif ($info->status == 4)
                                            <span class="text-danger font-weight-bolder">Rejected</span>
                                        @elseif ($info->status == 5)
                                            <span class="text-success font-weight-bolder">Accepted</span>
                                        @elseif ($info->status == 6)
                                            <span class="text-success font-weight-bolder">done</span>
                                        @else 
                                            <span class="font-weight-bolder">{{isset($info->status) ? $info->status : '-'}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">emoticon:</label>
                                    <div class="col-6" style="height: 25px; width: 25px;">
                                        <span class="font-weight-bolder"><img class="mw-100 mh-100" src="{{isset($info->emoticon) ? $info->emoticon : '-'}}" alt="{{isset($info->emoticon) ? $info->emoticon : '-'}}"></span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">content:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($info->content) ? $info->content : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Request Date:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($info->created_at) ? $info->created_at : '-'}}</span>
                                    </div>
                                </div>
                                <!-- if approved or rejected -->
                                <div {{$info->status < 4 ? 'hidden': ''}}>
                                    <div class="row my-2">
                                        <label class="col-4">Approval By:</label>
                                        <div class="col-6">
                                            <span class="font-weight-bolder">{{isset($info->approval_by) ? $info->approval_by : '-'}}</span>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <label class="col-4">Approval At:</label>
                                        <div class="col-6">
                                            <span class="font-weight-bolder">{{isset($info->approved_at) ? $info->approved_at : '-'}}</span>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <label class="col-4">Reason:</label>
                                        <div class="col-6">
                                            <span class="font-weight-bolder">{{isset($info->reason) ? $info->reason : '-'}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Row-->
                </div>

                <!-- meta information -->
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-t">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Meta</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <div class="row my-2">
                                    <label class="col-4">Method:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($meta->method) ? $meta->method : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Bank Account:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($meta->data->bank_account) ? $meta->data->bank_account : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Bank Name:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($meta->data->bank_name) ? $meta->data->bank_name : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Bank Account Name:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">{{isset($meta->data->bank_account_name) ? $meta->data->bank_account_name : '-'}}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <label class="col-4">Amount:</label>
                                    <div class="col-6">
                                        <span class="font-weight-bolder">IDR {{isset($meta->data->amount) ? number_format($meta->data->amount, 2, ',', '.') : '-'}}</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Row-->
                </div>

                <!-- form -->
                <div class="row justify-content-center mb-2" id="form" {{$info->status == 3 || $info->status == 2 ? '': 'hidden'}}>
                    <div class="col-xl-5">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-t p-4">
                            <form action="{{ route('user-closeaccount-store') }}" method="POST">
                                @csrf
                                @method('POST')
                                <!--begin::Form-->
                                <input type="hidden" name="closeaccount_id" value="{{$info->id}}">
                                <div class="card-body py-4 radio-inline">
                                    <label class="radio mx-4">
                                        <input type="radio" name="status" value="reject"/>
                                        <span></span>
                                        Reject
                                    </label>
                                    <label class="radio mx-4">
                                        <input type="radio" name="status" checked="checked" value="approve" />
                                        <span></span>
                                        Approve
                                    </label>
                                </div>
                                <div class="form-group mb-4 px-10">
                                    <label for="reason">Reason:</label>
                                    <textarea class="form-control form-control-solid" rows="3" cols="40" name="reason" id="reason"></textarea>
                                </div>
                                <div class="form-group row my-2">
                                    <div class="col text-center">
                                        <button class="btn btn-light-success" type="submit"><i class="flaticon2-check-mark"></i> Save</button>
                                    </div>
                                </div>
                                <!--end::Form-->
                            </form>
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

@section('content_js')
<script>
    $('input[name="status"]').on('change', function(e) {
        if (e.target.value == 'reject') {
            $("textarea").attr("required", "required");
        } else {
            $("textarea").removeAttr("required");
        }
    });
</script>
@endsection
