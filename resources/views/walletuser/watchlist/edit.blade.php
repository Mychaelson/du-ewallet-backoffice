@extends('layouts.template.app')

@section('content_body')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form" method="post" action="{{ route('blacklist.update') }}" autocomplete="off">
                    @csrf
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-users-1 text-primary"></i>
                                </span>
                                <h3 class="card-label"> {{ $page_title }}
                            </div>
                            <div class="card-toolbar">
                                @if($page->mod_action_roles($mod_alias, 'alter'))
                                <button type="submit" class="btn btn-sm btn-warning font-weight-bold">
                                    <i class="flaticon2-hourglass-1"></i>Update
                                </button>
                                @endif
                                <a href="{{ route('user-blacklist') }}" class="btn btn-sm btn-danger font-weight-bold ml-2"><i class="flaticon-close"></i> Cancel</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if (session('msg_error'))
                                        <div class="alert alert-danger">
                                            {{ session('msg_error') }}
                                        </div>
                                    @endif
                                    @if (session('msg_success'))
                                        <div class="alert alert-success">
                                            {{ session('msg_success') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Name</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') ?: $data->name }}">
                                            <input type="hidden" name="id" readonly class="form-control" value="{{ request()->id }}">
                                            @error('name')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Alias</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('alias') is-invalid @enderror" type="text" name="alias" value="{{ old('alias') ?: $data->alias }}">
                                            @error('alias')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Country of Origin</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('country_of_origin') is-invalid @enderror" type="text" name="country_of_origin" value="{{ old('country_of_origin') ?: $data->country_of_origin }}">
                                            @error('country_of_origin')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Place of Birth</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('place_of_birth') is-invalid @enderror" type="text" name="place_of_birth" value="{{ old('place_of_birth') ?: $data->place_of_birth }}">
                                            @error('place_of_birth')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Job</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('job') is-invalid @enderror" type="text" name="job" value="{{ old('job') ?: $data->job }}">
                                            @error('job')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Date of Birth</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('date_of_birth') is-invalid @enderror" type="date" name="date_of_birth" value="{{ old('date_of_birth') ?: $data->date_of_birth }}">
                                            @error('date_of_birth')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Phone</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') ?: $data->phone }}">
                                            @error('phone')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Nationality</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" value="{{ old('nationality') ?: $data->nationality }}">
                                            @error('nationality')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Address</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address') ?: $data->address }}">
                                            @error('address')
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">{{ $message }}</div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
