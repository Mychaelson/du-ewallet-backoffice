<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">Steps</th>
                    <th class="align-middle">Steps Value</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                    <tr class="daily-report pointer">
                        <td class="">{{$val->steps}}</td>
                        <td class="">{{$val->step_value}}</td>
                        <td class="text-center">
                            <!-- <a href="{{url('setting/bank-instruction/method-detail',[$val->title])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-info-circle"></i></a> -->
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
