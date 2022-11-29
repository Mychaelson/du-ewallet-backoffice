<?php

namespace App\Http\Controllers\Setting;

use App\Repositories\Setting\MasterJobsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterJobsController extends Controller
{
    protected $mod_alias = 'setting';
    protected $mod_active = 'setting,setting-jobs';

    public function index(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Master Jobs';

        return view('setting.master-jobs.content',$this->viewdata);
    }

    public function create(Request $request){
        $MasterJobsRepository = new MasterJobsRepository();
        $data = $MasterJobsRepository->create($request);
        return $data;
    }

    public function edit($id){
        $MasterJobsRepository = new MasterJobsRepository();
        $data = $MasterJobsRepository->edit($id);
        return $data;
    }

    public function edit_process(Request $request){
        $MasterJobsRepository = new MasterJobsRepository();
        $data = $MasterJobsRepository->edit_process($request);
        return $data;
    }

    public function delete($id){
        $MasterJobsRepository = new MasterJobsRepository();
        $data = $MasterJobsRepository->delete($id);
        return $data;
    }

    public function data_tables(Request $request){
        $MasterJobsRepository = new MasterJobsRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $MasterJobsRepository->index($query);

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
            'content' => view('setting.master-jobs.table', $viewdata)->render()
        ]);
    }
}
