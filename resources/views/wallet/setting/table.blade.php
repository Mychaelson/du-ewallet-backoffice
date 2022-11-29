
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-left">Name</th>
                    <th class="align-left">Group</th>
                    <th class="align-left">Value</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-left">{{ $val->name }}</td>
                    <td class="text-left">{{ $val->group }}</td>
                    <td class="text-left">{{ $val->value }}</td>
                    <td class="text-center">
                        <a href="{{route('wallet.setting.edit', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-edit icon-md"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
