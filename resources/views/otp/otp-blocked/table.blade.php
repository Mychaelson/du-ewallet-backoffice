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
                    <th class="align-middle text-center">Module</th>
                    <th class="align-middle text-center">OTP</th>
                    <th class="align-middle text-center">Created</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        @if ($val->modulable_type == 'App\Entities\User')
                            <?php $set_data = DB::table('accounts.users')
                                ->select('phone')
                                ->where('id', $val->modulable_id)
                                ->first();
                            ?>
                        @elseif ($val->modulable_type == 'PhoneRegistration')
                            <?php
                            $set_data = DB::table('backoffice.phone_registration')
                                ->select('backoffice.phone_registration.phone')
                                ->where('id', $val->modulable_id)
                                ->first();
                            ?>
                        @endif
                        <td class="text-center">{{ $set_data->phone }}</td>
                        <td class="text-center">{{ $val->modulable_type }}</td>
                        <td class="text-center"><a href="/blacklist/edit/{{$val->id}}" class="btn btn-info btn-sm"><i class='fa fa-info-circle'></i></a></td>
                        <td class="text-center">{{ date('M, d Y', strtotime($val->created_at)) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
