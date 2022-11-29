<?php

namespace App\Http\Controllers\Documents\Help;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Help\HelpRepository;
class HelpCategoryController extends Controller
{
    protected $mod_alias = 'help';
    protected $mod_active = 'documents,help';


    public function index(Request $request, $id)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Help Category';
        $HelpRepository = new HelpRepository();

        $req = $request->search;
        $this->viewdata['data'] = $HelpRepository->index($req,$id);
        $this->viewdata['category'] = $HelpRepository->category($id);


        return view('documents.help.index-by-category',$this->viewdata);
    }

    public function index_category(Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Help Category';

        // $HelpRepository = new HelpRepository();
        // $this->viewdata['data'] = $HelpRepository->index_category($request);
        return view('documents.help.index',$this->viewdata);
    }

    public function data_tables_category(Request $request){
        $HelpRepository = new HelpRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $HelpRepository->index_category($query);
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
            'content' => view('documents.help.table-index', $viewdata)->render()
        ]);
    }

    public function create($id)
    {
        $HelpRepository = new HelpRepository();
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Help Category';

        $this->viewdata['data'] = $HelpRepository->create($id);
        return view('documents.help.create',$this->viewdata);
    }

    public function store(Request $request)
    {
        $HelpRepository = new HelpRepository();
        $data = $HelpRepository->store($request);
        return $data;
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $HelpRepository = new HelpRepository();
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Edit';

       $get_data = $HelpRepository->edit($id);

       $keywords_array = implode(',', array($get_data->keywords));
       $this->viewdata['keywords'] = str_replace(['"',"'",'[',']'], "", $keywords_array);

       $this->viewdata['category'] = $HelpRepository->category($get_data->category);
       $this->viewdata['data'] =  $HelpRepository->edit($id);

        return view('documents.help.edit', $this->viewdata);

    }

    public function update(Request $request, $id)
    {
        $HelpRepository = new HelpRepository();
        $data = $HelpRepository->update($request,$id);
        return $data;
    }

    public function destroy($id)
    {
        $HelpRepository = new HelpRepository();
        $data = $HelpRepository->destory($id);
        return $data;
    }
}
