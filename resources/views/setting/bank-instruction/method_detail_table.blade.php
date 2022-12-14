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
                            <form action="{{ route('delete-method-detail', ['id'=>$val->id]) }}" method="POST">
                                @method('delete')
                                @csrf
                                <a href="javascript:void(0)" id="edit-data" data-url="{{ route('edit-bank-instruction-detail', ['id' => $val->id]) }}" class="btn btn-outline-warning btn-sm"><i class="flaticon2-edit"></i></a>
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="flaticon2-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
