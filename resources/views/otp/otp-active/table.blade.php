<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">Username</th>
                    <th class="align-middle text-center">Action</th>
                    <th class="align-middle text-center">Token</th>
                    <th class="align-middle text-center">Tires</th>
                    <th class="align-middle text-center">Expired</th>
                </tr>
            </thead>
            <tbody>
                <?php
                     $now = \Carbon\Carbon::now();
                ?>
                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        <td class="">{{ $val->username }}</td>
                        <td class="text-center">{{ $val->action }}</td>
                        @if ($val->expires_at < $now)
                        <td class="text-center"><span class="badge badge-danger">{{ $val->token }}</span></td>
                        @else
                        <td class="text-center"><span class="badge badge-success">{{ $val->token }}</span></td>
                        @endif
                        <td class="text-center">{{ $val->tries }}</td>
                        <td class="text-center">{{ date('M, d Y H:i:s', strtotime($val->expires_at)) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
