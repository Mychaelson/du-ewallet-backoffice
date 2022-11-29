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
                <?php
                     $now = \Carbon\Carbon::now();
                ?>
                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        <td class="">
                            {{ $val->approval }}
                            @if ($val->status == 1)
                            <a href="/user/closeaccounts/{{$val->user_id}}" class="text-info">requested</a>
                            @elseif ($val->status == 2)
                            <a href="/user/closeaccounts/{{$val->user_id}}" class="text-warning">peding</a>
                            @elseif ($val->status == 3)
                            <a href="/user/closeaccounts/{{$val->user_id}}" class="text-primary">on progress</a>
                            @elseif ($val->status == 4)
                            <a href="/user/closeaccounts/{{$val->user_id}}" class="text-danger">rejected</a>
                            @elseif($val->status == 5)
                            <a href="/user/closeaccounts/{{$val->user_id}}" class="text-success">done</a>
                            @endif
                            <a class='text-primary' href='".site_url("users/".$kyc->user_id)."'>{{$val->name}}</a>
                            Close Account request
                        </td>
                        <td class="">{{ date('M, d Y H:i:s', strtotime($val->approved_at)) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
