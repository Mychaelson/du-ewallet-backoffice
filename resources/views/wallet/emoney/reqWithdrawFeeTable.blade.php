
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">Bank</th>
                    <th class="align-middle text-center">Fee</th>
                    <th class="align-middle text-center">Status</th>
                    <th class="align-middle text-center">Created</th>
                    <th class="align-middle text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                @php
                    $info = json_decode($val->changes)
                @endphp
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $info->bank_id }}</td>
                    <td class="text-center">Rp. {{ $info->fee }}</td>
                    <td class="text-center">{{ $val->status }}</td>
                    <td class="text-center">{{ date('d F Y', strtotime($val->created_at)) }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary" id="buttonActionRequest" data-toggle="modal" data-target="#requestModal" onclick="actionApprove('{{$val->id}}')"><i class="flaticon2-information icon-md"></i></button>
                        <!-- <a href="{{route('wallet.emoney.detail', ['id' => $val->id])}}" class="btn btn-light-danger"><i class="flaticon2-trash icon-md"></i></a> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
