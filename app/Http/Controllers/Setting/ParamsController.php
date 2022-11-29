<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Repositories\Setting\ParamsRepository;
use Illuminate\Http\Request;

class ParamsController extends Controller
{
    protected $mod_alias = 'setting';
    protected $mod_active = 'setting,setting-params';
    public function index(){
        $ParamsRepository = new ParamsRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Application Setting';
        $this->viewdata['group'] = $ParamsRepository->get_group();

        return view('setting.site-param.content',$this->viewdata);

    }

    public function create(Request $request){
     $ParamsRepository = new ParamsRepository();
    return $ParamsRepository->create($request);
    }

    public function edit($id){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Application Setting';

        $ParamsRepository = new ParamsRepository();
        $this->viewdata['data'] = $ParamsRepository->edit($id);
        $this->viewdata['group'] = $ParamsRepository->get_group();

        return view('setting.site-param.edit',$this->viewdata);
    }

    public function edit_process($id,Request $request){
        $ParamsRepository = new ParamsRepository();
        $data = $ParamsRepository->edit_process($id,$request);
        return $data;
    }

    public function delete($id){
        $ParamsRepository = new ParamsRepository();
        $data = $ParamsRepository->delete($id);
        return $data;
    }
    public function data_tables(Request $request){
        $ParamsRepository = new ParamsRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $ParamsRepository->index($query);

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
            'content' => view('setting.site-param.table', $viewdata)->render()
        ]);
    }
}
