<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Wallet\SettingRepository;

class SettingController extends Controller
{
    protected $mod_alias = 'wallet-setting';
    protected $mod_active = 'wallet,wallet-setting';

    public function index(Request $request)
    {
        $settingRepository = new SettingRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $this->viewdata['page_title'] = 'Wallet Setting';
        return view('wallet.setting.content', $this->viewdata);
    }

    public function dataTable(Request $request)
    {
        $settingRepository = new SettingRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        

		$total_row = 0;

        $get_data = $settingRepository->getSettingList($query);

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
            'content' => view('wallet.setting.table', $viewdata)->render()
        ]);
    }

    public function update (Request $request, $id) {
        $settingRepository = new SettingRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $settingRepository->getInfo(['id' => $id]);

        $this->viewdata['page_title'] = 'Update Setting';
        return view('wallet.setting.form', $this->viewdata);
    }

    public function store (Request $request){
        $settingRepository = new SettingRepository();
        
        $validate = Validator::make($request->all(), [
            'value' => 'required'
        ]);

        if ($validate->fails()) {
            dd($validate->errors());
        }

        $data = [
            'value' => $request->value
        ];

        if ($request->setting_id) {
            $update = $settingRepository->updateById($request->setting_id, $data);
        } else {
            //new data
        }

        return redirect()->to(route('wallet-setting'));
    }
}
