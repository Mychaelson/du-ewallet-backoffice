<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Library\Services\Datatables;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Repositories\Banner\BannerRepository;

class BannerController extends Controller
{
    protected $mod_alias = 'banner';
    protected $mod_active = 'Banner,banner';

    public function __construct(
        private BannerRepository $banner,
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
            'delete_url' => route('banner.delete')
        ]);

        $datatables->options([
            'url' => route('banner.dt')
        ]);

        $table = $datatables->columns([
            ['field' => 'data_id', 'title' => '#', 'selector' => TRUE, 'sortable' => FALSE, 'width' => 20, 'textAlign' => 'center'],
            ['field' => 'title', 'title' => 'Title', ],
            ['field' => 'activity', 'title' => 'Activity'],
            ['field' => 'status', 'title' => 'Status', 'template' => "var status = {
                2: {'title': ' active', 'class': ' label-success',},
                1: {'title': ' hide', 'class': ' label-warning',},
                0: {'title': ' deleted', 'class': ' label-danger',}
            };
            return '<span class=\"label font-weight-bold label-lg ' + status[data.status].class + ' label-inline \">' + status[data.status].title + '</span>';
            "],
            ['field' => 'created', 'title' => 'Created'],
            ['field' => '', 'title' => 'Action', 'width' => 60, 'textAlign' => 'center', 'template' => "return '".view('home.editButton', ['page' => $this->page, 'mod_alias' => $this->mod_alias, 'dt' => TRUE, 'url' => route('banner.edit', ['id' => TRUE])])->render()."'"]
        ]);
        
        $this->viewdata['table'] = $table;
        $this->viewdata['page_title'] = 'Banner List';
        return view('Banner.content', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $limit = (int) ($request->pagination['perpage'] && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) ($request->pagination['page'] && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;
    
        $get_data = $this->banner->getBannerQuery($request);
        
        $total_data = $get_data->count();
        $_data = $rowIds = [];
        if($total_data > 0) {
            $no = ($page - 1) * $limit;
            foreach($get_data->limit($limit)->offset($offset)->get() as $key => $val) {
                $_data[] = [
                    'no' => ++$no,
                    'data_id' => $val->id,
					'title' => $val->title,
                    'activity' => $val->activity,
					'status' => $val->status,
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

        $activity = $this->banner->getActivityQuery();
        
        $this->viewdata['activity'] = $activity;
        $this->viewdata['page_title'] = 'Create Banner';
        return view('Banner.form', $this->viewdata);

    }

    public function save(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required',
            'terms' => 'required',
            'activity' => 'required',
            'image' => 'required',
            'cover' => 'required',
            'highlight' => 'required',
            'label' => 'required',
            'phone' => 'required',
            'group' => 'required',
            'web' => 'required',
            'email' => 'required',
            'params' => 'required',
        ]);

        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('banner.create'));
        }

        // proses insert to DB 
        $insert = $this->banner->saveBanner($request);

        session()->flash('msg_success', 'Create Banner title " '.$request->title.' " have been saved ');
        return redirect(route('banner'));
    }

    public function edit($id)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $get_data = $this->banner->getBannerById($id);
        $activity = $this->banner->getActivityQuery();

        $this->viewdata['detail'] = $get_data;
        $this->viewdata['activity'] = $activity;
        $this->viewdata['page_title'] = 'Edit Banner';
        return view('Banner.form', $this->viewdata);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required',
            'terms' => 'required',
            'activity' => 'required',
          ]);

        $id = $request->id;
        if ($validated->fails()) {
            $message = $validated->messages()->first();
            session()->flash('msg_error', $message);
            return redirect(route('banner.edit',['id'=>$id]));
        }
        $data = $this->banner->getBannerById($id);
        if(!$data){
            session()->flash('msg_error', 'banner ID '.$id.' yang anda masukan tidak ada datanya ');
            return redirect(route('banner.edit',['id'=>$id]));
        }
        
        // proses Update DB
        $update = $this->banner->updateBanner($request);

        session()->flash('msg_success', 'Update Banner title " '.$request->title.' " and banner Id '.$id.' have been updated');
        return redirect(route('banner'));

    }
    public function delete(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');

        if(!$request->id) {
            session()->flash('msg_error', 'Invalid ID');
			return redirect(route('banner'));
        }
        
        $count = 0;
        foreach($request->id as $val)
        {
            $data = $this->banner->getBannerById($val);
            if(!$data) {
                session()->flash('msg_error', 'Data with ID : '.$val.' not found!');
                return response()->json([
                    'status' => false,
                    'message' => 'Data with ID : '.$val.' not found!'
                ]);
            }

            // proses delete DB
            $delete = $this->banner->deleteBanner($val);
            if($delete) {
                $data_name = 'Banner for ID '.$data->id.' with title '.$data->title;
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
