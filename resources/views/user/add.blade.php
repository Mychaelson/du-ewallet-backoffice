@extends('layouts.template.app')

@section('content_body')
    <div class="d-flex flex-column-fluid mt-7">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form" method="post" action="{{ route('users.save') }}" autocomplete="off">
                    {!! csrf_field() !!}
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-users-1 text-primary"></i>
                                </span>
                                <h3 class="card-label"> {{ $page_title }}</h3>
                            </div>
                            <div class="card-toolbar">
                                <button type="submit" class="btn btn-sm btn-warning font-weight-bold">
                                    <i class="flaticon2-hourglass-1"></i>Save
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-danger font-weight-bold ml-2"><i class="flaticon-close"></i> Cancel</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Username</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control " type="text" name="name" value="{{ old('name') }}">
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Fullname</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <input class="form-control " type="text" name="fullname" value="{{ old('fullname') }}">
                                        </div>
                                        @if($errors->has('fullname'))
                                            <div class="error">{{ $errors->first('fullname') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Status</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <select name="status" class="form-control selectpicker ">
                                                <option value="1">Unverified</option>
                                                <option value="2">Verified</option>
                                                <option value="3">Official</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-xxl-2 col-form-label required">Role</label>
                                        <div class="col-xxl-4 col-md-6">
                                            <select name="role" class="form-control selectpicker ">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->description }}</option>
                                                @endforeach
                                            </select>
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
@section('content_js')
@endsection
