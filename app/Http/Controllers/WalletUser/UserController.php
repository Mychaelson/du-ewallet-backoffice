<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use App\Repositories\Wallet\HistoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\WalletRepository;
use App\Repositories\WalletUser\WalletUserRepository;


class UserController extends Controller
{

    protected $mod_alias = 'all-user-list';
    protected $mod_active = 'wallet-user,all-user-list';

    public function index(Request $request)
    {
        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        /**
         * Get Group
         */
        $groups = $walletUserRepository->getGroups();
        $this->viewdata['groups'] = $groups;

        /**
         * Get Jobs
         */
        $jobs = $walletUserRepository->getJobs();
        $this->viewdata['jobs'] = $jobs;


        $this->viewdata['page_title'] = 'User List';
        return view('walletuser.user.content', $this->viewdata);
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

        $get_data = $walletUserRepository->getUserList($query);

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
            'content' => view('walletuser.user.table', $viewdata)->render()
        ]);
    }

    public function detail_user($id){

        $walletUserRepository = new WalletUserRepository();
        $walletRepository = new WalletRepository();
        $historyRepository = new HistoryRepository();
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['wallet_summary'] = $walletRepository->getWalletSummary($id);
        $this->viewdata['latest_transaction'] = $historyRepository->getLatestUserTransaction($id);

        $data_va = $walletUserRepository->list_va($id);
        $this->viewdata['data_emoney'] = $data_va;

        $user_emoney = $walletUserRepository->getUserEmoneyFromId($id);
        $this->viewdata['data_user_emoney'] = $user_emoney;

        $user = $walletUserRepository->getUserFromId($id);

        $userinfo = DB::table('accounts.user_informations')->where('user_id', $user->id)->first();
        if($userinfo){
            $this->viewdata['user_info'] = $userinfo;
        }

        $address = $walletUserRepository->getUserAddressFromId($id);
        if($address){
            $this->viewdata['address'] = $address;
        }

        $jobs = $walletUserRepository->getUserJobsFromId($id);
        if($jobs){
            foreach ($jobs as $jo) {
                $json = json_decode($jo->name);

                $jo->name = $json->id;

            }


            $this->viewdata['jobs'] = $jobs;
        }

        $device = $walletUserRepository->getUserDeviceFromId($id);
        if($device){
            $this->viewdata['user_device'] = $device;

        }

        $connect = $walletUserRepository->getUserConnectionFromId($id);
        if($connect){
            $this->viewdata['user_connect'] = $connect;

        }

        $activity_user = $walletUserRepository->getUserActivityFromId($id);
        if($activity_user){
            $this->viewdata['activity_user'] = $activity_user;

        }

        $statistic_user = $walletUserRepository->getUserTotalLoginFromId($id);
        if($statistic_user){
            $this->viewdata['statistic_user'] = $statistic_user;

        }

        $kyc_history = $walletUserRepository->getUserKYCHistoryFromId($id);
        if($kyc_history){
            $this->viewdata['kyc_history'] = $kyc_history;

        }

        $list_media = $walletUserRepository->getUserMediaFromId($id, null);
        if($list_media){
            $this->viewdata['list_media'] = $list_media;

        }

        $wrongPinHistory = $walletUserRepository->getUserWrongPINHistoryFromId($id);
        if($wrongPinHistory){
            $this->viewdata['wrongPinHistory'] = !empty($wrongPinHistory) ? $wrongPinHistory : array();

        }


        $pin_history = $walletUserRepository->getUserChangePINHistoryFromId($id);
        if($pin_history){
            $this->viewdata['pinHistory'] = !empty($pin_history) ? $pin_history : array();

        }

        $operator_name = Auth::user()->name;
        $this->viewdata['operator_name'] = $operator_name;


        $this->viewdata['user'] = $user;

        $this->viewdata['page_title'] = 'Detail User';

        return view('walletuser.user.detail', $this->viewdata);
    }

    public function banAccountView($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);
        if(!$user){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Found']);
        }

        if($user->status != 1){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'User already banned']);
        }

        $this->viewdata['user'] = $user;

        $listLog = $walletUserRepository->getUserBanHistoryFromId($id);
        if(count($listLog) > 0){
            $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();
        }

        $this->viewdata['page_title'] = 'Block User Account';

        return view('walletuser.user.banaccount', $this->viewdata);

    }

    public function banAccount(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');

        $time_start = date("Y-m-d H:i:s");

        if(!empty($id)){
            if(!empty($docs_no)){
                $report = DB::table('backoffice.report')->where('number', $docs_no)->first();
                if($report){
                    if(empty($report->used_by)){

                        $cond = array("id"=>$id);
                        $data = array("status"=>2);

                        $ban_user = DB::table('account.users')->where('id', $id)->update([
                            'status' => 2
                        ]);

                        if($ban_user){
                            $error = false;
                            $message = 'Block user success';

                            //add activity log
                            $datalog = [
                                "user_id" => $id,
                                "status" => 2,
                                "document_number" => $docs_no,
                                "reason" => $reason,
                                "date" => date("Y-m-d H:i:s")
                            ];


                            $time_end = date("Y-m-d H:i:s");
                            $target = $id;

                            $data_logz = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($datalog), "origin"=> NULL, "type"=>'ban_account', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                            //insert to log
                            $insertLog = DB::table('log.kyc_access_log')->insert($data_logz);

                            // update signature document to used
                            $doc = $report->id;
                            $upd = DB::table('backoffice.report')->where('id', $doc)->update(['user_by' =>  Auth::user()->id]);

                            return redirect(route('user.detail', ['id' => $id]))->with(['msg_success' => 'User has been blocked']);

                        }else {
                            $message = "failed to ban account";
                            return redirect(route('user-list'))->with(['msg_error' => $message]);
                        }
                    }else{
                        $message = "This document has been used in another request";
                        return redirect(route('user-list'))->with(['msg_error' => $message]);
                    }
                }else{
                    $message = "document not found";
                    return redirect(route('user-list'))->with(['msg_error' => $message]);

                }
            }else{
                $message = "document must included";
                return redirect(route('user-list'))->with(['msg_error' => $message]);
            }
        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }

    public function unbanAccount(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');

        $time_start = date("Y-m-d H:i:s");

        if(!empty($id)){
            if(!empty($docs_no)){
                $report = DB::table('backoffice.report')->where('number', $docs_no)->first();
                if($report){
                    if(empty($report->used_by)){

                        $cond = array("id"=>$id);
                        $data = array("status"=>2);

                        $ban_user = DB::table('account.users')->where('id', $id)->update([
                            'status' => 1
                        ]);

                        if($ban_user){
                            $error = false;
                            $message = 'Unblock user success';

                            //add activity log
                            $datalog = [
                                "user_id" => $id,
                                "status" => 1,
                                "document_number" => $docs_no,
                                "reason" => $reason,
                                "date" => date("Y-m-d H:i:s")
                            ];


                            $time_end = date("Y-m-d H:i:s");
                            $target = $id;

                            $data_logz = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($datalog), "origin"=> NULL, "type"=>'unban_account', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                            //insert to log
                            $insertLog = DB::table('log.kyc_access_log')->insert($data_logz);

                            // update signature document to used
                            $doc = $report->id;
                            $upd = DB::table('backoffice.report')->where('id', $doc)->update(['user_by' =>  Auth::user()->id]);

                            return redirect(route('user.detail', ['id' => $id]))->with(['msg_success' => 'User has been blocked']);

                        }else {
                            $message = "failed to unban account";
                            return redirect(route('user-list'))->with(['msg_error' => $message]);
                        }
                    }else{
                        $message = "This document has been used in another request";
                        return redirect(route('user-list'))->with(['msg_error' => $message]);
                    }
                }else{
                    $message = "document not found";
                    return redirect(route('user-list'))->with(['msg_error' => $message]);

                }
            }else{
                $message = "document must included";
                return redirect(route('user-list'))->with(['msg_error' => $message]);
            }
        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }

    public function unbanAccountView($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);
        if(!$user){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Found']);
        }

        if($user->status != 1){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'User already banned']);
        }

        $this->viewdata['user'] = $user;

        $listLog = $walletUserRepository->getUserLogTypeFromId($id,['unban_account']);
        if(count($listLog) > 0){
            $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();
        }

        $this->viewdata['page_title'] = 'Unblock User Account';

        return view('walletuser.user.unbanaccount', $this->viewdata);

    }

    public function forcePinView($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);
        if(!$user){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Found']);
        }

        $this->viewdata['user'] = $user;

        $listLog = $walletUserRepository->getUserLogTypeFromId($id,['force_new_pin']);
        if(count($listLog) > 0){
            $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();
        }

        $pin_history = $walletUserRepository->getUserChangePINHistoryFromId($id);
        if($pin_history){
            $this->viewdata['pinHistory'] = !empty($pin_history) ? $pin_history : array();

        }

        $this->viewdata['page_title'] = 'Force New PIN';

        return view('walletuser.user.forcenewpin', $this->viewdata);

    }

    public function forcePinAccount(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');

        $time_start = date("Y-m-d H:i:s");

        if(!empty($id)){
            if(!empty($docs_no)){
                $report = DB::table('backoffice.report')->where('number', $docs_no)->first();
                if($report){
                    if(empty($report->used_by)){

                        $cond = array("id"=>$id);
                        $data = array("status"=>2);

                        $ban_user = DB::table('account.users')->where('id', $id)->update([
                            'is_active_password' => 0
                        ]);

                        if($ban_user){
                            $error = false;
                            $message = 'Block user success';

                            //add activity log
                            $datalog = [
                                "user_id" => $id,
                                "document_number" => $docs_no,
                                "reason" => $reason,
                                "date" => date("Y-m-d H:i:s")
                            ];


                            $time_end = date("Y-m-d H:i:s");
                            $target = $id;

                            $data_logz = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($datalog), "origin"=> NULL, "type"=>'force_new_pin', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                            //insert to log
                            $insertLog = DB::table('log.kyc_access_log')->insert($data_logz);

                            // update signature document to used
                            $doc = $report->id;
                            $upd = DB::table('backoffice.report')->where('id', $doc)->update(['user_by' =>  Auth::user()->id]);

                            return redirect(route('user.detail', ['id' => $id]))->with(['msg_success' => 'User has been blocked']);

                        }else {
                            $message = "failed to ban account";
                            return redirect(route('user-list'))->with(['msg_error' => $message]);
                        }
                    }else{
                        $message = "This document has been used in another request";
                        return redirect(route('user-list'))->with(['msg_error' => $message]);
                    }
                }else{
                    $message = "document not found";
                    return redirect(route('user-list'))->with(['msg_error' => $message]);

                }
            }else{
                $message = "document must included";
                return redirect(route('user-list'))->with(['msg_error' => $message]);
            }
        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }

    public function forceLogoutView($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);
        if(!$user){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Found']);
        }


        $this->viewdata['user'] = $user;

        $listLog = $walletUserRepository->getUserLogTypeFromId($id,['force_logout']);
        if(count($listLog) > 0){
            $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();

        }

        $this->viewdata['page_title'] = 'Force Logout User';

        return view('walletuser.user.forcelogout', $this->viewdata);

    }

    public function forceLogoutAccount(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');

        $time_start = date("Y-m-d H:i:s");

        if(!empty($id)){
            if(!empty($docs_no)){
                $report = DB::table('backoffice.report')->where('number', $docs_no)->first();
                if($report){
                    if(empty($report->used_by)){

                        $cond = array("id"=>$id);
                        $data = array("status"=>2);

                        $revoked_account = DB::table('public.oauth_access_tokens')->where('user_id', $id)->update([
                            'revoked' => 1
                        ]);

                        if($revoked_account){
                            $error = false;
                            $message = 'Force logout success';

                            //add activity log
                            $datalog = [
                                "user_id" => $id,
                                "revoked" => 1,
                                "document_number" => $docs_no,
                                "reason" => $reason,
                                "date" => date("Y-m-d H:i:s")
                            ];


                            $time_end = date("Y-m-d H:i:s");
                            $target = $id;

                            $data_logz = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($datalog), "origin"=> NULL, "type"=>'force_logout', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                            //insert to log
                            $insertLog = DB::table('log.kyc_access_log')->insert($data_logz);

                            // update signature document to used
                            $doc = $report->id;
                            $upd = DB::table('backoffice.report')->where('id', $doc)->update(['user_by' =>  Auth::user()->id]);

                            return redirect(route('user.detail', ['id' => $id]))->with(['msg_success' => 'User has been blocked']);

                        }else {
                            $message = "failed to ban account";
                            return redirect(route('user-list'))->with(['msg_error' => $message]);
                        }
                    }else{
                        $message = "This document has been used in another request";
                        return redirect(route('user-list'))->with(['msg_error' => $message]);
                    }
                }else{
                    $message = "document not found";
                    return redirect(route('user-list'))->with(['msg_error' => $message]);

                }
            }else{
                $message = "document must included";
                return redirect(route('user-list'))->with(['msg_error' => $message]);
            }
        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }

    public function revokeMainDeviceView($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);
        if(!$user){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Found']);
        }


        $this->viewdata['user'] = $user;

        $listLog = $walletUserRepository->getUserLogTypeFromId($id,['revoke_main_devices']);
        if(count($listLog) > 0){
            $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();

        }

        $this->viewdata['page_title'] = 'Revoke User Main Device';

        return view('walletuser.user.revokemaindevice', $this->viewdata);

    }

    public function revokeMainDevice(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');

        $time_start = date("Y-m-d H:i:s");

        if(!empty($id)){
            if(!empty($docs_no)){
                $report = DB::table('backoffice.report')->where('number', $docs_no)->first();
                if($report){
                    if(empty($report->used_by)){

                        $cond = array("id"=>$id);
                        $data = array("status"=>2);

                        $revoked_account = DB::table('accounts.users')->where('id', $id)->update([
                            'main_device' => NULL,
                            'main_device_name' => NULL
                        ]);

                        if($revoked_account){
                            $error = false;
                            $message = 'revoke main device success';

                            //add activity log
                            $datalog = [
                                "user_id" => $id,
                                "main_device" => null,
                                "main_device_name" => null,
                                "document_number" => $docs_no,
                                "reason" => $reason,
                                "date" => date("Y-m-d H:i:s")
                            ];


                            $time_end = date("Y-m-d H:i:s");
                            $target = $id;

                            $data_logz = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($datalog), "origin"=> NULL, "type"=>'revoke_main_devices', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                            //insert to log
                            $insertLog = DB::table('log.kyc_access_log')->insert($data_logz);

                            // update signature document to used
                            $doc = $report->id;
                            $upd = DB::table('backoffice.report')->where('id', $doc)->update(['user_by' =>  Auth::user()->id]);

                            return redirect(route('user.detail', ['id' => $id]))->with(['msg_success' => 'User has been blocked']);

                        }else {
                            $message = "failed to ban account";
                            return redirect(route('user-list'))->with(['msg_error' => $message]);
                        }
                    }else{
                        $message = "This document has been used in another request";
                        return redirect(route('user-list'))->with(['msg_error' => $message]);
                    }
                }else{
                    $message = "document not found";
                    return redirect(route('user-list'))->with(['msg_error' => $message]);

                }
            }else{
                $message = "document must included";
                return redirect(route('user-list'))->with(['msg_error' => $message]);
            }
        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }

    public function unKYCView($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);
        if(!$user){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Found']);
        }

        $userinfo = DB::table('accounts.user_informations')->where('user_id', $user->id)->first();
        if($userinfo && $userinfo->is_valid == 1 && $userinfo->status > 0){
            $this->viewdata['user'] = $user;

            $listLog = $walletUserRepository->getUserLogTypeFromId($id,['unkyc_account']);
            if(count($listLog) > 0){
                $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();

            }

            $this->viewdata['page_title'] = 'unKYC User Account';

            return view('walletuser.user.unkyc', $this->viewdata);

        }else{

            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Info Found']);

        }

    }

    public function unKYC(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');

        $time_start = date("Y-m-d H:i:s");

        if(!empty($id)){
            if(!empty($docs_no)){
                $report = DB::table('backoffice.report')->where('number', $docs_no)->first();
                if($report){
                    if(empty($report->used_by)){

                        $cond = array("id"=>$id);
                        $data = array("status"=>2);

                        $revoked_account = DB::table('accounts.users')->where('id', $id)->update([
                            'main_device' => NULL,
                            'main_device_name' => NULL
                        ]);

                        if($revoked_account){
                            $error = false;
                            $message = 'revoke main device success';

                            //add activity log
                            $datalog = [
                                "user_id" => $id,
                                "main_device" => null,
                                "main_device_name" => null,
                                "document_number" => $docs_no,
                                "reason" => $reason,
                                "date" => date("Y-m-d H:i:s")
                            ];


                            $time_end = date("Y-m-d H:i:s");
                            $target = $id;

                            $data_logz = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($datalog), "origin"=> NULL, "type"=>'revoke_main_devices', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                            //insert to log
                            $insertLog = DB::table('log.kyc_access_log')->insert($data_logz);

                            // update signature document to used
                            $doc = $report->id;
                            $upd = DB::table('backoffice.report')->where('id', $doc)->update(['user_by' =>  Auth::user()->id]);

                            return redirect(route('user.detail', ['id' => $id]))->with(['msg_success' => 'User has been blocked']);

                        }else {
                            $message = "failed to ban account";
                            return redirect(route('user-list'))->with(['msg_error' => $message]);
                        }
                    }else{
                        $message = "This document has been used in another request";
                        return redirect(route('user-list'))->with(['msg_error' => $message]);
                    }
                }else{
                    $message = "document not found";
                    return redirect(route('user-list'))->with(['msg_error' => $message]);

                }
            }else{
                $message = "document must included";
                return redirect(route('user-list'))->with(['msg_error' => $message]);
            }
        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }

    public function watchlistView($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);
        if(!$user){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'No User Found']);
        }

        if($user->watch_status != 1){
            return redirect(route('user.detail', ['id' => $id]))->with(['msg_error' => 'User already watchlisted']);
        }


        $this->viewdata['user'] = $user;

        $listLog = $walletUserRepository->getUserLogTypeFromId($id,['watchlist_account']);
        if(count($listLog) > 0){
            $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();

        }

        $this->viewdata['page_title'] = 'Watchlist User';

        return view('walletuser.user.watchlist', $this->viewdata);

    }

    public function watchListAccount(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');

        $time_start = date("Y-m-d H:i:s");

        if(!empty($id)){
            if(!empty($docs_no)){
                $report = DB::table('backoffice.report')->where('number', $docs_no)->first();
                if($report){
                    if(empty($report->used_by)){

                        $cond = array("id"=>$id);
                        $data = array("status"=>2);

                        $watchlist_user = DB::table('account.users')->where('id', $id)->update([
                            'watch_status' => 1
                        ]);

                        if($watchlist_user){
                            $error = false;
                            $message = 'Watchlisted user success';

                            //add activity log
                            $datalog = [
                                "user_id" => $id,
                                "document_number" => $docs_no,
                                "reason" => $reason,
                                "date" => date("Y-m-d H:i:s")
                            ];


                            $time_end = date("Y-m-d H:i:s");
                            $target = $id;

                            $data_logz = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($datalog), "origin"=> NULL, "type"=>'force_new_pin', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                            //insert to log
                            $insertLog = DB::table('log.kyc_access_log')->insert($data_logz);

                            // update signature document to used
                            $doc = $report->id;
                            $upd = DB::table('backoffice.report')->where('id', $doc)->update(['user_by' =>  Auth::user()->id]);

                            return redirect(route('user.detail', ['id' => $id]))->with(['msg_success' => 'User has been blocked']);

                        }else {
                            $message = "failed to watchlist account";
                            return redirect(route('user-list'))->with(['msg_error' => $message]);
                        }
                    }else{
                        $message = "This document has been used in another request";
                        return redirect(route('user-list'))->with(['msg_error' => $message]);
                    }
                }else{
                    $message = "document not found";
                    return redirect(route('user-list'))->with(['msg_error' => $message]);

                }
            }else{
                $message = "document must included";
                return redirect(route('user-list'))->with(['msg_error' => $message]);
            }
        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }

}
