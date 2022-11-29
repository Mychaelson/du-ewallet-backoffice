@extends('layouts.template.app') @section('content_body') <div class="d-flex flex-column-fluid">
  <!--begin::Container-->
  <div class="container-fluid mt-7">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
      <div class="col-xl-2 col-md-4">
        @include('user.profileSidebar', ['active' => 'password'])
      </div>
      <div class="col-xl-10 col-md-8">
        <form class="form" method="post" action="{{ route('users.updatePassword', ['id' => $user->id]) }}" autocomplete="off"> {!! csrf_field() !!} <div class="card card-custom gutter-b">
            <div class="card-header">
              <div class="card-title">
                <span class="card-icon">
                  <i class="flaticon-users-1 text-primary"></i>
                </span>
                <h3 class="card-label"> {{ $page_title }}</h3>
              </div>
              <div class="card-toolbar">
                <button type="submit" class="btn btn-sm btn-warning font-weight-bold">
                  <i class="flaticon2-hourglass-1"></i>Update </button>
                <a href="{{ route('users') }}" class="btn btn-sm btn-danger font-weight-bold ml-2">
                  <i class="flaticon-close"></i> Back </a>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group row">
                    <label class="col-xxl-2 col-form-label required">New Password</label>
                    <div class="col-xxl-4 col-md-6">
                      <input class="form-control " type="password" name="password" value="{{ old('name') }}">
                    </div> @if($errors->has('password')) <div class="error">{{ $errors->first('password') }}</div> @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group row">
                    <label class="col-xxl-2 col-form-label required">Confirm Password</label>
                    <div class="col-xxl-4 col-md-6">
                      <input class="form-control " type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    </div> @if($errors->has('password_confirmation')) <div class="error">{{ $errors->first('password_confirmation') }}</div> @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> @endsection @section('content_js') @endsection