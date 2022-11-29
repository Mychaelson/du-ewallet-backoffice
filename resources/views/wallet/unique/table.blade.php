<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">#</th>
                    <th class="align-middle text-center">TU</th>
                    <th class="align-middle text-center">Created</th>
                    <th class="align-middle text-center">Reference No</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $key => $val)
                <tr class="daily-report pointer">
                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                    <td class="text-center align-middle">{{ $val->invoice_no }}</td>
                    <td class="text-center align-middle">{{ $val->created_at }}</td>
                    <td class="text-center align-middle">{{ $val->reference_no }}</td>
                    <td class="text-center align-middle">{{ $val->paid_description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
