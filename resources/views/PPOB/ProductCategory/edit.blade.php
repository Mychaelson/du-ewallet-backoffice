@extends('layouts.template.app')

@section('content_body')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-sm-8">
                    Edit Document
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ route('update-product-category', [$data->id]) }}" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="row">
                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" value="{{$data->name}}" id="name"
                                    onkeyup="createTextSlug()" required class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Slug</label>
                            <div class="col-sm-8">
                                <input type="text" name="slug" value="{{$data->slug }}" readonly id="slug"
                                    required class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="status">
                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Non Active</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Select Parent</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="parent">
                                    <option value="0">Select Parent</option>
                                    @foreach ($parent as $d)
                                    <option value="{{$d->id}}" {{ $data->parent_id == $d->id ? 'selected' : '' }}><h5><<----- {{$d->name}} ------>></h5></option>
                                    @foreach ($d->child as $v)
                                    <option value="{{$v->id}}" {{ $data->parent_id == $v->id ? 'selected' : '' }}><strong>{{$v->name}}</option>
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
                                    <option value="telkom" {{ $data->group == 'telkom' ? 'selected' : '' }}>Telkom</option>
                                    <option value="pln" {{ $data->group == 'pln' ? 'selected' : '' }}>PLN</option>
                                    <option value="pdam" {{ $data->group == 'pdam' ? 'selected' : '' }}>PDAM</option>
                                    <option value="multifinance" {{ $data->group == 'multifinance' ? 'selected' : '' }}>Multifinance</option>
                                    <option value="insurance" {{ $data->group == 'insurance' ? 'selected' : '' }}>Insurance</option>
                                    <option value="gas" {{ $data->group == 'gas' ? 'selected' : '' }}>GAS</option>
                                    <option value="games" {{ $data->group == 'games' ? 'selected' : '' }}>Games</option>
                                    <option value="emoney" {{ $data->group == 'emoney' ? 'selected' : '' }}>Emoney</option>
                                    <option value="cell-postpaid" {{ $data->group == 'cell-postpaid' ? 'selected' : '' }}>Cell postpaid</option>
                                    <option value="bpjs" {{ $data->group == 'bpjs' ? 'selected' : '' }}>BPJS</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row col-6">
                            <input type="hidden" name="image_old" value="{{$data->image}}">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-8">
                                <input type="file" name="image" class="form-control"
                                    value="{{ $data->image }}">
                                    <img src="{{$data->image}}" width="100px" height="100px">
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div>
                            <textarea name="description" id="editor" required class="form-control @error('content') is-invalid @enderror">
                                {!! str_replace(
                                    '<p style="text-align: justify;">',
                                    '<p>',
                                    str_replace(
                                        '<img ',
                                        '<img class="of-cover w-100 h-100" ',
                                        str_replace('../../', env('URL_MEDIA') . '/', $data->description),
                                    ),
                                ) !!}
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
