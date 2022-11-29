
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">Phone</th>
                    <th class="align-middle text-center">Name</th>
                    <th class="align-middle text-center">Status</th>
                    <th class="align-middle text-center">Request Time</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->username }}</td>
                    <td class="text-center">{{ $val->name }}</td>
                    <td class="text-center">
                        <div>
                             @if($val->status == 0)
                            <span class="label label-default label-inline mr-2">Moderation</span>
                            @elseif($val->status == 1)
                            <span class="label label-warning label-inline mr-2">On Progress</span>
                            @elseif($val->status == 2)
                            <span class="label label-success label-inline mr-2">Approved</span>
                            @elseif($val->status == 3)
                            <span class="label label-danger label-inline mr-2">Rejected</span>
                            @elseif($val->status == 4)
                            <span class="label label-primary label-inline mr-2">Request</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-right">{{$val->updated_at}}</td>
                    <td class="text-center">
                        @if($val->status != 3)
                        <a href="{{route('user-kyc.detail', ['id' => $val->user_id])}}" class="btn btn-light-primary"><i class="flaticon2-information icon-md"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
