
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center align-middle">Date</th>
                    <th class="text-center align-middle">Bank</th>
                    <th class="text-center align-middle">Amount In</th>
                    <th class="text-center align-middle">Amount Out</th>
                    <th class="text-center align-middle">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->date }}</td>
                    <td class="text-center">
                        {{ $val->bank_account_number }}<br>
                        ({{ $val->bank_code}}) {{ $val->bank_name }}<br>
                        {{ $val->bank_account_name }}
                    </td>
                    <td class="text-right">{{ number_format($val->amount_in, 2, '.', ',') }}</td>
                    <td class="text-right">{{ number_format($val->amount_out, 2, '.', ',') }}</td>
                    <td class="text-right">{{ $val->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
