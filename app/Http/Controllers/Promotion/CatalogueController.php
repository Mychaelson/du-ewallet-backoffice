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

class CatalogueController extends Controller
{
    protected $mod_alias = 'promotion-catalogue';
    protected $mod_active = 'promotion,promotion-catalogue';

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
            'delete_url' => route('catalogue.delete')
        ]);

        $datatables->options([
            'url' => route('catalogue.dt')
        ]);

        $table = $datatables->columns([
            ['field' => 'data_id', 'title' => '#', 'selector' => TRUE, 'sortable' => FALSE, 'width' => 20, 'textAlign' => 'center'],
            ['field' => 'name', 'title' => 'Name', ],
            ['field' => 'description', 'title' => 'Description'],
            ['field' => 'point', 'title' => 'Point'],
            ['field' => 'status', 'title' => 'Status','sortable' => FALSE, 'textAlign' => 'center', 'width' => 100,],
            ['field' => '', 'title' => 'Action', 'width' => 60, 'textAlign' => 'center', 'template' => "return '".view('home.rightButton', ['page' => $this->page, 'mod_alias' => $this->mod_alias, 'dt' => TRUE, 'url' => route('catalogue.detail', ['id' => TRUE])])->render()."'"]
        ]);
        
        $this->viewdata['table'] = $table;
        $this->viewdata['page_title'] = 'Catalogue List';
        return view('Promotion.Catalogue.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $limit = (int) ($request->pagination['perpage'] && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) ($request->pagination['page'] && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $get_data = $this->mission->getQuery($request,['type'=> 1]);
        
        $total_data = $get_data->count();
        $_data = $rowIds = [];
        if($total_data > 0) {
            $no = ($page - 1) * $limit;
            foreach($get_data->limit($limit)->offset($offset)->get() as $key => $val) {
                $_data[] = [
                    'no' => ++$no,
                    'data_id' => $val->id,
					'name' => $val->name,
                    'description' => $val->description,
                    'point' => $val->point,
					'status' => setCatalogueStatusLabel($val->status),
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

        $provider = $this->mission->getProvider();
        $category = $this->mission->getCategory();

        $this->viewdata['category'] = $category;
        $this->viewdata['provider'] = $provider;
        $this->viewdata['page_title'] = 'Catalogue Catalogue';
        return view('Promotion.Catalogue.form', $this->viewdata);
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
        // dd($get_data);

        $this->viewdata['page_title'] = 'Edit Catalogue';
        return view('Promotion.Catalogue.form', $this->viewdata);
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
            'coupon_product' => 'required',
            'point' => 'required|integer',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('catalogue.create'));
        }

        $sess = Auth::user()->id;
        $roles = isset($sess) ? $sess : "";
        $name = strip_tags($request->name);
        $category = strip_tags($request->category);
        $description = strip_tags($request->description);
        $slug = strip_tags($request->slug);
        $terms = strip_tags($request->terms);
        $image[] = strip_tags($request->logo);
        $point = strip_tags($request->point);
        $provider = strip_tags($request->provider);
        $max_coupon = strip_tags($request->max_coupon);
        $coupon_value = strip_tags($request->coupon_value);
        $coupon_product = strip_tags($request->coupon_product);
        $date_from = strip_tags($request->date_from);
        $date_to = strip_tags($request->date_to);
        if (!empty($date_from)) $date_from = gmdate("Y-m-d H:i:s", strtotime($date_from.' 24:00:00'));
        if (!empty($date_to)) $date_to = gmdate("Y-m-d H:i:s", strtotime($date_to));

            $data = [
                'name' => $name,
                'category' => $category,
                'status' => 0, //status draft
                'type' => 1, //type catalogue
                'description' => $description,
                'slug' => $slug,
                'terms' => $terms,
                'images' => json_encode($image),
                'point' => $point,
                'provider_id' => $provider,
                'quantity' => $max_coupon,
                'item_value' => $coupon_value,
                'start_at' => $date_from,
                'end_at' => $date_to,
                'product' => $coupon_product,
                'created_by' => $roles,
                'exchange_date_limit' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            $query = $this->mission->save($data);

        session()->flash('msg_success', 'Create Mission name " '.$name.' " have been saved ');
        return redirect(route('catalogue'));
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
            'coupon_product' => 'required',
            'point' => 'required|integer',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('catalogue.edit',['id' => $id]));
        }

        $sess = Auth::user()->id;
        $roles = isset($sess) ? $sess : "";
        $name = strip_tags($request->name);
        $category = strip_tags($request->category);
        $description = strip_tags($request->description);
        $slug = strip_tags($request->slug);
        $terms = strip_tags($request->terms);
        $image[] = strip_tags($request->logo);
        $point = strip_tags($request->point);
        $provider = strip_tags($request->provider);
        $max_coupon = strip_tags($request->max_coupon);
        $coupon_value = strip_tags($request->coupon_value);
        $coupon_product = strip_tags($request->coupon_product);
        $date_from = strip_tags($request->date_from);
        $date_to = strip_tags($request->date_to);
        if (!empty($date_from)) $date_from = gmdate("Y-m-d H:i:s", strtotime($date_from.' 24:00:00'));
        if (!empty($date_to)) $date_to = gmdate("Y-m-d H:i:s", strtotime($date_to));

            $data = [
                'name' => $name,
                'category' => $category,
                'description' => $description,
                'slug' => $slug,
                'terms' => $terms,
                'images' => json_encode($image),
                'point' => $point,
                'provider_id' => $provider,
                'quantity' => $max_coupon,
                'item_value' => $coupon_value,
                'start_at' => $date_from,
                'end_at' => $date_to,
                'product' => $coupon_product,
                'created_by' => $roles,
                'updated_at' => now()
            ];

            $query = $this->mission->update($data,$request->id);

        session()->flash('msg_success', 'Update Mission name " '.$name.' " have been saved ');
        return redirect(route('catalogue'));

    }

    public function detail($id)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $get_data = $this->mission->getById($id);
        $type = 'catalogue_registration';
        $getKYCLog = $this->mission->getKYCLog($id,$type);
        $sess = Auth::user();
        $roles = isset($sess) ? $sess : "";

        $this->viewdata['getKYCLog'] = $getKYCLog;
        $this->viewdata['roles'] = $roles;
        $this->viewdata['detail'] = $get_data;
        $this->viewdata['page_title'] = 'Detail Cataloge';
        return view('Promotion.Catalogue.detail', $this->viewdata);
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
        $type = "catalogue_registration";
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
                    $message = "update Catalogue success";
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
                    $message = "update Catalogue success";
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

    public function delete(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');
        if(!$request->id) {
            session()->flash('msg_error', 'Invalid ID');
			return redirect(route('catalogue'));
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
                $data_name = 'Banner for ID '.$data->id.' with cataloge name '.$data->name;
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
