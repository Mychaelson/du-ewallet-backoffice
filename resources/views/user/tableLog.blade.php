
<div id="table-area">
    <div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
            <thead class="thead-light">
                <th>User</th>
                <th>Type</th>
                <th>Action</th>
                <th>Reff</th>
                <th>Created</th>
            </thead>
            <tbody>
            @foreach($paginator as $value)
            <tr>
                <td> {{ $value->name }} </td>
                <td> {{ $value->type }} </td>
                <td> {{ $value->page }} </td>
                <td> {{ $value->ref }} </td>
                <td> {{ $value->created_at }} </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
