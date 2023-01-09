
<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center">Code</th>
                    <th class="align-middle text-center">Name</th>
                    <th class="align-middle text-center">Provider</th>
                    <th class="align-middle text-center">Price Buy</th>
                    <th class="align-middle text-center">Price Sell</th>
                    <th class="align-middle text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $paginator->firstItem(); @endphp
                @foreach ($paginator as $val)
                <tr class="daily-report pointer">
                    <td class="text-center">{{ $val->code }}</td>
                    <td class="text-center">{{ $val->name }}</td>
                    <td class="text-center">{{ $val->provider }}</td>
                    <td class="text-center">{{ number_format($val->price_buy, 2, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($val->price_sell, 2, ',', '.') }}</td>
                    @if ($val->status == 1)
                    <td class="text-center"><span class="p-1 rounded bg bg-success text-white">Active</span></td>
                    @elseif ($val->status == 0)
                    <td class="text-center"><span class="p-1 rounded bg bg-danger text-white">Non Active</span></td>
                    @endif
                    <td>
                        <a href="{{ route('edit-product', [$val->code]) }}"
                            class="btn btn-sm btn-outline-warning"><i class="flaticon2-edit"></i></a>
                            <button id="see-data" data-id="{{$val->code}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></button>

                        {{-- <form action="{{ route('docs.destroy', [$val->id]) }}" method="POST">
                            @method('delete')
                            @csrf

                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Are you sure?')"><i
                                    class="flaticon2-trash"></i></button>
                        </form> --}}
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
