
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">Name</th>
                    <th class="align-middle text-center">Group</th>
                    <th class="align-middle text-center">Value</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{$val->name}}</td>
                    <td class="text-center">{{$val->group }}</td>
                    <td class="text-center">
                        @if ($val->value == 1 && $val->type == 4)
                        <span class="btn btn-primary btn-sm">true</span>
                        @elseif($val->value !== 1 && $val->type == 4)
                        <span class="btn btn-danger btn-sm">false</span>
                        @else
                        {{$val->value}}
                        @endif
                    </td>
                    <td class="text-center">
                        <form action="{{ route('delete-params', ['id'=>$val->id]) }}" method="POST">
                            @method('delete')
                            @csrf
                            <a href="{{ route('edit-params', ['id' => $val->id]) }}" class="btn btn-outline-warning btn-sm"><i class="flaticon2-edit"></i></a>
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="flaticon2-trash"></i></button>
                        </form>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
