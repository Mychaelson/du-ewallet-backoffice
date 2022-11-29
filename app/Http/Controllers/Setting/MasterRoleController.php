<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Repositories\Setting\MasterRoleRepository;
use Illuminate\Http\Request;

class MasterRoleController extends Controller
{
    protected $mod_alias = 'setting';
    protected $mod_active = 'setting,master-role';

    public function index(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Master Role';

        return view('setting.master-role.content',$this->viewdata);
    }

    public function create(){
        $MasterRoleRepository = new MasterRoleRepository();
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Master Role';
        $this->viewdata['data'] = $MasterRoleRepository->get_menu();

        return view('setting.master-role.create',$this->viewdata);
    }

    public function store(Request $request){
        $MasterRoleRepository = new MasterRoleRepository();
        return $MasterRoleRepository->store($request);
    }

    public function edit($id){
        $MasterRoleRepository = new MasterRoleRepository();
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Edit Master Role';

        $this->viewdata['edit_data'] = $MasterRoleRepository->edit($id);
        $this->viewdata['data'] = $MasterRoleRepository->get_menu();

        return view('setting.master-role.edit',$this->viewdata);
    }


    public function update(Request $request,$id){
        $MasterRoleRepository = new MasterRoleRepository();
        return $MasterRoleRepository->edit_process($request,$id);
    }

    public function delete($id){
        $MasterRoleRepository = new MasterRoleRepository();
        return $MasterRoleRepository->delete($id);
    }

    public function data_tables(Request $request){
        $MasterRoleRepository = new MasterRoleRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];
		$total_row = 0;

        $get_data = $MasterRoleRepository->index($query);

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
            'content' => view('setting.master-role.table', $viewdata)->render()
        ]);
    }

}
