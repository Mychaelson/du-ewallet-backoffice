<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\InOutRepository;

class InOutContoller extends Controller
{
    protected $mod_alias = 'wallet-inout';
    protected $mod_active = 'wallet,wallet-inout';

    public function index(Request $request)
    {        
        $inOutRepository = new InOutRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'Wallet In/Out';
        return view('wallet.inout.content', $this->viewdata);
    }

    public function dataTable(Request $request)
    {
        $inOutRepository = new InOutRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        

		$total_row = 0;

        $get_data = $inOutRepository->getList($query);

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
            'content' => view('wallet.inout.table', $viewdata)->render()
        ]);
    }
}
