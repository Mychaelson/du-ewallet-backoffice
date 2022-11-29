@extends('layouts.template.app')

@section('content_css')
@endsection
@section('content_body')
    <div class="container">
        <h2>OTP Pin Documents</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Phone</th>
                    <th scope="col">OTP</th>
                    <th scope="col">Created</th>
                </tr>
            </thead>
            <?php $no=1; ?>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <th scope="row">{{$no++ }}</th>
                        <td>{{ $d->phone }}</td>
                        <td><button class="btn btn-danger btn-sm"> {{ $d->otp }}</button></td>
                        <td>{{ date('M, d Y H:i:s', strtotime($d->created_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
