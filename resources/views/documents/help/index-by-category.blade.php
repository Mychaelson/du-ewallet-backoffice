@extends('layouts.template.app')

@section('content_body')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-line-graph text-primary"></i>
                        </span>
                        <h3 class="card-label"> {{ $category->name }}
                    </div>
                    <div class="float-right mt-4">
                        <a href="{{ route('create-by-category',['id'=>$category->id]) }}" class="btn btn-outline-primary">
                            <li class="fa fa-plus"></li> Create</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('index-by-category', ['id'=>$category->id]) }}" method="GET">
                                <div class="mb-5">
                                    <div class="row align-items-center align-items-sm-start">
                                    <div class="col-md-8 col-xxl-3 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                        <div class="d-xxl-flex">
                                            <a href="{{ route('index-category') }}" class="btn btn-outline-primary">
                                                <i class="fa fa-arrow-left"></i> Back</a>
                                            </div>
                                    </div>
                                    <div class="col-md-8 col-xxl-9 col-lg-12 my-2 my-md-0 mb-0 mb-md-3">
                                        <div class="row float-right">
                                            <div class="col-10">
                                                <div class="input-icon flex-grow-1 mr-0 mr-xxl-6 mb-4 mb-lg-2 mb-xl-2 mb-xxl-0">
                                                <input type="text" name="search" class="form-control search-text"
                                                        placeholder="Search" value="{{Request::get('search')}}" />
                                                        <span>
                                                            <i class="flaticon2-search-1 text-muted"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-6 m--margin-bottom-10">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="align-middle text-center">Title</th>
                                            <th class="align-middle text-center">Group</th>
                                            <th class="align-middle text-center">Created</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $val)
                                            <tr class="daily-report pointer">
                                                <td class="text-center">{{ $val->title }}</td>
                                                <td class="text-center">{{ $val->group }}</td>
                                                <td class="text-center">
                                                    {{ date('M, d Y', strtotime($val->created_at)) }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('resource-help.destroy',[$val->id]) }}" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <a href="{{ route('resource-help.edit', [$val->id]) }}" class="btn btn-outline-info btn-sm"><i class="flaticon2-edit"></i></a>
                                                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="flaticon2-trash"></i></button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $data->withQueryString()->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@if (session('message'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 3000
        })
    </script>
@endif

@if (session('delete'))
<script>
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: '{{ session('delete') }}',
        showConfirmButton: false,
        timer: 3000
    })
</script>
@endif
@endsection
