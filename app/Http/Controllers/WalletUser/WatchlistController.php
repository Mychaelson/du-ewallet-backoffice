<?php

namespace App\Http\Controllers\WalletUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\Datatables;

use App\Repositories\WalletUser\WalletUserRepository;


class WatchlistController extends Controller
{
    
    protected $mod_alias = 'user-watchlist';
    protected $mod_active = 'wallet-user,user-watchlist';

    public function index(Datatables $datatables, Request $request)
    {        
        $walletUserRepository = new WalletUserRepository();

        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $datatables->options([
            'url' => route('watchlist.dt')
        ]);

        $table = $datatables->columns([
            ['field' => 'data_id', 'title' => '#', 'selector' => TRUE, 'sortable' => FALSE, 'width' => 20, 'textAlign' => 'center'],
            ['field' => 'username', 'title' => 'Phone'],
            ['field' => 'name', 'title' => 'Name'],
            ['field' => 'verified', 'title' => 'Status', 'width' => 80, 'textAlign' => 'center', 'template' => "
            var type = {
                1: {'title': 'Premium', 'class': ' label-success', 'text': 'text-success'},
                0: {'title': 'Basic', 'class': ' label-dark', 'text': 'text-dark'},
            }
            ,tr_type= data.verified;
            return typeof type[tr_type] !== 'undefined' ? '<span class=\"label ' + type[tr_type].class + ' label-dot mr-2\"></span><span class=\"font-weight-bold ' + type[tr_type].text + '\">' + type[tr_type].title + ' ' + (data.bet_status=='refund' ? data.type.ucwords() : '') + '</span>' : '-';
            "],
            ['field' => 'created_at', 'title' => 'Join Date'],
            ['field' => '', 'title' => 'Action', 'width' => 60, 'textAlign' => 'center', 'template' => "return '".view('walletuser.watchlist.editButton', ['page' => $this->page, 'mod_alias' => $this->mod_alias, 'dt' => TRUE, 'url' => route('user.detail', ['id' => TRUE])])->render()."'"],
            ]);

        $this->viewdata['table'] = $table;

        $this->viewdata['page_title'] = 'Watchlist';
        return view('walletuser.watchlist.table', $this->viewdata);
    }

    public function data_table(Request $request)
    {
        $limit = (int) ($request->pagination['perpage'] && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) ($request->pagination['page'] && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $get_data = DB::table('accounts.users')
        ->where('watch_status', 0)
        ->selectRaw('id,username,name,verified,status,created_at');


        $query = $request->input('query');
        if(!empty($query))
        {

            if(isset($query['generalSearch'])) {
                $query = $query['generalSearch'];
                $get_data->whereRaw("(LOWER(name) like '%".strtolower($query)."%')");
            }

        }

        if(isset($request->sort['field']))
        {
            $get_data->orderBy($request->sort['field'], $request->sort['sort']);
        }
        else
        {
            $get_data->orderBy('id', 'desc');
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
                    'username' => $val->username,
                    'name' => $val->name,
                    'verified' => $val->verified,
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

}
 