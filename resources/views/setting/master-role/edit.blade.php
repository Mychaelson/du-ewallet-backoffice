@extends('layouts.template.app')

@section('content_body')
    <div class="card">
        <h5 class="card-header">
        Edit Roles
        </h5>
        <div class="card-body">
            <form action="{{ route('update-master-role',['id'=>$edit_data->id]) }}" method="post" id="create-form">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for=""><strong>Name Role</strong></label>
                                <input type="text" name="name" class="form-control w-25" value="{{ $edit_data->name }}">
                            </div>
                        </div>
                        <div class="float-right">

                            <div class="col">
                                <div class="form-group">
                                    <label for=""><strong></strong></label>
                                    <a href="{{route('master-role')}}" class="btn btn-primary">Back</a>
                                    <button class="btn btn-success" id="btn-save">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover w-full">
                        <th></th>
                        <th class="border border-gray-100 p-2">View</th>
                        <th class="border border-gray-100 p-2">Create</th>
                        <th class="border border-gray-100 p-2">Alter</th>
                        <th class="border border-gray-100 p-2">Drop</th>
                        <tbody>
                            <?php $view_data = array_map('intval', explode(',', json_decode($edit_data->role)->view)) ?>
                            <?php $create_data = array_map('intval', explode(',', json_decode($edit_data->role)->create)) ?>
                            <?php $alter_data = array_map('intval', explode(',', json_decode($edit_data->role)->alter)) ?>
                            <?php $drop_data = array_map('intval', explode(',', json_decode($edit_data->role)->drop)) ?>

                            @foreach ($data as $item)
                            <tbody>
                                    <tr class="">
                                        <td class="border border-gray-100 p-2 font-semibold">
                                            <strong>{{ $item->mod_name }}</strong>
                                            <input id="select-{{$item->mod_alias}}" type="checkbox" value="">
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="view[]"  @foreach ($view_data as $key=>$value)
                                            {{ $item->modid == $value ? 'checked' : null }} value="{{ $item->modid }}" @endforeach>
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="create[]"  @foreach ($create_data as $key=>$value)
                                            {{ $item->modid == $value ? 'checked' : null }} value="{{ $item->modid }}" @endforeach>
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="alter[]"  @foreach ($alter_data as $key=>$value)
                                            {{ $item->modid == $value ? 'checked' : null }} value="{{ $item->modid }}" @endforeach>
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="drop[]"  @foreach ($drop_data as $key=>$value)
                                            {{ $item->modid == $value ? 'checked' : null }} value="{{ $item->modid }}" @endforeach>
                                        </td>

                                      </tr>

                                    @foreach ($item->child as $c)
                                    <tr class="">
                                        <td class="border border-gray-100 p-2 font-semibold">
                                           {{ $c->mod_name }}
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="view[]"  @foreach ($view_data as $key=>$value)
                                        {{ $c->modid == $value ? 'checked' : null }} value="{{ $c->modid }}" @endforeach>
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="create[]"  @foreach ($create_data as $key=>$value)
                                        {{ $c->modid == $value ? 'checked' : null }}   value="{{ $c->modid }}" @endforeach>
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="alter[]"  @foreach ($alter_data as $key=>$value)
                                        {{ $c->modid == $value ? 'checked' : null }}   value="{{ $c->modid }}" @endforeach>
                                        </td>

                                        <td class="border border-gray-100 p-2">
                                            <input id="checks-{{$item->mod_alias}}" type="checkbox" name="drop[]"  @foreach ($drop_data as $key=>$value)
                                        {{ $c->modid == $value ? 'checked' : null }}   value="{{ $c->modid }}" @endforeach>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                    @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('content_js')
    <script>
        $('#btn-save').on('click', function() {
            $('#create-form').submit()
        });
    </script>

<script>
    @foreach ($data as $item)
      $('#select-{{$item->mod_alias}}').click(function(event) {
          $(this.form.elements).filter('#checks-{{$item->mod_alias}}').prop('checked', this.checked);
      });
   @endforeach
   </script>
@endsection
