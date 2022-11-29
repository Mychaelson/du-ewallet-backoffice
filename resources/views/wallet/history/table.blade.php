
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">ID</th>
                    <th class="align-middle text-center">Type</th>
                    <th class="align-middle text-center">Amount</th>
                    <th class="align-middle text-center">Balance</th>
                    <th class="text-center">Owner</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="align-middle text-center">
                        #{{ $val->id }}
                        <br>
                        @if ($val->type == 3)
                            <div class="label label-lg label-light-danger label-inline">Payroll</div>
                        @elseif ($val->type == 2)
                            <div class="label label-lg label-light-success label-inline">Merchant</div>
                        @else
                            <div class="label label-lg label-light-primary label-inline">E-Money</div>
                        @endif
                    </td>
                    <td class="text-center">  
                            {{ $val->transaction_type }}
                            <br>
                            @if ($val->status == 0)
                                <span class="text-danger">Deleted</span>
                            @elseif ($val->status == 1)
                                <span class="text-warning">Canceled</span>
                            @elseif ($val->status == 2)
                                <span class="text-primary">Pending</span>
                            @elseif ($val->status == 3)
                                <span class="text-success">Success</span>
                            @endif
                        </td>
                    <td class="text-right align-middle">IDR {{ number_format($val->amount, 2, ',', '.') }}</td>
                    <td class="text-right align-middle">IDR {{ number_format($val->balance, 2, ',', '.') }}</td>
                    <td class="text-center align-middle"><a href="/user/list/{{$val->user_id}}">{{ $val->name }}</a></td>
                    <td class="text-center align-middle">
                        {{ $val->created_at }}
                        <br>
                        <small class="text-muted">Updated: {{$val->updated_at}}</small>
                    </td>
                    <td class="text-center align-middle">
                        <a href="{{route('user.detail', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-information icon-md"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
