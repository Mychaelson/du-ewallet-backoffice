
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <thead class="thead-light">
                    <tr>
                        <th class="align-middle text-center">Name</th>
                        <th class="align-middle text-center">Locale</th>
                        <th class="align-middle text-center">Created</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($paginator as $val)
                        <tr class="daily-report pointer">
                            <td class="text-center">{{ $val->name }}</td>
                            <td class="text-center">{{ $val->locale }}</td>
                            <td class="text-center">
                                {{ date('M, d Y', strtotime($val->created_at)) }}</td>
                            <td class="text-center">
                                    <a href="{{ route('index-by-category', [$val->id]) }}"
                                        class="btn btn-outline-warning btn-sm"><i class="flaticon-eye"></i></a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
