
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-center">Bank From</th>
                    <th class="align-center">Bank To</th>
                    <th class="align-center">Fee</th>
                    <th class="align-center">Cost of Good Sold</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->bank_from_name }} - {{ $val->bank_from }}</td>
                    <td class="text-center">{{ $val->bank_to_name }} - {{ $val->bank_to }}</td>
                    <td class="text-right">{{ number_format($val->fee, 2, '.', ',') }}</td>
                    <td class="text-right">{{ number_format($val->cgs, 2, '.', ',') }}</td>
                    <td class="text-center">
                        <a href="{{route('wallet.switch.edit', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-edit icon-md"></i></a>
                        <a href="{{route('wallet.switch.edit', ['id' => $val->id])}}" class="btn btn-light-danger"><i class="flaticon-delete"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
