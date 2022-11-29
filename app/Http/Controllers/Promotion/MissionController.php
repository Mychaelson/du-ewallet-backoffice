<?php

namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Library\Services\Datatables;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Repositories\Promotion\MissionRepository;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    protected $mod_alias = 'promotion-mission';
    protected $mod_active = 'promotion,promotion-mission';

    public function __construct(
        private MissionRepository $mission,
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
            'delete_url' => route('mission.delete')
        ]);

        $datatables->options([
            'url' => route('mission.dt')
        ]);

        $table = $datatables->columns([
            ['field' => 'data_id', 'title' => '#', 'selector' => TRUE, 'sortable' => FALSE, 'width' => 20, 'textAlign' => 'center'],
            ['field' => 'name', 'title' => 'Name', ],
            ['field' => 'created_by', 'title' => 'Summary'],
            ['field' => 'description', 'title' => 'Description'],
            ['field' => 'status', 'title' => 'Status','sortable' => FALSE, 'textAlign' => 'center', 'width' => 100,],
            ['field' => '', 'title' => 'Action', 'width' => 60, 'textAlign' => 'center', 'template' => "return '".view('home.rightButton', ['page' => $this->page, 'mod_alias' => $this->mod_alias, 'dt' => TRUE, 'url' => route('mission.detail', ['id' => TRUE])])->render()."'"]
        ]);
        
        $this->viewdata['table'] = $table;
        $this->viewdata['page_title'] = 'Misiion List';
        return view('Promotion.Mission.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $limit = (int) ($request->pagination['perpage'] && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) ($request->pagination['page'] && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $get_data = $this->mission->getQuery($request,['type'=>2]);
        
        $total_data = $get_data->count();
        $_data = $rowIds = [];
        if($total_data > 0) {
            $no = ($page - 1) * $limit;
            foreach($get_data->limit($limit)->offset($offset)->get() as $key => $val) {
                $_data[] = [
                    'no' => ++$no,
                    'data_id' => $val->id,
					'name' => $val->name,
                    'created_by' => $val->created_by,
                    'description' => $val->description,
					'status' => setMissionStatus($val->status),
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

        $provider = $this->mission->getProvider();
        $category = $this->mission->getCategory();

        $this->viewdata['category'] = $category;
        $this->viewdata['provider'] = $provider;
        $this->viewdata['page_title'] = 'Misiion Cashback';
        return view('Promotion.Mission.form', $this->viewdata);
    }

    public function save(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'provider' => 'required',
            'category' => 'required',            
            'terms' => 'required',
            'max_coupon' => 'required|integer',
            'coupon_value' => 'required|integer',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('mission.create'));
        }

        $sess = Auth::user()->id;
        $roles = isset($sess) ? $sess : "";
        $name = strip_tags($request->name);
        $image[] = strip_tags($request->logo);
        $slug = strip_tags($request->slug);
        $description = strip_tags($request->description);
        $provider = strip_tags($request->provider);
        $category = strip_tags($request->category);
        $terms = strip_tags($request->terms);
        $max_coupon = strip_tags($request->max_coupon);
        $coupon_value = strip_tags($request->coupon_value);
        $date_from = strip_tags($request->date_from);
        $date_to = strip_tags($request->date_to);
        if (!empty($date_from)) $date_from = date("Y-m-d H:i:s", strtotime($date_from));
        if (!empty($date_to)) $date_to = date("Y-m-d H:i:s", strtotime($date_to));

            $data = [
                'name' => $name,
                'description' => $description,
                'terms' => $terms,
                'quantity' => $max_coupon,
                'item_value' => $coupon_value,
                'provider_id' => $provider,
                'start_at' => $date_from,
                'end_at' => $date_to,
                'category' => $category,
                'images' => json_encode($image),
                'slug' => $slug,
                'status' => 0, //status draft
                'type' => 2, //type mission
                'product' => 0,
                'point' => 0,
                'created_by' => $roles,
                'exchange_date_limit' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            // proses insert to DB 
            $insert = $this->mission->save($data);

        session()->flash('msg_success', 'Create Mission name " '.$name.' " have been saved ');
        return redirect(route('mission'));
    }

    public function edit($id)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $get_data = $this->mission->getById($id);
        $provider = $this->mission->getProvider();
        $category = $this->mission->getCategory();

        $this->viewdata['category'] = $category;
        $this->viewdata['provider'] = $provider;
        $this->viewdata['detail'] = $get_data;
        $this->viewdata['page_title'] = 'Edit Cashback';
        return view('Promotion.Mission.form', $this->viewdata);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'provider' => 'required',
            'category' => 'required',            
            'terms' => 'required',
            'max_coupon' => 'required|integer',
            'coupon_value' => 'required|integer',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('mission.edit',['id' => $id]));
        }

        $sess = Auth::user()->id;
        $roles = isset($sess) ? $sess : "";
        $id = strip_tags($request->id);
        $name = strip_tags($request->name);
        $image[] = strip_tags($request->logo);
        $slug = strip_tags($request->slug);
        $description = strip_tags($request->description);
        $provider = strip_tags($request->provider);
        $category = strip_tags($request->category);
        $terms = strip_tags($request->terms);
        $max_coupon = strip_tags($request->max_coupon);
        $coupon_value = strip_tags($request->coupon_value);
        $date_from = strip_tags($request->date_from);
        $date_to = strip_tags($request->date_to);
        if (!empty($date_from)) $date_from = date("Y-m-d H:i:s", strtotime($date_from));
        if (!empty($date_to)) $date_to = date("Y-m-d H:i:s", strtotime($date_to));

            $data = [
                'name' => $name,
                'description' => $description,
                'terms' => $terms,
                'quantity' => $max_coupon,
                'item_value' => $coupon_value,
                'provider_id' => $provider,
                'start_at' => $date_from,
                'end_at' => $date_to,
                'category' => $category,
                'images' => json_encode($image),
                'slug' => $slug,
                'updated_at' => now()
            ];

            $insert = $this->mission->update($data,$request->id);

        session()->flash('msg_success', 'Update Mission name " '.$name.' " have been saved ');
        return redirect(route('mission'));
         
    }

    public function detail($id)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $get_data = $this->mission->getById($id);
        $tot_mission =$this->mission->getTotalMission(['catalogue_id' => $id],'id');
        $mission =$this->mission->getTotalMA(['catalogue_id' => $id],'mission');
        $coupon_id =$this->mission->getCompleteMission(['catalogue_id' => $id]);
        // $card_id =$this->mission->getTotalMA(['catalogue_id' => $id],'card_id');
        
        $list_mission = $this->mission->getlist_mission($id);
        $type = 'mission_registration';
        $getKYCLog = $this->mission->getKYCLog($id,$type);
        $sess = Auth::user();
        $roles = isset($sess) ? $sess : "";

        $this->viewdata['list_mission'] = $list_mission;
        $this->viewdata['getKYCLog'] = $getKYCLog;

        $this->viewdata['tot_mission'] = $tot_mission;
        $this->viewdata['user_join'] = $mission;
        $this->viewdata['complete_mission'] = $coupon_id;
        $this->viewdata['roles'] = $roles;
        $this->viewdata['detail'] = $get_data;
        $this->viewdata['page_title'] = 'detail Mission';
        return view('Promotion.Mission.detail', $this->viewdata);
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
        $type = "mission_registration";
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
                $insert = $this->mission->update($data,$id);

                if($insert) {
                    $statusCode = true;
                    $message = "update mission success";
                    //add activity log
                    $datalog = [
                        "user_id" => $id,
                        "operator" => $admin,
                        "staff" => $staff,
                        "type" => $type,
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
                        "type"=>$type,
                        "time_start"=>$time_start,
                        "time_end"=>date("Y-m-d H:i:s"),
                        "created"=>date("Y-m-d H:i:s")
                    ];
                    $insert = $this->mission->acction_log($datainsert);

                }else {
                    $statusCode = false;
                    $message = "update mission error";
                }
            }else {
                $data = [ "status" => $status_kyc ];
                $insert = $this->mission->update($data,$id);

                if($insert) {
                    $statusCode = true;
                    $message = "update mission success";
                    //add activity log
                    $datalog = [
                        "user_id" => $id,
                        "operator" => $admin,
                        "type" => $type,
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
                        "type"=>$type,
                        "time_start"=>$time_start,
                        "time_end"=>date("Y-m-d H:i:s"),
                        "created"=>date("Y-m-d H:i:s")
                    ];
                    $insert = $this->mission->acction_log($datainsert);
                }else {
                    $statusCode = false;
                    $message = "update mission error";
                }
            }

        $data = [
            'status' => $statusCode,
            'message' => $message,
        ];

        return response()->json($data);
    }

    public function addlistmission(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'caid' => 'required',
            'description' => 'required',
            'mission_count_needed' => 'required|integer',
            'activity' => 'required',
            'type' => 'required',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('mission.detail',['id' => $request->caid]));
        }

        $caid = strip_tags($request->caid);
        $description = strip_tags($request->description);
        $mission_count_needed = strip_tags($request->mission_count_needed);
        $activity = strip_tags($request->activity);
        $product_id = strip_tags($request->product_id);
        $type = strip_tags($request->type);

            $data = [
                'catalogue_id' => $caid,
                'mission_type' => $type,
                'description' => $description,
                'mission_count_needed' => $mission_count_needed,
                'created_at' => now(),
                'updated_at' => now()
            ];
            if($type == 1) $data['mission_target'] = $activity;
            if($type == 2) $data['mission_target'] = $product_id;

            $query = $this->mission->insertM($data);
            
            session()->flash('msg_success', 'Add list Missions have been saved ');
            return redirect(route('mission.detail',['id' => $request->caid]));

    }

    public function editmission($id)
    {
        $get_data = $this->mission->getMById($id)->first();
        $data = [
            'status' => true,
            'data' => $get_data,
        ];
        return response()->json($data);
    }

    public function updatemission(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'caid' => 'required',
            'id' => 'required',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('mission.detail',['id' => $request->caid]));
        }
        
        $id = strip_tags($request->id);
        $caid = strip_tags($request->caid);
        $description = strip_tags($request->description);
        $mission_count_needed = strip_tags($request->mission_count_needed);
        $activity = strip_tags($request->activity);
        $product_id = strip_tags($request->product_id);
        $type = strip_tags($request->type);

        $data = [
            'catalogue_id' => $caid,
            'mission_type' => $type,
            'description' => $description,
            'mission_count_needed' => $mission_count_needed,
            'updated_at' => now()
        ];
        if($type == 1) $data['mission_target'] = $activity;
        if($type == 2) $data['mission_target'] = $product_id;

        $query = $this->mission->updateM($id,$data);
        
        session()->flash('msg_success', 'Update list Missions have been saved ');
        return redirect(route('mission.detail',['id' => $request->caid]));
    }

    public function deletemission(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');

        if(!$request->id) {
            session()->flash('msg_error', 'Invalid ID');
			return redirect(route('mission'));
        }
        
        $data = $this->mission->getMById($request->id);
        if(!$data) {
            session()->flash('msg_error', 'Data with ID : '.$request->id.' not found!');
            return response()->json([
                'status' => false,
                'message' => 'Data with ID : '.$request->id.' not found!'
            ]);
        }


        // proses delete DB
        $delete = $this->mission->deleteM($request->id);
        if($delete) {
            $data_name = 'List Mission for ID '.$data->id.' description : '.$data->description;
            $count = $count + 1;	
        }

        session()->flash('msg_success', $data_name.' successfully removed');
        return response()->json([
            'status' => TRUE,
            'message' => $data_name.' data successfully removed'
        ]);
    }

    public function delete(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');

        if(!$request->id) {
            session()->flash('msg_error', 'Invalid ID');
			return redirect(route('mission'));
        }
        
        $count = 0;
        foreach($request->id as $val)
        {
            $data = $this->mission->getById($val);
            if(!$data) {
                session()->flash('msg_error', 'Data with ID : '.$val.' not found!');
                return response()->json([
                    'status' => false,
                    'message' => 'Data with ID : '.$val.' not found!'
                ]);
            }

            // proses delete DB
            $delete = $this->mission->delete($val);
            if($delete) {
                $data_name = 'Mission for ID '.$data->id.' with catalogue name '.$data->name;
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
   
}
