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
                    <th class="align-middle text-center">OTP</th>
                    <th class="align-middle text-center">Created</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->phone }}</td>
                    <td class="text-center"><button class="btn btn-danger btn-sm"> {{ $val->email_hash }}</button></td>
                    <td class="text-center">{{ date('M, d Y', strtotime($val->created_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
