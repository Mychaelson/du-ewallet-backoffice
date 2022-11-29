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
        @include('user.profileSidebar', ['active' => 'profile'])
      </div>
      <div class="col-xl-10 col-md-8">
        <form class="form" method="post" action="{{ route('users.update', ['id' => $user->id]) }}" autocomplete="off"> {!! csrf_field() !!} <div class="card card-custom gutter-b">
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
                    <label class="col-xxl-2 col-form-label required">Username</label>
                    <div class="col-xxl-4 col-md-6">
                      <input class="form-control " type="text" name="name" value="{{ $user->name }}">
                    </div> @if($errors->has('name')) <div class="error">{{ $errors->first('name') }}</div> @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group row">
                    <label class="col-xxl-2 col-form-label required">Fullname</label>
                    <div class="col-xxl-4 col-md-6">
                      <input class="form-control " type="text" name="fullname" value="{{ $user->fullname }}">
                    </div> @if($errors->has('fullname')) <div class="error">{{ $errors->first('fullname') }}</div> @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group row">
                    <label class="col-xxl-2 col-form-label required">Nickname</label>
                    <div class="col-xxl-4 col-md-6">
                      <input class="form-control " type="text" name="nickname" value="{{ $user->nickname }}">
                    </div> @if($errors->has('nickname')) <div class="error">{{ $errors->first('nickname') }}</div> @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group row">
                    <label class="col-xxl-2 col-form-label required">Status</label>
                    <div class="col-xxl-4 col-md-6">
                      <select name="status" class="form-control selectpicker ">
                        <option {{ $user->status == 1 ? 'selected' : '' }} value="1">Unverified</option>
                        <option {{ $user->status == 2 ? 'selected' : '' }} value="2">Verified</option>
                        <option {{ $user->status == 3 ? 'selected' : '' }} value="3">Official</option>
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
                      <select name="role" class="form-control selectpicker "> @foreach($roles as $role) <option {{ $role->id == $user->role ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->description }}</option> @endforeach </select>
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
</div> @endsection @section('content_js') @endsection