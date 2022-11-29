<?php

namespace App\Http\Controllers\Documents\YamisokPayDocument;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Documents\DocumentsRepository;
class DocumentController extends Controller
{
    // private $DocumentsRepository;
    protected $mod_alias = 'documents';
    protected $mod_active = 'documents,all-documents';


    public function index(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'All Documents';

        return view('documents.yamisok-pay-document.index',$this->viewdata);
    }

    public function data_table(Request $request)
    {
        $DocumentsRepository = new DocumentsRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $DocumentsRepository->index($query);

        $paginator = $get_data->paginate($limit, ['*'], 'pagination.page');

        $total_row = $paginator->total();

        if($total_row == 0)
        {
            return response()->json([
                'status' => TRUE,
                'total_row' => $total_row
            ]);
        }


        $viewdata['limit'] = $limit;
        $viewdata['query'] = $query;
        $viewdata['paginator'] = $paginator;


        return response()->json([
            'status' => TRUE,
            'total_row' => $total_row,
            'paginator' => $paginator,
            'content' => view('documents.yamisok-pay-document.table', $viewdata)->render()
        ]);
    }


    public function create()
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'All Documents';

        return view('documents.yamisok-pay-document.create',$this->viewdata);
    }

    public function store(Request $request)
    {
        $DocumentsRepository = new DocumentsRepository();
        $data = $DocumentsRepository->store($request);

        return $data;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $DocumentsRepository = new DocumentsRepository();
        $this->viewdata['data'] = $DocumentsRepository->edit($id);

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'All Documents';

        return view('documents.yamisok-pay-document.edit',$this->viewdata);

    }

    public function update(Request $request, $id)
    {
        $DocumentsRepository = new DocumentsRepository();
        $data = $DocumentsRepository->update($id,$request);


        return $data;
    }

    public function destroy($id)
    {
        $DocumentsRepository = new DocumentsRepository();
        $data = $DocumentsRepository->destory($id);

        return $data;
    }
}
