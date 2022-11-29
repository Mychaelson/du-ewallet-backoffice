
<div class="d-flex justify-content-between align-items-center flex-wrap" id="{{ isset($id) ? $id : 'pagination' }}">
    <div class="d-flex flex-wrap py-2 mr-3">
        @if ($paginator->hasPages())
            @if (!$paginator->onFirstPage())
                <a href="#" data-page="{{ $paginator->currentPage() - 1 }}" class="btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-arrow-back icon-xs"></i></a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                    <a href="#" data-page="{{ $page }}" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1 {{ $page == $paginator->currentPage() ? 'btn-hover-primary active' : '' }}">{{ $page }}</a>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="#" data-page="{{ $paginator->currentPage() + 1 }}" class="btn btn-icon btn-sm btn-light mr-2 my-1"><i class="ki ki-bold-arrow-next icon-xs"></i></a>
            @endif
        @endif
    </div>
    <div class="d-flex align-items-center py-3">
        @php $per_page_arr = [5,10,20,30,50,100] @endphp
        <select id="pagination-perpage" class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light selectpicker-pagination" data-container="body" data-width="60px">
            @foreach ($per_page_arr as $item)
                <option value="{{ $item }}" {{ $paginator->perPage()==$item ? 'selected' : '10' }}>{{ $item }}</option>
            @endforeach
        </select>
        <span class="text-muted">Showing {{ is_number($paginator->firstItem()) }} - {{ is_number($paginator->lastItem()) }} of {{ is_number($paginator->total()) }} records</span>
    </div>
</div>

{{ isset($type) ? debug($type) : '' }}

<script>
$(function(){
    $(".selectpicker-pagination").selectpicker();
});
</script>
