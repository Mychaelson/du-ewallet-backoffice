
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
                    <th class="align-middle text-center">Phone</th>
                    <th class="align-middle text-center">Content</th>
                    <th class="align-middle text-center">Status</th>
                    <th class="align-middle text-center">Type</th>
                    <th class="align-middle text-center">Time</th>
                    <th class="align-middle text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center align-middle"><a href="/user/list/{{$val->user_id}}">{{ $val->name }}</a></td>
                    <td class="text-center align-middle">{{ $val->phone }}</td>
                    <td class="text-center align-middle">{{ $val->content }}</td>
                    <td class="text-center align-middle">
                        @if ($val->status == 1)
                            <span class="text-secondary">Requested</span>
                        @elseif ($val->status == 2)
                            <span class="text-warning">Pending</span>
                        @elseif ($val->status == 3)
                            <span class="text-warning">On Prosess</span>
                        @elseif ($val->status == 4)
                            <span class="text-danger">Rejected</span>
                        @elseif ($val->status == 5)
                            <span class="text-success">Accepted</span>
                        @elseif ($val->status == 6)
                            <span class="text-success">done</span>
                        @endif
                    </td>
                    <td class="text-center align-middle">{{ $val->user_type }}</td>
                    <td class="text-center align-middle">{{ $val->created_at }}</td>
                    <td class="text-center">
                        <a href="{{route('user.closeaccount.form', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-information icon-md"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
