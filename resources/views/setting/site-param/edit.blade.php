@extends('layouts.template.app')

@section('content_css')
@endsection
@section('content_body')
    <div class="m-4">
        <div class="row">
            <div class="col-12">
                <div class="card w-50">
                    <div class="card-header">
                        <div class="col-sm-8">
                            Edit Params
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('edit-process-params',['id'=>$data->id])}}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" required name="name" class="form-control" value="{{$data->name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Group</label>
                                <select class="form-control" required id="another-group" name="group">
                                    <option selected disabled> Select Group</option>
                                    @foreach ($group as $value)
                                    <option value="{{$value->group}}"  {{ $value->group == $data->group ? ' selected' : '' }} >{{$value->group}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Value</label>
                                @if ($data->type == 1)
                                <input type="text" class="form-control"  name="value" value="{{$data->value}}">
                                @elseif ($data->type == 2)
                                <input type="date" class="form-control" name="value" value="{{$data->value}}">
                                @elseif ($data->type == 3)
                                <input type="number" class="form-control" name="value" value="{{$data->value}}">
                                @elseif ($data->type == 4)
                                <br><input type="checkbox" class="form-group" name="value" value="1" {{ $data->value == 1 ? 'checked' : null }}> True/Yes/Enabled
                                @elseif ($data->type == 5)
                                <textarea class="form-control"  name="value" rows="10">{{$data->value}}</textarea>
                                @elseif ($data->type == 6)
                                <input type="email" class="form-control" name="value" value="{{$data->value}}">
                                @elseif ($data->type == 7)
                                <input type="url" class="form-control" name="value" value="{{$data->value}}">
                                @elseif ($data->type == 8)
                                <input type="color" class="form-control" name="value" value="{{$data->value}}">
                                @endif
                            </div>
                            <a href="{{route('params')}}" class="btn btn-outline-danger btn-sm">Back</a>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                        </form>
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
