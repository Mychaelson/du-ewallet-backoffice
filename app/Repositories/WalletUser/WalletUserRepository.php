<?php

namespace App\Repositories\WalletUser;


use Illuminate\Support\Facades\DB;


class WalletUserRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    public function kyc_log($query){
        $data = DB::table('log.kyc_access_log')
        ->leftjoin('accounts.users as by_name','by_name.id','=','log.kyc_access_log.user',)
        ->leftjoin('accounts.users as by_target','by_target.id','=','log.kyc_access_log.target')
        ->select('by_name.name as name','by_target.name as target_name',
        'log.kyc_access_log.type','log.kyc_access_log.id',
        'log.kyc_access_log.created','log.kyc_access_log.user',
        'log.kyc_access_log.target as target')
        ->orderBy('log.kyc_access_log.created','desc');
        return $data;
    }

    function getJobs() {

        $jobs = DB::table('accounts.jobs')->get();

        return $jobs;
    }


    function getGroups() {

        $groups = DB::table('accounts.groups')->get();

        return $groups;
    }

    function getBlacklisted() {

        $groups = DB::table('accounts.blacklisted')->get();

        return $groups;
    }

    function getGroupList() {

        $groups = DB::table('accounts.user_groups');

        if(isset($query['searchNickname']))
        {
            $groups->whereRaw("(user_groups.name = ".$query['searchNickname'].")");
        }

        return $groups;
    }

    function getGroupById($id) {

        $groups = DB::table('accounts.user_groups')->where('id',$id)->first();


        return $groups;
    }

    function getUserList($query) {

        $get_data = DB::table('accounts.users');

        if(isset($query['date_from'])) {
            $get_data->where('accounts.users.'.$query['filter_date_by'], '>=', $query['date_from'] );
        }

        if(isset($query['date_to'])) {
            $get_data->where('accounts.users.'.$query['filter_date_by'], '<=', $query['date_to'] );
        }

        if(isset($query['user_type'])) {
            $get_data->where('accounts.users.user_type', '=', $query['user_type'] );
        }

        // if(isset($query['group']))
        // {
        //     $get_data->whereRaw("(users.jobs = ".$query['operator'].")");
        // }


        // if(isset($query['operator']))
        // {
        //     $get_data->whereRaw("(users.operator_id = ".$query['operator'].")");
        // }

        return $get_data;
    }

    function getUserFromId($id) {

        $get_data = DB::table('accounts.users')
        ->where('users.id', $id)
        ->select(
            'users.id',
            'users.username',
            'users.avatar',
            'users.verified',
            'users.name',
            'users.nickname',
            'users.email',
            'users.main_device',
            'users.main_device_name',
            'users.phone',
            'users.whatsapp',
            'users.status',
            'users.place_of_birth',
            'users.date_of_birth',
            'users.gender',
            'users.user_type',
            'users.timezone',
            'users.watch_status',
            'users.locale',
            'users.group_id',
            'users.created_at',
            'users.updated_at',
            'users.date_activated',
            'users.last_login',
        )->first();

        return $get_data;
    }

    function getChartData($type='register', $date1='', $date2=''){
        $column = ($type=='login') ? "user_id" : "id";
        $tablez = ($type=='login') ? "public.oauth_access_tokens" : "accounts.users";
        $wheredate = "";
        $wheresql = array();
        // if(!empty($date1) || !empty($date2)){
        //                 if(!empty($date1) && !empty($date2)){
        //                     $wheredate = "AND DATE(created_at) BETWEEN ? AND ?";
        //                     $wheresql = array($date1, $date2);
        //                 }else{
        //                         if(!empty($date1) && empty($date2)){
        //                             $wheredate = "AND DATE(created_at) = ?";
        //                             $wheresql = array($date1);
        //                         }
        //                         elseif(empty($date1) && !empty($date2)){
        //                             $wheredate = "AND DATE(created_at) = ?";
        //                             $wheresql = array($date2);
        //                         }
        //                 }
        // }
        $whereas = ($type == 'login') ? "revoked = false" : "DATE(created_at) <= DATE(NOW())";
        $sql = "SELECT DATE(created_at) as tanggal, COUNT($column) as total_user FROM $tablez WHERE $whereas $wheredate GROUP BY DATE(created_at) ORDER BY tanggal DESC";
        if(empty($wheredate)){
            $sql .= " LIMIT 5";
        }
        //checking for query sql
        if(!empty($wheresql)){
            $query = DB::table($tablez)->selectRaw("SELECT DATE(created_at) as tanggal, COUNT($column) as total_user")->whereRaw($wheresql)->get();
        }else{
            $query = DB::select($sql);
        }

        if($type=='login'){
            if($query){
                foreach($query as $dval){
                        $dataUser = array();
                        $outh = DB::table('public.oauth_access_tokens')->select('user_id')->where('created_at', $dval->tanggal)->get();
                        if($outh){
                            foreach($outh as $col){
                                if(!empty($col->user_id)) $dataUser[] = $col->user_id;
                            }
                            $dval->user_id = $dataUser;
                        }
                        $userdata[] = $dval;
                }
                return $userdata;
            }
        }else{
            if($query){
                foreach($query as $dval){
                        $dataUser = array();
                        $usrdv = DB::table('accounts.users')->select('id')->where('created_at', $dval->tanggal)->get();
                        if($usrdv ){
                            foreach($usrdv as $col){
                                if(!empty($col->id)) $dataUser[] = $col->id;
                            }
                            $dval->user_id = $dataUser;
                        }
                        $userdata[] = $dval;
                }
                return $userdata;
            }
        }
    }

    function getUserJobsFromId($id) {

        $get_data = DB::table('accounts.user_jobs')
        ->join('accounts.jobs', 'jobs.id', '=', 'user_jobs.job_id')
        ->where('user_jobs.user_id', $id)
        ->selectRaw(
            "jobs.id as id, jobs.name, jobs.type"
        )->get();

        return $get_data;
    }

    function getUserDeviceFromId($id) {

        $get_data = DB::table('accounts.user_devices')
        ->where('user_devices.user_id', $id)
        ->selectRaw(
            "id, device_name, imei, location, updated_at"
        )->orderBy('created_at', 'desc')->get();

        return $get_data;
    }

    function getUserConnectionFromId($id) {

        $get_data = DB::table('accounts.connection_networks')
        ->where('connection_networks.user_id', $id)
        ->selectRaw(
            "id, type, provider, ip, created_at"
        )->orderBy('created_at', 'desc')->get();

        return $get_data;
    }


    function getUserAddressFromId($id) {

        $get_data = DB::table('accounts.user_address')
        ->join('accounts.provinces', 'provinces.id', '=', 'user_address.province_id')
        ->join('accounts.cities', 'cities.id', '=', 'user_address.city_id')
        ->join('accounts.subdistricts', 'subdistricts.id', '=', 'user_address.subdistrict_id')
        ->join('accounts.villages', 'villages.id', '=', 'user_address.village_id')
        ->where('user_address.user_id', $id)
        ->selectRaw(
            "user_address.id, user_id, user_address.name, phone, is_main, address, provinces.name as province_name, cities.name as city_name, subdistricts.name as subdistrict_name, postal_code, villages.name as village_name, created_at, updated_at"
        )->get();

        return $get_data;
    }

    function getUserPayrollFromId($id) {

        $get_data = DB::table('wallet.wallets')
        ->where('wallets.user_id', $id)
        ->where('wallets.type', 2)
        ->selectRaw(
            "wallets.id as id, currency, wallets.balance as balance, ncash, reversal, (lock_nv_rdm + lock_nv_crt) as nvoucher, hold"
        )->get();

        return $get_data;
    }

    function getUserEmoneyFromId($id) {

        $get_data = DB::table('wallet.wallets')
        ->where('wallets.user_id', $id)
        ->where('wallets.type', 1)
        ->selectRaw(
            "wallets.id as id, currency, wallets.balance as balance, ncash, reversal, (lock_nv_rdm + lock_nv_crt) as nvoucher, hold"
        )->get();

        return $get_data;
    }

    function getUserActivityFromId($id) {

        $get_data = DB::table('track.activities')
        ->where('activities.user_id', $id)
        ->selectRaw(
            "activity_screen, open_time, leave_time, next_activity_screen, created_at, updated_at"
        )->orderByRaw('open_time DESC, leave_time DESC')->get();

        return $get_data;
    }

    function getUserTotalLoginFromId($id) {

        $get_data = DB::table('public.oauth_access_tokens')
        ->where('oauth_access_tokens.user_id', $id)
        ->selectRaw(
            "COUNT(id) as total_login"
        )->first();

        return $get_data;
    }

    function getUserKYCHistoryFromId($id) {

        $get_data = DB::table('log.kyc_access_log')
        ->where('kyc_access_log.target', $id)
        ->whereIn('kyc_access_log.type', ['unkyc','approve_kyc','reject_kyc','requestEdit_kyc','unkyc_account'])
        ->selectRaw(
            "id, user, target, type, content, created"
        )->orderBy('created', 'desc')->get();

        return $get_data;
    }

    function getUserBanHistoryFromId($id) {

        $get_data = DB::table('log.kyc_access_log')
        ->where('kyc_access_log.target', $id)
        ->whereIn('kyc_access_log.type', ['unban_account','ban_account'])
        ->selectRaw(
            "id, user, origin, content, type, created"
        )->orderBy('created', 'desc')->get();

        return $get_data;
    }

    function getUserLogTypeFromId($id,$type) {

        $get_data = DB::table('log.kyc_access_log')
        ->where('kyc_access_log.target', $id)
        ->whereIn('kyc_access_log.type', $type)
        ->selectRaw(
            "id, user, origin, content, type, created"
        )->orderBy('created', 'desc')->get();

        return $get_data;
    }

    function getUserMediaFromId($id, $page=null) {

        $limit = 6;

        $page = (!empty($page) && $page > 0) ? $page : 1;

        $get_data = DB::table('accounts.media')
        ->where('media.user_id', $id)
        ->paginate();

        $total = $get_data->total();

        $output = array(
            "data" => $get_data,
            "recordsTotal" => $total,
            "recordsFiltered" => 6,
            "pagination" => ceil($total / $limit),
            "previous" => $page - 1,
            "next" => $page + 1,
            "active" => $page
        );

        return $output;
    }

    function getUserWrongPINHistoryFromId($id) {

        $get_data = DB::table('accounts.password_wrong_histories')
        ->where('password_wrong_histories.user_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        return $get_data;
    }

    function getUserChangePINHistoryFromId($id) {

        $get_data = DB::table('accounts.password_change_histories')
        ->where('password_change_histories.user_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        return $get_data;
    }

    public function ListOfUser($phone)
    {
        $data = DB::table('accounts.users')
                    ->orderby('name','asc')
                    ->select('phone','name','id')
        ;

        if (isset($phone)) {
            $data->where('phone', 'like', '%' .$phone. '%');
        }

        return $data->limit(5)->get();
    }

    public function list_va($id){
        $data = DB::table('accounts.banks')
                ->select('code','name')
                ->get();
                return $data;

    }

    public function getLatestTransaction($id){
        $get = DB::table('wallet.wallets')
                ->where('user_id',$id)
                ->get();

        $data = DB::table('wallet.wallet_transactions as wt')
        ->leftjoin('wallet.wallets as w', 'w.id', '=', 'wt.wallet_id')
        ->leftjoin('accounts.users as u', 'u.id', '=', 'w.user_id')
        ->where('w.user_id',$id)
        ->where('wt.wallet_id','=','w.id')
        ->select('wt.amount','wt.transaction_type','w.user_id','w.id as wid')
        ->get();

        return  $data;
    }
}
