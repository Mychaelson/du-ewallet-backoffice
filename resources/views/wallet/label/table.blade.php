
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-left">Default Name</th>
                    <th class="align-left">Spending</th>
                    <th class="align-left">Created</th>
                    <th class="align-left">Color</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-left">{{ $val->name }}</td>
                    <td class="text-left">{{ $val->spending === 0 ? 'Income' : 'Expend' }}</td>
                    <td class="text-left">{{ $val->created_at }}</td>
                    <td class="text-left">
                    <span class="label label-lg label-inline" style="background-color:{{ $val->color }};color:{{ $val->color === '#ffffff' ? 'blue' : 'white' }};outline-color:blue;outline-style: solid;">{{ $val->color }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{route('wallet.label.edit', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-edit icon-md"></i></a>
                        <a href="{{route('wallet.label.edit', ['id' => $val->id])}}" class="btn btn-light-danger"><i class="flaticon-delete"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
