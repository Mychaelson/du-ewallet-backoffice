<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Repositories\WalletUser\WalletUserRepository;


class GroupsController extends Controller
{
    
    protected $mod_alias = 'user-groups';
    protected $mod_active = 'wallet-user,user-groups';

    public function index(Request $request)
    {        
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $this->viewdata['page_title'] = 'Groups List';
        return view('walletuser.groups.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $walletUserRepository = new WalletUserRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        

		$total_row = 0;

        $get_data = $walletUserRepository->getGroupList($query);

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
            'content' => view('walletuser.groups.table', $viewdata)->render()
        ]);
    }

    public function edit($id)
    {

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $edit_data = $walletUserRepository->getGroupById($id);
        $this->viewdata['edit_data'] = $edit_data;

        $this->viewdata['page_title'] = 'Edit Groups';
        return view('walletuser.groups.edit', $this->viewdata);

    }

}
 