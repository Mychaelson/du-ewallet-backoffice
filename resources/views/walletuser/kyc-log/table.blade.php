<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">Action</th>
                    <th class="align-middle">Action Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        <td class="">
                            @if ($val->name == null)
                            Administrator
                            @else
                            {{ $val->name }}
                            @endif
                            @if ($val->type == 'accept_kyc')
                            <a href="/user/kyc/{{$val->target}}" class="text-success">Approved</a>
                            @elseif ($val->type == 'reject_kyc')
                            <a href="/user/kyc/{{$val->target}}" class="text-danger">Rejected</a>
                            @elseif ($val->type == 'unkyc')
                            <a href="/user/kyc/{{$val->target}}" class="text-primary">Unkyc</a>
                            @elseif ($val->type == 'requestEdit_kyc')
                            <a href="/user/kyc/{{$val->target}}" class="text-warning">Request Approve</a>
                            @endif
                            <a class='text-primary' href="/user/list/{{$val->user}}">
                                @if ($val->target_name == null)
                                User
                                @else
                                {{$val->target_name}}
                                @endif
                            </a>
                            of KYC request
                        </td>
                        <td class="">{{ date('M, d Y H:i:s', strtotime($val->created)) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
