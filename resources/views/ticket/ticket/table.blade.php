<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">Subject</th>
                    <th class="align-middle text-center">Scope</th>
                    <th class="align-middle text-center">Priority</th>
                    <th class="align-middle text-center">Status</th>
                    <th class="text-center">Submit By</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Last Update</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        <td>{{ $val->subject }}</td>
                        <td class="text-center">
                            @switch($val->scope)
                                @case(1)
                                    Finance
                                @break

                                @case(2)
                                    Legal
                                @break

                                @case(3)
                                    Business
                                @break

                                @case(4)
                                    IT
                                @break

                                @default
                                    Unknown
                            @endswitch
                        </td>
                        <td class="text-center">
                            @switch($val->priority)
                                @case(1)
                                    <span class="label label-success label-inline mr-2">Low</span>
                                @break

                                @case(2)
                                    <span class="label label-warning label-inline mr-2">Medium</span>
                                @break

                                @case(3)
                                    <span class="label label-danger label-inline mr-2">High</span>
                                @break

                                @default
                                    <span class="label label-dark label-inline mr-2">Unknown</span>
                            @endswitch
                        </td>
                        <td class="text-center">
                            @switch($val->status)
                                @case(1)
                                    <span class="label label-danger label-inline mr-2">Rejected</span>
                                @break

                                @case(2)
                                    <span class="label label-success label-inline mr-2">Active</span>
                                @break

                                @case(3)
                                    <span class="label label-warning label-inline mr-2">On Progress</span>
                                @break

                                @case(4)
                                    <span class="label label-info label-inline mr-2">Closed</span>
                                @break

                                @default
                                    <span class="label label-dark label-inline mr-2">Unknown</span>
                            @endswitch
                        </td>
                        <td class="text-center">{{ $val->user_username }}</td>
                        <td class="text-center">{{ $val->created_at }}</td>
                        <td class="text-center">{{ $val->updated_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('ticket.detail', ['id' => $val->id]) }}" class="btn btn-light-primary"><i class="flaticon2-information icon-md"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
