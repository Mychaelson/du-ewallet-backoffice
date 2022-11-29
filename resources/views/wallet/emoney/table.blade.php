
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">User</th>
                    <th class="align-middle text-center">Contact</th>
                    <th class="align-middle text-center">Lock</th>
                    <th class="align-middle text-center">Balance</th>
                    <th class="text-center">Transaction (Month)</th>
                    <th class="text-center">Reversal Fund</th>
                    <th class="text-center">Registered</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->nickname }}</td>
                    <td class="text-center">{{ $val->phone }}</td>
                    <td class="text-center">
                        <div>
                            <i class="{{ $val->lock_in === 0 ? 'flaticon2-checkmark' : 'flaticon2-lock' }}" title="Transfer In Lock"></i>
                            <i class="{{ $val->lock_out === 0 ? 'flaticon2-checkmark' : 'flaticon2-lock' }}" title="Transfer Out Lock"></i>
                            <i class="{{ $val->lock_wd === 0 ? 'flaticon2-checkmark' : 'flaticon2-lock' }}" title="Withdraw Lock"></i>
                            <i class="{{ $val->lock_tf === 0 ? 'flaticon2-checkmark' : 'flaticon2-lock' }}" title="Transfer Lock"></i>
                            <i class="{{ $val->lock_pm === 0 ? 'flaticon2-checkmark' : 'flaticon2-lock' }}" title="Payment Lock"></i>
                        </div>
                        <span class="label label-lg label-light-primary label-inline">E-Money</span>
                    </td>
                    <td class="text-right">IDR {{ number_format($val->balance, 2, ',', '.') }}</td>
                    <td class="text-right">
                        In: IDR {{ number_format($val->in, 2, ',', '.') }}</br>
                        Out: IDR {{ number_format($val->out, 2, ',', '.') }}
                    </td>
                    <td class="text-rigth">IDR {{ number_format($val->reversal, 2, ',', '.') }}</td>
                    <td class="text-center">{{ date('d F Y', strtotime($val->created_at)) }}</td>
                    <td class="text-center">
                        <a href="{{route('wallet.emoney.detail', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-information icon-md"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
