@extends('layouts.template.app')

@section('content_css')
@endsection
@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-8">
                        <h2>Edit Help Contents : {{$category->name}}</h2>
                    </div>
                </div>


                <div class="row m-2">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Category Name</strong><br>{{$category->name}}</p>
                                <p><strong>Locale</strong><br>{{$category->locale}}</p>
                                <p><strong>Created</strong><br>{{ date('M, d Y', strtotime($category->created_at)) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('resource-help.update',[$data->id]) }}" enctype="multipart/form-data" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    @csrf
                                    <input type="hidden" name="category" value="{{ $category->id }}" required>
                                    <input type="hidden" name="locale" value="{{$category->locale }}" required>
                                    <input type="hidden" name="group" value="{{ $category->group }}" required>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="staticEmail" class="form-label">Title</label>
                                            <input type="text" name="title" value="{{ $data->title }}" required
                                                class="form-control" autofocus>
                                        </div>

                                        <div class="form-group col">
                                            <label for="staticEmail" class="form-label">Keywords</label>
                                            <input type="text" name="keywords" value="{{ $keywords }}" class="form-control">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <textarea name="content" id="editor" required class="form-control">
                                                {!! str_replace(
                                                    '<p style="text-align: justify;">',
                                                    '<p>',
                                                    str_replace(
                                                        '<img ',
                                                        '<img class="of-cover w-100 h-100" ',
                                                        str_replace('../../', env('URL_MEDIA') . '/', $data->content),
                                                    ),
                                                ) !!}
                                    </textarea>
                                        </div>
                                    </div>

                                    <div class="float-right">
                                        <a href="{{ route('index-by-category',['id'=>$category->id]) }}" class="btn btn-outline-primary">
                                            <li class="fa fa-arrow-left"></li> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <li class="fa fa-check"></li> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



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
