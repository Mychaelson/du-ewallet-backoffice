<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Wallet\SwitchRepository;

class SwitchController extends Controller
{
    protected $mod_alias = 'wallet-switch';
    protected $mod_active = 'wallet,wallet-switch';
    
    public function index(Request $request)
    {
        $switchRepository = new SwitchRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $this->viewdata['page_title'] = 'Switch Fee By Bank';
        return view('wallet.switch.content', $this->viewdata);
    }

    public function dataTable(Request $request)
    {
        $switchRepository = new SwitchRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        

		$total_row = 0;

        $get_data = $switchRepository->getList($query);

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
            'content' => view('wallet.switch.table', $viewdata)->render()
        ]);
    }

    public function update (Request $request, $id) {
        $switchRepository = new SwitchRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $switchRepository->getSwitchInfo(['id' => $id]);
        $this->viewdata['bank_list'] = $switchRepository->getBankList();

        $this->viewdata['page_title'] = 'Update Swithing Fee';
        return view('wallet.switch.form', $this->viewdata);
    }

    public function store (Request $request){
        $switchRepository = new SwitchRepository();
        
        $validate = Validator::make($request->all(), [
            'switch_fee' => 'required|numeric|gt:0',
            'cgs' => 'required|numeric|gt:0'
        ]);

        if ($validate->fails()) {
            dd($validate->errors());
        }

        $data = [
            'fee' => $request->switch_fee,
            'cgs' => $request->cgs
        ];
        
        $filter = [
            'bank_from' => $request->bank_from,
            'bank_to' => $request->bank_to
        ];

        if ($request->switch_id) {
            $update = $switchRepository->updateById($request->switch_id, $data);
        } else {
            // check if the data exist based on the bank_to and bank_from
            $res = $switchRepository->getSwitchInfo($filter);
            if (isset($res)) {
                $update = $switchRepository->updateById($res->id, $data);
            } else {
                $data = array_merge($data, $filter);
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $store = $switchRepository->store($data);
            }
        }

        return redirect()->to(route('wallet-switch'));
    }

    public function add (Request $request) {
        $switchRepository = new SwitchRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['bank_list'] = $switchRepository->getBankList();

        $this->viewdata['page_title'] = 'Add Swithing Fee';
        return view('wallet.switch.form', $this->viewdata);
    }
}
