@extends('layouts.template.app')

@section('content_body')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-sm-8">
                    {{$page_title}}
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ route('store-product-category') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" value="{{ old('name') }}" id="name"
                                    onkeyup="createTextSlug()" required class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Slug</label>
                            <div class="col-sm-8">
                                <input type="text" name="slug" value="{{ old('slug') }}" readonly id="slug"
                                    required class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Non Active</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Select Parent</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="parent">
                                    <option value="0">Select Parent</option>
                                    @foreach ($data as $d)
                                    <option value="{{$d->id}}"><h5><<----- {{$d->name}} ------>></h5></option>
                                    @foreach ($d->child as $v)
                                    <option value="{{$v->id}}" class="ml-4"><strong>{{$v->name}}</option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Group</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="group">
                                    <option value="">Select Group</option>
                                    <option value="telkom">Telkom</option>
                                    <option value="pln">PLN</option>
                                    <option value="pdam">PDAM</option>
                                    <option value="multifinance">Multifinance</option>
                                    <option value="insurance">Insurance</option>
                                    <option value="gas">GAS</option>
                                    <option value="games">Games</option>
                                    <option value="emoney">Emoney</option>
                                    <option value="cell-postpaid">Cell postpaid</option>
                                    <option value="bpjs">BPJS</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-8">
                                <input type="file" name="image" required class="form-control"
                                    value="{{ old('version') }}" autofocus>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div>
                            <textarea name="description" id="editor" required class="form-control @error('content') is-invalid @enderror">

                        </textarea>
                        @if ($errors->has('content'))
                        <span class="text-danger">{{ $errors->first('content') }}</span>
                        @endif
                        </div>
                    </div>

                    <div class="float-right">
                        <a href="{{ route('product_category') }}" class="btn btn-outline-primary">
                            <li class="fa fa-arrow-left"></li> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <li class="fa fa-check"></li> Save
                        </button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('content_js')
    <script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('editor');

        function getData() {
            var editor_data = CKEDITOR.instances['editor'].getData();
        }

        function createTextSlug() {
            var name = document.getElementById("name").value;
            document.getElementById("slug").value = generateSlug(name);
        }

        function generateSlug(text) {
            return text.toString().toLowerCase()
                .replace(/^-+/, '')
                .replace(/-+$/, '')
                .replace(/\s+/g, '-')
                .replace(/\-\-+/g, '-')
                .replace(/[^\w\-]+/g, '');
        }

    </script>
    @endsection
