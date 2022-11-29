<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\CloseAccountsLogRepository;
use Illuminate\Http\Request;

class CloseAccountsLogController extends Controller
{
    protected $mod_alias = 'user-closelog';
    protected $mod_active = 'user,user-closelog';

    public function index(){

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Close Accounts';

        return view('user.closeAccountsLogs.content',$this->viewdata);

    }

    public function data_tables(Request $request){
        $CloseAccountsLogRepository = new CloseAccountsLogRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        $total_row = 0;

        $get_data = $CloseAccountsLogRepository->get_data($query);

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
            'content' => view('user.closeAccountsLogs.table', $viewdata)->render()
        ]);
    }
}
