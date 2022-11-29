<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Report Number</th>
                    <th scope="col" class="align-middle text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator as $d)
                    <tr>
                        <td>
                           <h4><strong style="color: rgb(0, 157, 255)">{{ $d->number }}</strong> - {{$d->subject}}</h4>{{ date('M, d Y', strtotime($d->created_at)) }}, created by {{$d->name}}
                        </td>
                        <td class="text-center">
                            <form action="{{ route('report.destroy', [$d->id]) }}" method="POST">
                                @method('delete')
                                @csrf
                                <a href="{{ route('report.edit', [$d->id]) }}"
                                    class="btn btn-sm btn-outline-warning"><i class="flaticon2-edit"></i></a>
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure?')"><i
                                        class="flaticon2-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
