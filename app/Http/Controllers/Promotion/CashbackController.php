<?php

namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Library\Services\Datatables;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Repositories\Promotion\CashbackRepository;
use Illuminate\Support\Facades\Auth;

class CashbackController extends Controller
{
    protected $mod_alias = 'promotion-cashback';
    protected $mod_active = 'promotion,promotion-cashback';

    public function __construct(
        private CashbackRepository $cashback,
    ) {
        parent::__construct();
    }

    public function index(Datatables $datatables, Request $request)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $datatables->config([
            'roles' => [
                'delete' => $this->page->mod_action_roles($this->mod_alias, 'drop'),
            ],
            'delete_url' => route('cashback.delete')
        ]);

        $datatables->options([
            'url' => route('cashback.dt')
        ]);

        $table = $datatables->columns([
            ['field' => 'data_id', 'title' => '#', 'selector' => TRUE, 'sortable' => FALSE, 'width' => 20, 'textAlign' => 'center'],
            ['field' => 'name', 'title' => 'Name', ],
            ['field' => 'status', 'title' => 'Status','sortable' => FALSE, 'textAlign' => 'center', 'width' => 100,],
            ['field' => 'period', 'title' => 'Period'],
            ['field' => 'budget', 'title' => 'Budget'],
            ['field' => '', 'title' => 'Action', 'width' => 60, 'textAlign' => 'center', 'template' => "return '".view('home.rightButton', ['page' => $this->page, 'mod_alias' => $this->mod_alias, 'dt' => TRUE, 'url' => route('cashback.detail', ['id' => TRUE])])->render()."'"]
        ]);
        
        $this->viewdata['table'] = $table;
        $this->viewdata['page_title'] = 'Cachback List';
        return view('Promotion.Casback.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $limit = (int) ($request->pagination['perpage'] && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) ($request->pagination['page'] && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $get_data = $this->cashback->getQuery($request);

        
        $total_data = $get_data->count();
        $_data = $rowIds = [];
        if($total_data > 0) {
            $no = ($page - 1) * $limit;
            foreach($get_data->limit($limit)->offset($offset)->get() as $key => $val) {
                $_data[] = [
                    'no' => ++$no,
                    'data_id' => $val->id,
					'name' => $val->name,
					'status' => setPromotionStatus($val->status),
					'budget' => $val->budget,
                    'period' => $val->max_amount_claim_user,
					'created' => date('M d, Y', strtotime($val->created_at))
                ];
                
                $rowIds[] = $val->id;
            }
        }
        return [
            'meta' => [
                'page' => $page,
                'pages' => ceil($total_data / $limit),
                'perpage' => $limit,
                'total' => $total_data,
                'sort' => $request->sort['sort'] ?? 'asc',
                'field' => $request->sort['field'] ?? 'created_at',
                'rowIds' => $rowIds
            ],
            'data' => $_data
        ];
    }
    public function create()
    {
        $this->page->blocked_page($this->mod_alias, 'create');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'Create Cashback';
        return view('Promotion.Casback.form', $this->viewdata);
    }

    public function save(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'promotion_name' => 'required',
            'terms' => 'required',
            'budget' => 'required',
            'total_promotion' => 'required',
            'claim_day' => 'required',
            'claim_usr_day' => 'required',            
            'claim_transaction' => 'required',
            'claim_usr_period' => 'required',
            'claim_user_month' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('cashback.create'));
        }

        $sess = Auth::user()->id;
        $roles = isset($sess) ? $sess : "";
        $name = strip_tags($request->promotion_name);
        $terms = strip_tags($request->terms);
        $budget = strip_tags($request->budget);
        $total_promotion = strip_tags($request->total_promotion);
        $percnt_yumisok = strip_tags($request->percnt_yamisok);
        $percnt_merchant = strip_tags($request->percnt_merchant);
        $claim_day = strip_tags($request->claim_day);
        $claim_usr_day = strip_tags($request->claim_usr_day);
        $claim_transaction = strip_tags($request->claim_transaction);
        $claim_usr_period = strip_tags($request->claim_usr_period);
        $claim_usr_month = strip_tags($request->claim_user_month);
        $date_from = strip_tags($request->date_from);
        $date_to = strip_tags($request->date_to);
        if( $date_from > $date_to){
            session()->flash('msg_error', "date from / start tidak boleh lebih kecil dari finish");
            return redirect(route('cashback.create'));
        }
        if (!empty($date_from)) $date_from = date("Y-m-d H:i:s", strtotime($date_from));
        if (!empty($date_to)) $date_to = date("Y-m-d H:i:s", strtotime($date_to));

            $data = [
                'merchant' => 1,
                'created_by' => $roles,
                'name' => $name,
                'budget' => (double)$budget,
                'claim_p_day' => (int) $claim_day,
                'claim_p_day_user' => (int) $claim_usr_day,
                'max_claim_p_month_user' =>(int) $claim_usr_month,
                'percentage' =>(int) $total_promotion,
                'merch_fund_percentage' =>(int) $percnt_merchant,
                'promo_fund_percentage' =>(int) $percnt_yumisok,
                'max_amount' =>(double) $claim_transaction,
                'max_amount_claim_user' =>(double) $claim_usr_period,
                'start_date' => $date_from,
                'end_date' => $date_to,
                'terms' => $terms,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];

             // proses insert to DB 
        $insert = $this->cashback->save($data);

        session()->flash('msg_success', 'Create Cashback title " '.$name.' " have been saved ');
        return redirect(route('cashback'));

    }

    public function edit($id)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $get_data = $this->cashback->getById($id);

        $this->viewdata['detail'] = $get_data;
        $this->viewdata['page_title'] = 'Edit Cashback';
        return view('Promotion.Casback.form', $this->viewdata);
    }
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'promotion_name' => 'required',
            'terms' => 'required',
            'budget' => 'required',
            'total_promotion' => 'required',
            'claim_day' => 'required',
            'claim_usr_day' => 'required',            
            'claim_transaction' => 'required',
            'claim_usr_period' => 'required',
            'claim_user_month' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('cashback.create'));
        }

        $sess = Auth::user()->id;
        $roles = isset($sess) ? $sess : "";
        $name = strip_tags($request->promotion_name);
        $terms = strip_tags($request->terms);
        $budget = strip_tags($request->budget);
        $total_promotion = strip_tags($request->total_promotion);
        $percnt_yumisok = strip_tags($request->percnt_yamisok);
        $percnt_merchant = strip_tags($request->percnt_merchant);
        $claim_day = strip_tags($request->claim_day);
        $claim_usr_day = strip_tags($request->claim_usr_day);
        $claim_transaction = strip_tags($request->claim_transaction);
        $claim_usr_period = strip_tags($request->claim_usr_period);
        $claim_usr_month = strip_tags($request->claim_user_month);
        $date_from = strip_tags($request->date_from);
        $date_to = strip_tags($request->date_to);
        if( $date_from > $date_to){
            session()->flash('msg_error', "date from / start tidak boleh lebih kecil dari finish");
            return redirect(route('cashback.create'));
        }
        if (!empty($date_from)) $date_from = date("Y-m-d H:i:s", strtotime($date_from));
        if (!empty($date_to)) $date_to = date("Y-m-d H:i:s", strtotime($date_to));

            $data = [
                'merchant' => 1,
                'created_by' => $roles,
                'name' => $name,
                'budget' => (double)$budget,
                'claim_p_day' => (int) $claim_day,
                'claim_p_day_user' => (int) $claim_usr_day,
                'max_claim_p_month_user' =>(int) $claim_usr_month,
                'percentage' =>(int) $total_promotion,
                'merch_fund_percentage' =>(int) $percnt_merchant,
                'promo_fund_percentage' =>(int) $percnt_yumisok,
                'max_amount' =>(double) $claim_transaction,
                'max_amount_claim_user' =>(double) $claim_usr_period,
                'start_date' => $date_from,
                'end_date' => $date_to,
                'terms' => $terms,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];

             // proses insert to DB 
        $insert = $this->cashback->update($data,$request->id);

        session()->flash('msg_success', 'Update Cashback title " '.$name.' " have been saved ');
        return redirect(route('cashback'));
    }

    public function detail($id)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $get_data = $this->cashback->getById($id);
        $getCashback = $this->cashback->getCashback(['promotion_id'=>$id]);
        $type = 'cashback_registration';
        $getKYCLog = $this->cashback->getKYCLog($id,$type);
        $sess = Auth::user();
        $roles = isset($sess) ? $sess : "";

        $this->viewdata['getCashback'] = $getCashback;
        $this->viewdata['getKYCLog'] = $getKYCLog;
        $this->viewdata['roles'] = $roles;
        $this->viewdata['detail'] = $get_data;
        $this->viewdata['page_title'] = 'detail Cashback';
        return view('Promotion.Casback.detail', $this->viewdata);
    }

    public function aprroveDetail(Request $request)
    {
        
        $validated = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
            'staff' => 'required',
            'subject' => 'required',
            'reason' => 'required',
        ]);

        if ($validated->fails()) {

            $message = $validated->messages()->first();
            $data = [
                'status' => false,
                'message' => $message,
            ];
            return response()->json($data);
        }

        $sess = Auth::user();
        $id = strip_tags($request->id);
        $status_kyc = strip_tags($request->status);
        $staff = strip_tags($request->staff);
        $subject = strip_tags($request->subject);
        $reason = strip_tags($request->reason);
        $time_start = date("Y-m-d H:i:s");
        $admin = isset($sess->id) ? $sess->id : 0;


            if($status_kyc == "1"){
                $data = [ "status" => $status_kyc ];
                $insert = $this->cashback->update($data,$id);

                if($insert) {
                    $statusCode = true;
                    $message = "update cashback success";
                    //add activity log
                    $datalog = [
                        "user_id" => $id,
                        "operator" => $admin,
                        "staff" => $staff,
                        "type" => 'cashback_registration',
                        "subject" => $subject,
                        "reason" => $reason,
                        "status" => $status_kyc
                    ];

                    $datainsert = [
                        "user"=>$id,
                        "page"=>current_url(),
                        "ref"=>current_url(),
                        "target"=>$id,
                        "content"=>json_encode($datalog),
                        "origin"=>null,
                        "type"=>"cashback_registration",
                        "time_start"=>$time_start,
                        "time_end"=>date("Y-m-d H:i:s"),
                        "created"=>date("Y-m-d H:i:s")
                    ];
                    $insert = $this->cashback->acction_log($datainsert);

                }else {
                    $statusCode = false;
                    $message = "update cashback error";
                }
            }else {
                $data = [ "status" => $status_kyc ];
                $insert = $this->cashback->update($data,$id);

                if($insert) {
                    $statusCode = true;
                    $message = "update cashback success";
                    //add activity log
                    $datalog = [
                        "user_id" => $id,
                        "operator" => $admin,
                        "type" => 'cashback_registration',
                        "subject" => $subject,
                        "reason" => $reason,
                        "status" => $status_kyc
                    ];
                    $datainsert = [
                        "user"=>$id,
                        "page"=>current_url(),
                        "ref"=>current_url(),
                        "target"=>$id,
                        "content"=>json_encode($datalog),
                        "origin"=>null,
                        "type"=>"cashback_registration",
                        "time_start"=>$time_start,
                        "time_end"=>date("Y-m-d H:i:s"),
                        "created"=>date("Y-m-d H:i:s")
                    ];
                    $insert = $this->cashback->acction_log($datainsert);
                }else {
                    $statusCode = false;
                    $message = "update cashback error";
                }
            }

        $data = [
            'status' => $statusCode,
            'message' => $message,
        ];

        return response()->json($data);
    }

    public function delete(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');

        if(!$request->id) {
            session()->flash('msg_error', 'Invalid ID');
			return redirect(route('cashback'));
        }
        
        $count = 0;
        foreach($request->id as $val)
        {
            $data = $this->cashback->getById($val);
            if(!$data) {
                session()->flash('msg_error', 'Data with ID : '.$val.' not found!');
                return response()->json([
                    'status' => false,
                    'message' => 'Data with ID : '.$val.' not found!'
                ]);
            }

            // proses delete DB
            $delete = $this->cashback->deleteById($val);
            if($delete) {
                $data_name = 'Cashback for ID '.$data->id.' with Name :'.$data->name;
                $count = $count + 1;	
            }
        }

        if($count == 1) {
            session()->flash('msg_success', $data_name.' successfully removed');
            return response()->json([
                'status' => TRUE,
                'message' => $data_name.' data successfully removed'
            ]);
        } else {
            session()->flash('msg_success', $count.' data successfully removed');	
            return response()->json([
                'status' => TRUE,
                'message' => $count.' data successfully removed'
            ]);
        }
    }

    public function aprove(Request $request)
    {
        dd($request->all());
    }
}
