<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use App\Repositories\WalletUser\WalletUserRepository;
use Illuminate\Http\Request;

class KycLogController extends Controller
{
    protected $mod_alias = 'user-kyclog';
    protected $mod_active = 'wallet-user,user-kyclog';

    public function index(){
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Kyc Log';

        return view('walletuser.kyc-log.content',$this->viewdata);
    }

    public function data_tables(Request $request){
        $WalletUserRepository = new WalletUserRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        $total_row = 0;

        $get_data = $WalletUserRepository->kyc_log($query);

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
            'content' => view('walletuser.kyc-log.table', $viewdata)->render()
        ]);
    }
}
