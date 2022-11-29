
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th  class="align-middle">Name</th>
                    <th  class="align-middle text-center">Created at</th>
                    <th  class="align-middle text-center">Updated at</th>
                    <th  class="align-middle text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td>{{ $val->name }}</td>
                    <td class="text-center">{{ $val->created_at }}</td>
                    <td class="text-center">{{ $val->updated_at }}</td>
                    <td class="text-center">
                        <a href="{{route('user-groups.edit', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-edit icon-md"></i></a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
