<div id="table-area-doc">
    <div class="row">
        <div class="col-md-6 m--margin-bottom-10">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Report Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator as $d)
                <tr>
                    <td>
                        <a onclick="setDocNumber('{{ $d->number }}')">
                            <h4><strong style="color: rgb(0, 157, 255)">{{ $d->number }}</strong> - {{$d->subject}}</h4>
                            {{ date('M, d Y', strtotime($d->created_at)) }}, created by {{$d->name}}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>

<script type="text/javascript">
    function setDocNumber(numberDoc) {
        let doc = document.getElementById('document').value = numberDoc;
        $('#table-area-doc').remove();
        $('#DocumentData').modal("hide");
    }

</script>

