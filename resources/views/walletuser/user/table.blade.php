
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th  class="align-middle">Phone</th>
                    <th  class="align-middle">Name</th>
                    <th  class="align-middle text-center">Group</th>
                    <th  class="align-middle text-center">Category</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Join Date</th>
                    <th class="text-center">Last Login</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td>{{ $val->username }}</td>
                    <td class="text-center">{{ $val->nickname }}</td>
                    <td class="text-right">{{ $val->group_id }}</td>
                    <td class="text-center">Reguler</td>
                    <td class="text-center">{{ $val->status }}</td>
                    <td class="text-center">{{ $val->date_activated }}</td>
                    <td class="text-center">{{ $val->last_login }}</td>
                    <td class="text-center">
                        @if($val->verified == 1)
                        <span class="label label-success label-inline mr-2">Premium</span>
                        @else
                        <span class="label label-dark label-inline mr-2">Basic</span>
                        @endif

                    </td>
                    <td class="text-center">
                        <a href="{{route('user.detail', ['id' => $val->id])}}" class="btn btn-light-primary"><i class="flaticon2-information icon-md"></i></a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
