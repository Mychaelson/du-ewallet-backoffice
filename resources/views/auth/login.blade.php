@extends('auth.app', ['title' => 'Login - EWALLET'])

@section('content')

<div class="col-md-4">
    <div class="card border-0 shadow rounded">
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <h4 class="font-weight-bold">LOGIN</h4>
            <hr>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold text-uppercase">Username</label>
                    <input type="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Username">
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>    
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    @error('password')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>    
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">LOGIN</button>
                <hr>
                <div role="button" aria-expanded="false">
                    <a href="#" data-toggle="tooltip" title="Contact IT Team" placement="top">Lupa Password ?</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection