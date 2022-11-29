<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Repositories\Setting\MasterActivityRepository;
use Illuminate\Http\Request;

class MasterActivityController extends Controller
{
    protected $mod_alias = 'setting';
    protected $mod_active = 'setting,setting-master_activity';

    public function index(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Master Activity';

        return view('setting.master-activity.content',$this->viewdata);
    }

    public function create(Request $request){
        $MasterActivityRepository = new MasterActivityRepository();
        $data = $MasterActivityRepository->create($request);
        return $data;
    }

    public function edit($id){
        $MasterActivityRepository = new MasterActivityRepository();
        $data = $MasterActivityRepository->edit($id);
        return $data;
    }

    public function edit_process(Request $request){
        $MasterActivityRepository = new MasterActivityRepository();
        $data = $MasterActivityRepository->edit_process($request);
        return $data;
    }

    public function delete($id){
        $MasterActivityRepository = new MasterActivityRepository();
        $data = $MasterActivityRepository->delete($id);
        return $data;
    }

    public function data_tables(Request $request)
    {
        $MasterActivityRepository = new MasterActivityRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $MasterActivityRepository->index($query);

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
            'content' => view('setting.master-activity.table', $viewdata)->render()
        ]);
    }

}
