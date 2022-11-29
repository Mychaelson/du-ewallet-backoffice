
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center align-middle">#</th>
                    <th class="text-center align-middle">User</th>
                    <th class="text-center align-middle">Reff</th>
                    <th class="text-center align-middle">type</th>
                    <th class="text-center align-middle">Amount</th>
                    <th class="text-center align-middle">Updated</th>
                    <th class="text-center align-middle">Created</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $key=>$val)
                <tr class="daily-report pointer">
                    <td class="text-center align-middle">hello</td>
                    <td class="text-center align-middle">hello</td>
                    <td class="text-center align-middle">hello</td>
                    <td class="text-center align-middle">hello</td>
                    <td class="text-center align-middle">hello</td>
                    <td class="text-center align-middle">hello</td>
                    <td class="text-center align-middle">hello</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
