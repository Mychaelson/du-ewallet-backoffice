
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">#</th>
                    <th class="align-middle text-center">Date</th>
                    <th class="align-middle text-center">Quantity</th>
                    <th class="align-middle text-center">Amount</th>
                    <th class="align-middle text-center"><i class="flaticon-delete-1" style="color: red;"></i></th>
                    <th class="align-middle text-center"><i class="flaticon2-delete" style="color: orange;"></i></th>
                    <th class="align-middle text-center"><i class="flaticon2-time" style="color: blue;"></i></th>
                    <th class="align-middle text-center"><i class="flaticon2-correct" style="color: green;"></i></th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $key=>$val)
                <tr class="daily-report pointer">
                    <td class="align-middle text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $val->date }}</td>
                    <td class="text-center align-middle">{{ $val->quantity }}</td>
                    <td class="text-right align-middle">IDR {{ number_format($val->amount, 2, ',', '.') }}</td>
                    <td class="text-center align-middle">{{ $val->qty_erased }}</td>
                    <td class="text-center align-middle">{{ $val->qty_cancel }}</td>
                    <td class="text-center align-middle">{{ $val->qty_pending }}</td>
                    <td class="text-center align-middle">{{ $val->qty_success }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
