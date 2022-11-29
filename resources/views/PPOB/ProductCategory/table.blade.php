
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Status</th>
                    <th class="align-middle">Type</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            @php $no = $paginator->firstItem(); @endphp
            @foreach ($paginator as $val)
            <tbody>
                <tr class="daily-report pointer">
                    <td class=""><strong>{{ $val->name }}</strong></td>
                    @if ($val->status == 1)
                    <td class="text-center"><span class="p-1 rounded bg bg-success text-white">Active</span></td>
                    @elseif ($val->status == 0)
                    <td class="text-center"><span class="p-1 rounded bg bg-danger text-white">Non Active</span></td>
                    @endif

                    <td class="">Parent</td>
                    <td class="text-center">
                        <form action="{{ route('delete-master-role', ['id'=>$val->id]) }}" method="POST">
                            @method('delete')
                            @csrf
                            <a href="{{route('edit-master-role',['id'=>$val->id])}}" class="btn btn-outline-warning btn-sm"><i class="flaticon2-edit"></i></a>
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="flaticon2-trash"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
            @foreach ($val->child as $res)
            <tbody>
                <tr class="daily-report pointer">
                    <td class="">{{ $res->name }}</td>
                    @if ($res->status == 1)
                    <td class="text-center"><span class="p-1 rounded bg bg-success text-white">Active</span></td>
                    @elseif ($res->status == 0)
                    <td class="text-center"><span class="p-1 rounded bg bg-danger text-white">Non Active</span></td>
                    @endif

                    <td class="">Child</td>
                    <td class="text-center">
                        <form action="{{ route('delete-product-category', ['id'=>$res->id]) }}" method="POST">
                            @method('delete')
                            @csrf
                            <a href="{{route('edit-product-category',['id'=>$res->id])}}" class="btn btn-outline-warning btn-sm"><i class="flaticon2-edit"></i></a>
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="flaticon2-trash"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
            @endforeach
            @endforeach
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
