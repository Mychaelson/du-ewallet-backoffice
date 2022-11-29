
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">Name Roles</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->name }}</td>
                    <td class="text-center">

                        <form action="{{ route('delete-master-role', ['id'=>$val->id]) }}" method="POST">
                            @method('delete')
                            @csrf
                            <a href="{{route('edit-master-role',['id'=>$val->id])}}" class="btn btn-outline-warning btn-sm"><i class="flaticon2-edit"></i></a>
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
