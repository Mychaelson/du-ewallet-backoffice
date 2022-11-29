<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Repositories\Report\ReportRepository;
use App\Repositories\Users\UsersRepository;
use App\Repositories\Wallet\HistoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\WalletRepository;
use App\Repositories\WalletUser\WalletUserRepository;
use App\Repositories\Wallet\SwitchRepository;
use App\Repositories\Wallet\WalletSettingRepository;
use App\Repositories\Wallet\WithdrwaFeeRepository;
use Carbon\Carbon;
use Session;

class WalletController extends Controller
{
    protected $mod_alias = 'wallet-emoney';
    protected $mod_active = 'wallet,wallet-emoney';

    public function index(Request $request)
    {        
        $walletRepository = new WalletRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['filter_lock'] = ['Lock In','Lock Out','Lock Withdraw','Lock Transfer', 'Lock Payment'];

        $this->viewdata['page_title'] = 'All Emoney Wallets';
        return view('wallet.emoney.content', $this->viewdata);
    }

    public function dataTable(Request $request)
    {
        $walletRepository = new WalletRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $viewdata = [];

		$total_row = 0;

        $get_data = $walletRepository->getWalletList($query);
        $sumBalance = $walletRepository->getSumWalletBalance($query);

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
            'content' => view('wallet.emoney.table', $viewdata)->render(),
            'sum_balance' => $sumBalance,
        ]);
    }

    public function update (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        $historyRepository = new HistoryRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);
        $this->viewdata['wallet_limit'] = $walletRepository->getWalletLimit($id);
        $this->viewdata['today_transaction'] = $walletRepository->getWalletTransactionBywalletId($id);
        $this->viewdata['wallet_summary'] = $walletRepository->getWalletSummary($id);
        $this->viewdata['latest_transaction'] = $historyRepository->getLatestUserTransaction($id);

        $this->viewdata['page_title'] = 'Wallet E-Money Information';
        return view('wallet.emoney.form', $this->viewdata);
    } 

    public function walletSetting (Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $walletSettingId = $request->input('id');

        $data = $walletSettingRepository->getWalletSettingById($walletSettingId);

        return response()->json([
            'status' => true,
            'content' => $data
        ]);
    }

    public function returnAdjustment (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        $historyRepository = new HistoryRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);
        $this->viewdata['wallet_summary'] = $walletRepository->getWalletSummary($id);

        $this->viewdata['page_title'] = 'Wallet Return Adjustment';

        return view('wallet.emoney.returnAdjusment', $this->viewdata);
    }

    public function withdrawFee (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        $historyRepository = new HistoryRepository();
        $switchRepository = new SwitchRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);
        $this->viewdata['wallet_summary'] = $walletRepository->getWalletSummary($id);
        $this->viewdata['bank_list'] = $switchRepository->getBankList();

        $this->viewdata['page_title'] = 'Withdraw Fee';

        return view('wallet.emoney.withdrawFee', $this->viewdata);
    }

    public function withdrawFeeTable(Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;
        $walletId = $query['wallet_id'];

        $viewdata = [];

		$total_row = 0;

        $get_data = $walletSettingRepository->getWalletSetting('set_withdraw_fee',$walletId);

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
            'content' => view('wallet.emoney.reqWithdrawFeeTable', $viewdata)->render(),
        ]);
    }

    public function withdrawFeeReqApproval(Request $request){
        $walletSettingRepository = new WalletSettingRepository();
        $user = $request->user();
        $id = $request->input('id');
        $status = $request->input('status');

        if ($status == 'reject') {
            $data = [
                'status' => 1,
                'approved_by' => $user->id
            ];
            $walletSettingRepository->updateWalletSettingStatus($id, $data);

            return response()->json([
                'status' => true,
                'message' => 'Add Withdraw Fee Request Has Been Cancelled',
            ]);
        }


        DB::beginTransaction();
        try {
            $walletSettingData = $walletSettingRepository->getWalletSettingById($id);
            $walletId = $walletSettingData->wallet_id;
            $document = $walletSettingData->document;
            $changes = json_decode($walletSettingData->changes, true);
            $data = [
                'status' => 3,
                'approved_by' => $user->id
            ];

            $changes['status'] = 1;
            $changes['created_at'] = now();
            $changes['updated_at'] = now();

            if ($status == 'approve') {
                $walletSettingRepository->updateWalletSettingStatus($id, $data);
                $walletSettingRepository->addWithdrawFee($changes);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Add Withdraw Fee Request is Approved',
        ]);
    }

    public function withdrawFeeAction (Request $request){
        $withdrwaFeeRepository = new WithdrwaFeeRepository();
        $walletSettingRepository = new WalletSettingRepository();
        $reportRepository = new ReportRepository();
        $requestor = Auth::user();

        $query = $request->input('query');
        $id = $request->input('wallet_id');
        $action = $request->input('action');
        $document = $query['document'];
        $reason = $query['reason'];

        $existingRequest = $walletSettingRepository->checkCurrentPendingSettingByfiture('set_withdraw_fee', $id);

        if ($existingRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Pending request for this user exist',
            ]);
        }

        if($reportRepository->reportNotExist($document) ==0){
            return response()->json([
                'status' => false,
                'message' => 'Document not exist',
            ]);
        }

        if($reportRepository->reportUsed() == 1){
            return response()->json([
                'status' => false,
                'message' => 'Document already used',
            ]);
        }

        $info = [
            'bank_id' => $query['bank_id'],
            'fee' => $query['fee'],
            'wallet_id' => $id
        ];

        $data = [
            'wallet_id' => $id,
            'fiture' => 'set_withdraw_fee',
            'status' => 2,
            'changes' => json_encode($info),
            'requested_by' => $requestor->id,
            'document' => $document,
            'reason' => $reason,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $result = $walletSettingRepository->insertWalletSetting($data);
        $documentUsed = $reportRepository->updateDocumentInfo($document, ['used_by' => $requestor->id]);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);

    }

    public function adjustment (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        $historyRepository = new HistoryRepository();
        $switchRepository = new SwitchRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);
        $this->viewdata['wallet_summary'] = $walletRepository->getWalletSummary($id);

        $this->viewdata['page_title'] = 'Wallet Adjustment';

        return view('wallet.emoney.adjustment', $this->viewdata);
    }

    public function transferBlacklist (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        $historyRepository = new HistoryRepository();
        $switchRepository = new SwitchRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);
        $this->viewdata['wallet_summary'] = $walletRepository->getWalletSummary($id);

        $this->viewdata['page_title'] = 'Transfer Blacklist';

        return view('wallet.emoney.transferBlacklist', $this->viewdata);
    }

    public function getUserList (Request $request){
        $walletUserRepository = new WalletUserRepository();

        $search = $request->search;

        $users = $walletUserRepository->ListOfUser($search);

        $response = array();
        foreach($users as $user){
            $response[] = array("value"=>$user->phone.' - '.$user->name, 'phone' => $user->phone, 'name' => $user->name, 'id' => $user->id);
        }

        return response()->json($response);
    }

    public function reqTfBlacklist (Request $request){
        $walletSettingRepository = new WalletSettingRepository();
        $reportRepository = new ReportRepository();
        $requestor = Auth::user();

        $query = $request->input('query');
        $id = $request->input('wallet_id');
        $user_id = $query['user_id'];
        $target_id = $query['target'];
        $document = $query['document'];
        $reason = $query['reason'];

        $existingRequest = $walletSettingRepository->checkCurrentPendingSettingByfiture('set_transfer_blacklist', $id);

        if ($existingRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Pending request for this user exist',
            ]);
        }

        $info = [
            'user_id' => $user_id,
            'target_id' => $target_id
        ];

        $data = [
            'wallet_id' => $id,
            'fiture' => 'set_transfer_blacklist',
            'status' => 2,
            'changes' => json_encode($info),
            'requested_by' => $requestor->id,
            'document' => $document,
            'reason' => $reason,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $result = $walletSettingRepository->insertWalletSetting($data);
        $documentUsed = $reportRepository->updateDocumentInfo($document, ['used_by' => $requestor->id]);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function withdrawBlacklist (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        $historyRepository = new HistoryRepository();
        $switchRepository = new SwitchRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);
        $this->viewdata['wallet_summary'] = $walletRepository->getWalletSummary($id);
        $this->viewdata['listOfBank'] = $walletRepository->getListOfBank();

        $this->viewdata['page_title'] = 'Withdrawal Blacklist';

        return view('wallet.emoney.withdrawBlacklist', $this->viewdata);
    }

    public function updateLock(Request $request){
        $walletRepository = new WalletRepository();

        $query = $request->input('query');
        $id = $request->input('wallet_id');

        $result = $walletRepository->updateById($id, $query);

        return response()->json([
            'status' => TRUE,
            'data' => $result
        ]);
    }

    public function reversal (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);

        $this->viewdata['page_title'] = 'Wallet E-Money Reversal fund(s)';
        return view('wallet.emoney.reversal', $this->viewdata);
    }

    public function limit (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);
        $this->viewdata['limit'] = $walletRepository->getWalletLimit($id);

        $this->viewdata['page_title'] = 'Wallet E-Money limit';
        return view('wallet.emoney.limit', $this->viewdata);
    }

    public function switch (Request $request, $id){
        $walletRepository = new WalletRepository();
        $userRepository = new WalletUserRepository();
        
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['id'] = $id;
        $this->viewdata['info'] = $walletRepository->getWallet('id', $id)->first();
        $this->viewdata['user_info'] = $userRepository->getUserFromId($this->viewdata['info']->user_id);

        $this->viewdata['page_title'] = 'Switching Fee';
        return view('wallet.emoney.switch', $this->viewdata);
    }

    public function updateLimit (Request $request) {
        $walletSettingRepository = new WalletSettingRepository();
        $reportRepository = new ReportRepository();
        $requestor = Auth::user();

        $query = $request->input('query');
        $id = $request->input('wallet_id');
        $document = $query['document'];
        $reason = $query['reason'];

        $existingRequest = $walletSettingRepository->checkCurrentPendingSettingByfiture('set_wallet_limit', $id);

        if ($existingRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Pending request for this user exist',
            ]);
        }

        if($reportRepository->reportNotExist($document) ==0){
            return response()->json([
                'status' => false,
                'message' => 'Document not exist',
            ]);
        }

        if($reportRepository->reportUsed() == 1){
            return response()->json([
                'status' => false,
                'message' => 'Document already used',
            ]);
        }

        

        $info = [
            'max_balance' => $query['max_balance'],
            'transaction_monthly' => $query['max_monthly_transaction'],
            'payment_daily' => $query['max_payment_daily'],
            'transfer_daily' => $query['max_transfer_daily'],
            'withdraw_daily' => $query['max_withdraw_daily'],
            'switching_max' => $query['switching_max'],
            'free_withdraw' => $query['free_withdraw'],
            'max_group_transfer' => $query['max_group_transfer'],
            'max_group_withdraw' => $query['max_group_withdraw'],
        ];

        $data = [
            'wallet_id' => $id,
            'fiture' => 'set_wallet_limit',
            'status' => 2,
            'changes' => json_encode($info),
            'requested_by' => $requestor->id,
            'document' => $document,
            'reason' => $reason,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $result = $walletSettingRepository->insertWalletSetting($data);
        $documentUsed = $reportRepository->updateDocumentInfo($document, ['used_by' => $requestor->id]);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function walletLimitReqTable(Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;
        $walletId = $query['wallet_id'];

        $viewdata = [];

		$total_row = 0;

        $get_data = $walletSettingRepository->getWalletSetting('set_wallet_limit',$walletId , 2);

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
            'content' => view('wallet.emoney.reqWalletLimitTable', $viewdata)->render(),
        ]);
    }

    public function walletLimitReqAction(Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $walletSettingId = $request->input('id');

        $data = $walletSettingRepository->getWalletSettingById($walletSettingId);

        return response()->json([
            'status' => true,
            'content' => $data
        ]);
    }

    public function walletLimitApproval(Request $request){
        $walletSettingRepository = new WalletSettingRepository();
        $user = $request->user();
        $id = $request->input('id');
        $status = $request->input('status');

        if ($status == 'reject') {
            $data = [
                'status' => 1,
                'approved_by' => $user->id
            ];
            $walletSettingRepository->updateWalletSettingStatus($id, $data);

            return response()->json([
                'status' => true,
                'message' => 'Wallet Limit Request Has Been Cancelled',
            ]);
        }


        DB::beginTransaction();
        try {
            $walletSettingData = $walletSettingRepository->getWalletSettingById($id);
            $walletId = $walletSettingData->wallet_id;
            $document = $walletSettingData->document;
            $changes = json_decode($walletSettingData->changes, true);
            $data = [
                'status' => 3,
                'approved_by' => $user->id
            ];
            if ($status == 'approve') {
                $walletSettingRepository->updateWalletSettingStatus($id, $data);
                $walletSettingRepository->updateWalletLimitByWalletId($walletId, $changes);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Wallet Limit Request is Approved',
        ]);
    }

    public function walletLimitReqHistoryTable (Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;
        $walletId = $query['wallet_id'];

        $viewdata = [];

		$total_row = 0;

        $get_data = $walletSettingRepository->getWalletSettingHistory('set_wallet_limit',$walletId , 2);

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
            'content' => view('wallet.emoney.reqWalletLimitHistoryTable', $viewdata)->render(),
        ]);
    }

    public function TfBlacklistReqTable(Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;
        $walletId = $query['wallet_id'];

        $viewdata = [];

		$total_row = 0;

        $get_data = $walletSettingRepository->getWalletSetting('set_transfer_blacklist', $walletId);

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
            'content' => view('wallet.emoney.tfBlacklistTable', $viewdata)->render(),
        ]);
    }

    public function TfBlacklistReqAction(Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $walletSettingId = $request->input('id');

        $data = $walletSettingRepository->getWalletSettingById($walletSettingId);

        return response()->json([
            'status' => true,
            'content' => $data
        ]);
    }

    public function tfBlacklistReqApproval(Request $request){
        $walletSettingRepository = new WalletSettingRepository();
        $user = $request->user();
        $id = $request->input('id');
        $status = $request->input('status');

        if ($status == 'reject') {
            $data = [
                'status' => 1,
                'approved_by' => $user->id
            ];
            $walletSettingRepository->updateWalletSettingStatus($id, $data);

            return response()->json([
                'status' => true,
                'message' => 'Transfer Blacklist Request Has Been Cancelled',
            ]);
        }


        DB::beginTransaction();
        try {
            $walletSettingData = $walletSettingRepository->getWalletSettingById($id);
            $walletId = $walletSettingData->wallet_id;
            $document = $walletSettingData->document;
            $changes = json_decode($walletSettingData->changes, true);
            $data = [
                'status' => 3,
                'approved_by' => $user->id
            ];

            $changes['status'] = 1;

            if ($status == 'approve') {
                $walletSettingRepository->updateWalletSettingStatus($id, $data);
                $walletSettingRepository->addTfBlacklist($changes);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transfer Blacklist Request is Approved',
        ]);
    }

    public function getUserAcc(Request $request){
        $walletRepository = new WalletRepository();
        $user_id = $request->input('user_id');
        $bank_id = $request->input('bank_id');

        $data = $walletRepository->getBankAccountList($user_id, $bank_id);

        return response()->json([
            'status' => true,
            'content' => $data,
            'info' => [$user_id, $bank_id]
        ]);
    }

    public function reqWdBlacklist(Request $request)
    {
        $walletSettingRepository = new WalletSettingRepository();
        $reportRepository = new ReportRepository();
        $requestor = Auth::user();

        $query = $request->input('query');
        $id = $request->input('wallet_id');
        $user_id = $query['user_id'];
        $bank_id = $query['bank_id'];
        $bank_account = $query['bank_account'];
        $document = $query['document'];
        $reason = $query['reason'];

        $existingRequest = $walletSettingRepository->checkCurrentPendingSettingByfiture('set_withdraw_blacklist', $id);

        if ($existingRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Pending request for this user exist',
            ]);
        }

        $info = [
            'user_id' => $user_id,
            'bank_id' => $bank_id,
            'bank_account' => $bank_account
        ];

        $data = [
            'wallet_id' => $id,
            'fiture' => 'set_withdraw_blacklist',
            'status' => 2,
            'changes' => json_encode($info),
            'requested_by' => $requestor->id,
            'document' => $document,
            'reason' => $reason,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $result = $walletSettingRepository->insertWalletSetting($data);
        $documentUsed = $reportRepository->updateDocumentInfo($document, ['used_by' => $requestor->id]);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function WdBlacklistReqTable(Request $request){
        $walletSettingRepository = new WalletSettingRepository();

        $query = $request->input('query');

        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 10);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;
        $walletId = $query['wallet_id'];

        $viewdata = [];

		$total_row = 0;

        $get_data = $walletSettingRepository->getWalletSetting('set_withdraw_blacklist', $walletId);

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
            'content' => view('wallet.emoney.wdBlacklistTable', $viewdata)->render(),
        ]);
    }

    public function WdBlacklistReqAction(Request $request)
    {
        $walletSettingRepository = new WalletSettingRepository();

        $walletSettingId = $request->input('id');

        $data = $walletSettingRepository->getWalletSettingById($walletSettingId);

        return response()->json([
            'status' => true,
            'content' => $data
        ]);
    }

    public function wdBlacklistReqApproval(Request $request){
        $walletSettingRepository = new WalletSettingRepository();
        $user = $request->user();
        $id = $request->input('id');
        $status = $request->input('status');

        if ($status == 'reject') {
            $data = [
                'status' => 1,
                'approved_by' => $user->id
            ];
            $walletSettingRepository->updateWalletSettingStatus($id, $data);

            return response()->json([
                'status' => true,
                'message' => 'Withdraw Blacklist Request Has Been Cancelled',
            ]);
        }


        DB::beginTransaction();
        try {
            $walletSettingData = $walletSettingRepository->getWalletSettingById($id);
            $walletId = $walletSettingData->wallet_id;
            $document = $walletSettingData->document;
            $changes = json_decode($walletSettingData->changes, true);
            $data = [
                'status' => 3,
                'approved_by' => $user->id
            ];

            $changes['status'] = 1;

            // return $changes['bank_account'];
            if ($status == 'approve') {
                $walletSettingRepository->updateWalletSettingStatus($id, $data);
                // TODO: change the repo
                $walletSettingRepository->addWdBlacklist($changes);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Withdraw Blacklist Request is Approved',
        ]);
    }
}
