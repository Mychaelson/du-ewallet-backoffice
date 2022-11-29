<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\Datatables;

use App\Repositories\WalletUser\WalletUserRepository;


class KYCController extends Controller
{
    
    protected $mod_alias = 'user-kyc';
    protected $mod_active = 'wallet-user,user-kyc';

    public function index(Datatables $datatables, Request $request)
    {        
        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'KYC User';
        return view('walletuser.kyc.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $get_data = DB::table('accounts.user_informations')
        ->join('accounts.users', 'user_informations.user_id', '=', 'users.id')
        ->where('is_valid', 0)
        ->selectRaw('user_informations.*,users.name, users.username, users.phone, users.nickname');


        $query = $request->input('query');
        if(!empty($query))
        {

            if(isset($query['status']) && $query['status'] != "") {
                $get_data->whereRaw("(user_informations.status = '".$query['status']."')");
            }

        }

        if(isset($request->sort['field']))
        {
            $get_data->orderBy($request->sort['field'], $request->sort['sort']);
        }
        else
        {
            $get_data->orderBy('user_informations.id', 'desc');
        }

        $paginator = $get_data->paginate($limit, ['*'], 'pagination.page');

        $total_row = $paginator->total();

        if($total_row == 0)
        {
            return response()->json([
                'status' => TRUE,
                'total_row' => $total_row
            ]);
        }

        $_data = $rowIds = [];

        $viewdata['limit'] = $limit;
        $viewdata['query'] = $query;
        $viewdata['paginator'] = $paginator;
    

        return response()->json([
            'status' => TRUE,
            'total_row' => $total_row,
            'paginator' => $paginator,
            'content' => view('walletuser.kyc.table', $viewdata)->render()
        ]);
    }

    public function detail_user($id){

        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $user = $walletUserRepository->getUserFromId($id);

        $userinfo = DB::table('accounts.user_informations')->where('user_id', $user->id)->first();
        if($userinfo){
            $this->viewdata['user_info'] = $userinfo;
        }

        $address = $walletUserRepository->getUserAddressFromId($id);
        if($address){
            $this->viewdata['address'] = $address;
        }
        
        $jobs = DB::table('accounts.user_jobs')->where('user_id', $id)->first();
        if($jobs){



            $this->viewdata['jobs'] = $jobs;
        }
        

        $all_jobs = DB::table('accounts.jobs')->get();
        if($all_jobs){
            foreach($all_jobs as $jo){
                $jsonjo = json_decode($jo->name);

                $jo->name = $jsonjo->id;
    
            }

        }
        $this->viewdata['all_jobs'] = $all_jobs;


        $listLog = $walletUserRepository->getUserLogTypeFromId($id,['unkyc','approve_kyc','reject_kyc','requestEdit_kyc','unkyc_account']);
        if(count($listLog) > 0){
            $this->viewdata['listLog'] = !empty($listLog) ? $listLog : array();
    
        }  

        $list_media = $walletUserRepository->getUserMediaFromId($id, null);
        if($list_media){
            $this->viewdata['list_media'] = $list_media;

        } 


        $operator_name = Auth::user()->name;
        $this->viewdata['operator_name'] = $operator_name;


        $this->viewdata['user'] = $user;

        $this->viewdata['page_title'] = 'Detail KYC User';

        return view('walletuser.kyc.detail', $this->viewdata);
    }

    public function update(Request $request, $id){

        $docs_no = $request->input('document');
        $reason = $request->input('reason');
        $status_approval =  $request->input('decision');

        $time_start = date("Y-m-d H:i:s");
        $data = $data_info = $data_job = $data_addr = array();

        if(!empty($id)){

            if($status_approval == "reject"){
                $data_info["status"] = 3;
            }elseif($status_approval == "accept"){
                $data["verified"] = 1;
                $data_info["is_valid"] = 1;
                $data_info["status"] = 2;

            }elseif($status_approval == "request"){
                $data_info["status"] = 4;
            } 

            if(!empty($request->input('place_of_birth'))) $data["place_of_birth"] = $request->input('place_of_birth');
            if(!empty($request->input('date_of_birth'))) $data["date_of_birth"] = $request->input('date_of_birth');
            if(!empty($request->input('decision'))) $data_info["nationality"] = $request->input('nationality');
            if(!empty($request->input('decision'))) $data_info["identity_type"] = $request->input('identity_type');
            if(!empty($request->input('decision'))) $data_info["identity_number"] = $request->input('identity_number');
            if(!empty($request->input('jobs'))) $data_job["job_id"] = $request->input('jobs');
            

            $data["gender"] = $request->input('gender');
            $data_info["updated_at"] = date("Y-m-d H:i:s");

            $update_info = DB::table('accounts.user_informations')->where('user_id', $id)->update($data_info);

            $update_user = DB::table('accounts.users')->where('id', $id)->update($data);

            $update_userjob = DB::table('accounts.user_jobs')->where('user_id', $id)->update($data_job);

            if($update_user || $update_info || $update_userjob){

                if($status_approval == "reject"){
                    $rejected = DB::table('accounts.reasons')->insertGetId([
                        'user_id' => $id,
                        'by' => Auth::user()->id,
                        'content' => $reason,
                        'subject' => 'Data tidak sesuai',
                        "created_at"=>date("Y-m-d H:i:s"),
                        "updated_at"=>date("Y-m-d H:i:s")
                    ]);

                    $data_log = array(
                        "operator"=> Auth::user()->id,
                        "user"=>$id,
                        "rejection"=>$rejected,
                        "created_at"=> date("Y-m-d H:i:s")
                    );
                }else{
                    $data_log = array(
                        "operator"=> Auth::user()->id,
                        "user"=>$id,
                        "rejection"=>0,
                        "created_at"=> date("Y-m-d H:i:s")
                    );
                }

                $kyc_log = DB::table('backoffice.kyc_log')->insert($data_log);

                $time_end = date("Y-m-d H:i:s");
                $target = $id;

                $data_kyc_access_log = array("user"=> Auth::user()->id, "page"=>url()->current(), "ref"=>url()->current(), "target"=>$target, "content"=>json_encode($data_log), "origin"=> NULL, "type"=> $status_approval.'_kyc', "time_start"=>$time_start, "time_end"=>$time_end, "created"=>date("Y-m-d H:i:s"));
                //insert to log 
                $insertLog = DB::table('log.kyc_access_log')->insert($data_kyc_access_log);
    

                return redirect(route('user-kyc'))->with(['msg_success' => 'Successfully update the user KYC status!']);

            }


        }else{
            $message = "document must included";
            return redirect(route('user-list'))->with(['msg_error' => $message]);
        }

    }


}
 