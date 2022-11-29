@extends('layouts.template.app')

@section('content_body')

<div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Detail KYC User</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->
            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="{{route('user-kyc')}}" class="btn btn-default font-weight-bold">Back</a>
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
                <div class="col-xl-6">
                    <form class="form" method="post" action="{{route('user-kyc.update', ['id' => $user->id])}}" autocomplete="off">
                    @csrf
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
                                        <label class="col-4 col-form-label">Place of Birth:</label>
                                        <div class="col-8">
                                            <input type="hidden" name="id" readonly class="form-control" value="{{ request()->id }}">
                                            <input class="form-control @error('place_of_birth') is-invalid @enderror" type="text" name="place_of_birth" value="{{ old('place_of_birth') ?: $user->place_of_birth }}">
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Date of Birth:</label>
                                        <div class="col-8">
                                            <input class="form-control @error('date_of_birth') is-invalid @enderror" type="date" name="date_of_birth" value="{{ old('date_of_birth') ?: $user->date_of_birth }}">
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Gender:</label>
                                        <div class="col-8">
                                            <select name="gender" class="form-control selectpicker @error('provider') is-invalid @enderror">
                                                <option value="1" {{ $user->gender == 1 ? 'selected' : ''}} >Male</option>
                                                <option value="0" {{ $user->gender == 0 ? 'selected' : ''}} >Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Nationality:</label>
                                        <div class="col-8">
                                            <input class="form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" value="{{ old('nationality') ?: $user_info->nationality }}">
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Identity Type:</label>
                                        <div class="col-8">
                                            <select name="identity_type" class="form-control selectpicker @error('identity_type') is-invalid @enderror">
                                                <option value="KTP" {{ $user_info->identity_number == 'KTP' ? 'selected' : ''}}>KTP</option>
                                                <option value="Kartu Pelajar" {{ $user_info->identity_number == 'Kartu Pelajar' ? 'selected' : ''}}>Kartu Pelajar</option>
                                                <option value="Passport" {{ $user_info->identity_number == 'Passport' ? 'selected' : ''}}>Passport</option>
                                                <option value="SIM" {{ $user_info->identity_number == 'SIM' ? 'selected' : ''}}>SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Identity Number:</label>
                                        <div class="col-8">
                                            <input class="form-control @error('identity_number') is-invalid @enderror" type="text" name="identity_number" value="{{ old('identity_number') ?: $user_info->identity_number }}">
                                        </div>
                                    </div>
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Jobs :</label>
                                        <div class="col-8">
                                            <select name="jobs" class="form-control selectpicker @error('provider') is-invalid @enderror">
                                                <option value="">-- Select Jobs --</option>
                                                @if(!isset($jobs))
                                                @foreach ($all_jobs as $val)
                                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                                @else
                                                @foreach ($all_jobs as $val)
                                                <option value="{{ $val->id }}" {{ $val->id == $jobs->job_id ? 'selected' : ''}}>{{ $val->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <!--end::Body-->
                        </div>

                        <div class="card card-custom bg-warning gutter-t">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">KYC Decision 
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                                <div class="card-body py-4">
                                    <div class="form-group row my-2">
                                        <label class="col-4 col-form-label">Status:</label>
                                        <div class="col-8">
                                            <select name="decision" class="form-control selectpicker @error('decision') is-invalid @enderror">
                                                <option value="reject" >Reject</option>
                                                <option value="accept" >Accept</option>
                                                <option value="request" >Request Approve</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="field-reason">Reason</label>
                                            <textarea id="field-reason" name="reason" placeholder="Reason" rows="5" class="form-control" style="resize:none"></textarea>
                                    </div>
                                </div>
                            <!--end::Body-->
                            <div class="card-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-dark pull-right HandlingError" style="margin-right: 10px">Submit</button>
                            </div>
                        </div>



                    <!--end::Card-->
                    </form>
                </div>
                <div class="col-xl-6">
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
                                                                <div class="col-md-12">
                                                                    <div class="card card-custom gutter-t">
                                                                        <div class="card-header h-auto py-4">
                                                                            <div class="card-title">List History KYC Account</div>
                                                                        </div>
                                                                        <div class="card-body py-4">
                                                                            <div class="s">
                                                                                <table class="datatablez table table-bordered">
                                                                                    <thead>
                                                                                    <th>Operator</th>
                                                                                    <th>Type</th>
                                                                                    <th>Date</th>
                                                                                    <th>Reason</th>
                                                                                    </thead>

                                                                                    <tbody>
                                                                                    @if(isset($listLog))
                                                                                        <?php $i=0; ?>
                                                                                        <?php foreach($listLog as $ls) : ?>
                                                                                        <tr>
                                                                                            <td><?= isset($ls->name_user->name) ? $ls->name_user->name." - ".$ls->name_user->role_name : "" ?></td>
                                                                                            <td><?= isset($ls->type) ? $ls->type : "" ?></td>
                                                                                            <td><?= isset($ls->created) ? $ls->created : "" ?></td>
                                                                                            <td><?= isset($ls->content['reason']) ? $ls->content['reason'] : "" ?></td>
                                                                                        </tr>
                                                                                        <?php $i++; ?>
                                                                                        <?php endforeach; ?>
                                                                                    @else
                                                                                    <tr>
                                                                                        <td colspan="4" style="text-align: center;">
                                                                                            NO DATA FOUND
                                                                                        </td>
                                                                                    </tr>
                                                                                    @endif
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
 
                                                    <!--end::Section-->
                                            </div>
                                            <!--end::Card-->
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
