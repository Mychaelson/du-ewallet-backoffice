<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">User</th>
                    <th class="align-middle">Contact</th>
                    <th class="align-middle">Balance</th>
                    <th class="align-middle">Reversal fund(s)</th>
                    <th class="align-middle">Total Debt</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        <td class="">{{ $val->nickname }} - {{$val->group_name}}</td>
                        <td class="">
                       @if ($paginator !== null)
                       <span style='font-weight:bold;'>{{$val->name}}</span>
                       <a href=""><span style='font-weight:bold;color:#5bc0de'>{{$val->username}}</span></a>
                       @if ($val->verified == 0 && $val->name !=null)
                       <span class="label label-dark label-inline mr-2">Basic</span>
                       @elseif ($val->verified == 1 && $val->name !=null)
                       <span class="label label-primary label-inline mr-2">Premium</span>
                       @else
                       @endif
                       @endif

                    </td>
                        <td class="">{{$val->currency}}.{{number_format($val->balance, 0, ",", ".")}}</td>
                        <td class="">{{$val->currency}}.{{number_format($val->amount, 0, ",", ".")}}</td>
                        <td class="">{{$val->currency}}.{{number_format($val->reversal, 0, ",", ".")}}</td>
                        <td class="text-center">
                            <a href="{{url('wallet/emoney',[$val->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-info-circle"></i></a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
