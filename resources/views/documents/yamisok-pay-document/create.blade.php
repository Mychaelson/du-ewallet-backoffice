@extends('layouts.template.app')

@section('content_css')
@endsection
@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-8">
                        Create Document
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('docs.store') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group row col-6">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" value="{{ old('title') }}" id="title"
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
                                <label for="staticEmail" class="col-sm-2 col-form-label">Locale</label>
                                <div class="col-sm-8">
                                    <select class="form-control" required name="locale">
                                        <option value="id-ID">id-ID</option>
                                        <option value="en-US">en-US</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-6">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Version</label>
                                <div class="col-sm-8">
                                    <input type="number" name="version" required class="form-control"
                                        value="{{ old('version') }}" autofocus>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div>
                                <textarea name="content" id="editor" required class="form-control @error('content') is-invalid @enderror">

                            </textarea>
                            @if ($errors->has('content'))
                            <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif
                            </div>
                        </div>

                        <div class="float-right">
                            <a href="{{ route('docs.index') }}" class="btn btn-outline-primary">
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
            var title = document.getElementById("title").value;
            document.getElementById("slug").value = generateSlug(title);
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
