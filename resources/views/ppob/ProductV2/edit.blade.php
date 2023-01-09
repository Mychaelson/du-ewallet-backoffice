@extends('layouts.template.app')

@section('content_css')
@endsection
@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-8">
                        <h2><strong>Edit Product {{$data->code}}</strong></h2>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('edit-process-product', [$data->code]) }}" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        @csrf
                        <div class="row">
                            <div class="form-group row col-6">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name" value="{{ $data->name }}" id="name"
                                        onkeyup="createTextSlug()" required class="form-control" autofocus>
                                </div>
                            </div>

                            <div class="form-group row col-6">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Slug</label>
                                <div class="col-sm-8">
                                    <input type="text" name="slug" value="{{ $data->slug }}" readonly id="slug"
                                        required class="form-control" autofocus>
                                </div>
                            </div>

                            <div class="form-group row col-6">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <select class="form-control" required name="status">
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Non Active</option>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }} >Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-6">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Service and Price Buy</label>
                                <div class="col-sm-8">
                                    <select class="form-control" required name="service">
                                        @foreach ($service as $sc)
                                        <option value="{{$sc->service_id}}" {{ $data->service_id == $sc->service_id ? 'selected' : '' }}>{{$sc->name_service}} ( Rp. {{ number_format($sc->base_price, 2, ',', '.') }} )</option>
                                        @endforeach
                                         </select>
                                </div>
                            </div>

                            <div class="form-group row col-6">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <textarea name="description" id="description" required class="form-control"></textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>                                
                            </div>

                            <div class="form-group row col-6">
                                <label for="price_sell" class="col-sm-2 col-form-label">Price Sell</label>
                                <div class="col-sm-8">
                                    <input type="number" name="price_sell" value="{{ $data->price_sell }}" id="price_sell"
                                        onkeyup="createTextSlug()" required class="form-control" autofocus>
                                </div>
                            </div>

                        </div>


                        <div class="float-right">
                            <a href="{{ route('product') }}" class="btn btn-outline-primary">
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
