@extends('layouts.template.app')

@section('content_body')
    <div class="card">
        <h5 class="card-header"><button class="btn btn-success" id="btn-save">Save</button></h5>
        <div class="card-body">
            <form action="{{ route('store-master-role') }}" method="post" id="create-form">
                @csrf
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for=""><strong>Name Role</strong></label>
                                <input type="text" name="name" required class="form-control w-25" value="">
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
                        <th>Menu</th>
                        <th class="border border-gray-100 p-2">View</th>
                        <th class="border border-gray-100 p-2">Create</th>
                        <th class="border border-gray-100 p-2">Alter</th>
                        <th class="border border-gray-100 p-2">Drop</th>
                        @foreach ($data as $item)
                        <tbody>
                                <tr class="">
                                    <td class="border border-gray-100 p-2 font-semibold">
                                        <strong>{{ $item->mod_name }}</strong>
                                        <input id="select-{{$item->mod_alias}}" type="checkbox" value="">
                                    </td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox" name="view[]" value="{{ $item->modid }}"></td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox"  name="create[]" value="{{ $item->modid }}"></td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox" name="alter[]" value="{{ $item->modid }}"></td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox" name="drop[]" value="{{ $item->modid }}"></td>
                                </tr>
                                @foreach ($item->child as $c)
                                <tr class="">
                                    <td class="border border-gray-100 p-2 font-semibold">
                                       {{ $c->mod_name }}
                                    </td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox" name="view[]" value="{{ $c->modid }}"></td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox"  name="create[]" value="{{ $c->modid }}"></td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox" name="alter[]" value="{{ $c->modid }}"></td>
                                    <td class="border border-gray-100 p-2"><input id="checks-{{$item->mod_alias}}" type="checkbox" name="drop[]" value="{{ $c->modid }}"></td>
                                </tr>
                                @endforeach
                            </tbody>
                                @endforeach
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
