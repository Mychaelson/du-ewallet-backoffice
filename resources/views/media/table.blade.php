<div id="table-area">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <div class="list-group">
            @foreach ($paginator as $val)
                <div class="list-group-item list-group-item-action">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <a href="{{ $val->url }}" data-fancybox="group" data-caption="">
                                <img src="{{ $val->url }}" style="margin-left: 20%"
                                    class="img-fluid rounded-start w-50" alt="">
                            </a>
                        </div>
                        <div class="col-md-10">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $val->name }}</h5>
                                <small>{{ date('M, d Y - H:i', strtotime($val->created_at)) }}</small>
                            </div>
                            <p class="mb-1">Location : {{ $val->disk }}<br>
                                Mime Type :{{ $val->mimetype }}

                            </p>
                            {{-- <small>And some small print.</small> --}}
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $paginator->onEachSide(1)->links() }}
        </div>
    </div>

