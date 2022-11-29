
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">Title</th>
                    <th class="align-middle text-center">Locale</th>
                    <th class="align-middle text-center">User</th>
                    <th class="align-middle text-center">Created</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->title }}</td>
                    <td class="text-center">{{ $val->locale }}</td>
                    <td class="text-center">
                        <i class="flaticon2-user"></i> {{ $val->name }}
                    </td>
                    <td class="text-center">
                        {{ date('M, d Y', strtotime($val->created_at)) }}</td>
                    <td class="text-center">

                        <form action="{{ route('docs.destroy', [$val->id]) }}" method="POST">
                            @method('delete')
                            @csrf
                            <a href="{{ route('docs.edit', [$val->id]) }}"
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
