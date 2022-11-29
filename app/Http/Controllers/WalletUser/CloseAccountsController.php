<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use App\Repositories\User\CloseAccountsRepository;
use Illuminate\Http\Request;

class CloseAccountsController extends Controller
{
    protected $mod_alias = 'user-closeaccount';
    protected $mod_active = 'user,user-closeaccount';

    public function index(Request $request)
    {        
        $closeAccountsRepository = new CloseAccountsRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'Close Accounts';

        // $query = $request->input('query');

        // $get_data = $closeAccountsRepository->getCloseAccountsList($query);

        // dd($get_data->get());
        return view('walletuser.closeAccounts.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $closeAccountsRepository = new CloseAccountsRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

        $total_row = 0;

        $get_data = $closeAccountsRepository->getCloseAccountsList($query);

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
            'content' => view('walletuser.closeAccounts.table', $viewdata)->render()
        ]);
    }

    public function form (Request $request, $id) {
      $closeAccountsRepository = new CloseAccountsRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'Close Accounts Request';

        $this->viewdata['info'] = $closeAccountsRepository->getCloseAccountsList(['id' => $id]);
        $this->viewdata['meta'] = json_decode($this->viewdata['info']->meta);
        // dd($this->viewdata['info']);

        return view('walletuser.closeAccounts.form', $this->viewdata);
    }

    public function store (Request $request){
      $closeAccountsRepository = new CloseAccountsRepository();
      $user = $request->user();

      $id = $request->closeaccount_id;

      $data = [
        'reason' => $request->reason,
        'approval_by' => $user->name,
        'approved_at' => now()
      ];

      if ($request->status == 'reject') {
        $data['status'] = 4;
      } elseif ($request->status == 'approve') {
        $data['status'] = 5;
      }

      $closeAccountsRepository->updateCloseAccount($data, $id);

      return redirect()->to(route('user-close-accounts'));
    }
}
