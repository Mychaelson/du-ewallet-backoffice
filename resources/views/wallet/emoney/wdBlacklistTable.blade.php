
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">Operator</th>
                    <th class="align-middle text-center">Description</th>
                    <th class="align-middle text-center">Status</th>
                    <th class="align-middle text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->name }}</td>
                    <td>
                        Wallet: {{$val->wallet_id}}
                        <br>
                        Docs: {{$val->document ?? '-' }}
                    </td>
                    <td class="text-center">{{$val->status}}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary" id="buttonActionRequest" data-toggle="modal" data-target="#requestModal" onclick="actionApprove('{{$val->id}}')"><i class="flaticon2-information icon-md"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>


