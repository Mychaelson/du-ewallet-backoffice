<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">Bank name</th>
                    <th class="align-middle">Bank Code</th>
                    <th class="align-middle">Transaction</th>
                    <th class="align-middle">Method</th>
                    <th class="align-middle">Title</th>
                    <th class="align-middle">lang</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        <td class="">{{ $val->bank_name }}</td>
                        <td class="">{{$val->bank_code}}</td>
                        <td class="">{{$val->transaction}}</td>
                        <td class="">{{$val->method}}</td>
                        <td class="">{{$val->title}}</td>
                        <td class="">{{$val->lang}}</td>
                        <td class="text-center">
                            <a href="{{url('setting/bank-instruction/detail',[$val->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-info-circle"></i></a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
