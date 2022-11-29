<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\Datatables;

use App\Repositories\WalletUser\WalletUserRepository;


class BlacklistController extends Controller
{
    
    protected $mod_alias = 'user-blacklist';
    protected $mod_active = 'wallet-user,user-blacklist';

    public function index(Datatables $datatables, Request $request)
    {        
        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $datatables->config([
            'roles' => [
                'delete' => $this->page->mod_action_roles($this->mod_alias, 'drop'),
                'update' => $this->page->mod_action_roles($this->mod_alias, 'alter'),
            ],
            'delete_url' => route('blacklist.delete')
        ]);

        $datatables->options([
            'url' => route('blacklist.dt')
        ]);

        $table = $datatables->columns([
            ['field' => 'data_id', 'title' => '#', 'selector' => TRUE, 'sortable' => FALSE, 'width' => 20, 'textAlign' => 'center'],
            ['field' => 'name', 'title' => 'Name'],
            ['field' => 'country_of_origin', 'title' => 'Origin'],
            ['field' => 'nationality', 'title' => 'Nationality'],
            ['field' => 'created_at', 'title' => 'Created'],
            ['field' => '', 'title' => 'Action', 'width' => 60, 'textAlign' => 'center', 'template' => "return '".view('walletuser.blacklist.editButton', ['page' => $this->page, 'mod_alias' => $this->mod_alias, 'dt' => TRUE, 'url' => route('blacklist.edit', ['id' => TRUE])])->render()."'"],
            ]);

        $this->viewdata['table'] = $table;

        $this->viewdata['page_title'] = 'Blacklist';
        return view('walletuser.blacklist.table', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $limit = (int) ($request->pagination['perpage'] && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) ($request->pagination['page'] && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $get_data = DB::table('accounts.blacklisted as g')
        ->selectRaw('g.id,g.name,g.country_of_origin,g.nationality, g.created_at');


        $query = $request->input('query');
        if(!empty($query))
        {

            if(isset($query['generalSearch'])) {
                $query = $query['generalSearch'];
                $get_data->whereRaw("(LOWER(g.name) like '%".strtolower($query)."%')");
            }

        }

        if(isset($request->sort['field']))
        {
            $get_data->orderBy($request->sort['field'], $request->sort['sort']);
        }
        else
        {
            $get_data->orderBy('g.id', 'desc');
        }

        $total_data = $get_data->count();

        $_data = $rowIds = [];
        if($total_data > 0)
        {
            $no = ($page - 1) * $limit;
            foreach($get_data->limit($limit)->offset($offset)->get() as $key => $val)
            {
                $_data[] = [
                    'no' => ++$no,
                    'data_id' => $val->id,
                    'name' => $val->name,
                    'country_of_origin' => $val->country_of_origin,
                    'nationality' => $val->nationality,
                    'created_at' => $val->created_at
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

    public function delete(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');
        if(!$request->id)
        {
            return response()->json([
                'status' => FALSE,
                'message' => 'Invalid ID'
            ],400);
        }

        /**
         * Delete data
         */
        $total = 0;
        foreach($request->id as $id)
        {
            $delete = DB::table('accounts.blacklisted')->where(['id' => $id])->delete();
            if($delete)
            {
                $total += 1;
            }

        }



        return response()->json([
            'status' => TRUE,
            'message' => $total.' Data has been deleted'
        ]);
    }

    public function add()
    {
        $this->page->blocked_page($this->mod_alias, 'create');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;


        $this->viewdata['page_title'] = 'Blacklist > Add';
        return view('walletuser.blacklist.add', $this->viewdata);
    }

    public function edit($id)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $data = DB::table('accounts.blacklisted')->where('id', $id)->first();
        if(!$data)
        {
            return redirect(route('user-blacklist'))->with(['msg_error' => 'Data with ID '.$id.' not found!']);
        }
        
        $this->viewdata['data'] = $data;

        $this->viewdata['page_title'] = 'Blacklist > Edit';
        return view('walletuser.blacklist.edit', $this->viewdata);
    }

    public function save(Request $request)
    {

        $this->page->blocked_page($this->mod_alias, 'create');

        /**
         * Insert data
         */
        $insertId = DB::table('accounts.blacklisted')->insertGetId([
            'name' => $request->name,
            "alias" => $request->name,
            "country_of_origin" => $request->country_of_origin ? $request->country_of_origin : NULL,
            "place_of_birth" => $request->place_of_birth ? $request->place_of_birth : NULL,
            "job" => $request->job ? $request->job : NULL,
            "date_of_birth" => $request->date_of_birth ? $request->date_of_birth : NULL,
            "phone" => $request->phone ? $request->phone : NULL,
            "nationality" => $request->nationality ? $request->nationality : NULL,
            "address" => $request->address ? $request->address : NULL,
            "created_at" => date('Y-m-d H:i:s'),
        ]);


        return redirect(route('user-blacklist'))->with(['msg_success' => 'Data with name '.ucwords($request->name).' has been saved']);
    }

    public function update(Request $request)
    {

        $this->page->blocked_page($this->mod_alias, 'create');

        /**
         * Insert data
         */
        $insertId = DB::table('accounts.blacklisted')->update([
            'name' => $request->name,
            "alias" => $request->name,
            "country_of_origin" => $request->country_of_origin ? $request->country_of_origin : NULL,
            "place_of_birth" => $request->place_of_birth ? $request->place_of_birth : NULL,
            "job" => $request->job ? $request->job : NULL,
            "date_of_birth" => $request->date_of_birth ? $request->date_of_birth : NULL,
            "phone" => $request->phone ? $request->phone : NULL,
            "nationality" => $request->nationality ? $request->nationality : NULL,
            "address" => $request->address ? $request->address : NULL,
            "updated_at" => date('Y-m-d H:i:s'),
        ]);


        return redirect(route('user-blacklist'))->with(['msg_success' => 'Data with name '.$request->name.' has been updated']);
    }


}
 