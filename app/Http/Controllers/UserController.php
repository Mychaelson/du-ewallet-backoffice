<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Users\UsersRepository;
use App\Library\Services\Datatables;

class UserController extends Controller
{
    protected $mod_alias = 'auth_user';
    protected $mod_active = 'auth_user,auth_user';

    public function __construct(private UsersRepository $usersRepository)
    {
        parent::__construct();
    }

    public function index(Datatables $datatables)
    {
        $this->page->blocked_page($this->mod_alias);
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;

        $this->viewdata['page_title'] = 'Users';

        $datatables->config([
            'roles' => [
                'delete' => $this->page->mod_action_roles($this->mod_alias, 'drop'),
            ],
            'delete_url' => route('users.delete'),
        ]);

        $datatables->options([
            'url' => route('users.dt')
        ]);

        $table = $datatables->columns([
            ['field' => 'id', 'title' => '#', 'selector' => TRUE, 'sortable' => TRUE, 'width' => 20, 'textAlign' => 'center'],
            ['field' => 'username', 'title' => 'Username'],
            ['field' => 'fullname', 'title' => 'Full Name'],
            ['field' => 'role', 'title' => 'Role'],
            ['field' => 'nusapay', 'title' => 'Nusapay'],
            ['field' => 'created_at', 'title' => 'Created'],
            ['field' => '', 'title' => 'Action', 'width' => 130, 'textAlign' => 'center', 'template' => "return '".view('user.actionButton', ['id' => '', 'url' => route('users.profile', ['id' => TRUE])])->render(). "'"],
        ]);

        $this->viewdata['table'] = $table;
        
        return view('user.content', $this->viewdata);
    }

    public function usersDT(Request $request)
    {
        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;
        
        $field = [
            'username' => 'name',
            'role' => 'description',
            'nusapay' => 'nickname'];


        $sort = isset($request['sort']['sort']) ? $request['sort']['sort'] : 'desc';
        $sortBy = isset($request['sort']['field']) ? $request['sort']['field'] : 'created_at';

        $sortBy = isset($field[$sortBy]) ? $field[$sortBy] : $sortBy;

        $users = $this->usersRepository->paginate($sortBy, $sort);

        $rowIds = $users->pluck('id');
        $data = [];

        if(isset($request['query']['generalSearch']))
        {
            $query = $request['query']['generalSearch'];
            $users->whereRaw("LOWER(nickname) like '%".strtolower($query)."%'");
        }
        $total = count($users->get());

        $users = $users->limit($limit)->offset($offset)->get();

        foreach($users as $key => $val)
            array_push($data, [
                'id' => $val->id,
                'username' => $val->name,
                'fullname' => $val->fullname,
                'nusapay' => '@'.$val->nickname,
                'role' => $val->description,
                'created_at' => date('Y-m-d H:i:s', strtotime($val->created_at)),
            ]);

        return [
            'meta' => [
                'page' => $page,
                'pages' => ceil($total / $limit),
                'perpage' => $limit,
                'total' => $total,
                'sort' => $sort,
                'field' => $sortBy,
                'rowIds' => $rowIds
            ],
            'data' => $data
        ];
    }

    public function addUser()
    {
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['page_title'] = 'Add Account';
        $roles = $this->usersRepository->getAllRole();
        $this->viewdata['roles'] = $roles;

        return view('user.add', $this->viewdata);
    }

    public function saveUser(Request $request)
    {
        $validated = $validated = $request->validate([ 
            'name' => 'required',
            'fullname' => 'required',
            'status' => 'required',
            'role' => 'required']);

        $user = $this->usersRepository->insertUser($request);

        return redirect()->route('users.profile', ['id' => $user->id]);
    }

    public function updateUser($id, Request $request)
    {
        $validated = $validated = $request->validate([ 
            'name' => 'required',
            'nickname' => 'required',
            'fullname' => 'required',
            'status' => 'required',
            'role' => 'required']);

        $user = $this->usersRepository->updateUser($id, $request);

        return redirect()->back()->with('message', 'Profile successfully updated');
    }

    public function updateUserPassword($id, Request $request)
    {
        $validated = $validated = $request->validate([ 
        'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:6']);

        $user = $this->usersRepository->updatePassword($id, $request->password);

        return redirect()->back()->with('message', 'Password successfully updated');
    }
    

    public function profile($id)
    {
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $user = $this->usersRepository->find($id);
        $roles = $this->usersRepository->getAllRole();
        $this->viewdata['roles'] = $roles;
        $this->viewdata['user'] = $user;

        $this->viewdata['page_title'] = "Edit $user->name's Profile";

        return view('user.profile', $this->viewdata);
    }

    public function password($id)
    {
        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $user = $this->usersRepository->find($id);
        $this->viewdata['user'] = $user;

        $this->viewdata['page_title'] = "Edit $user->name's Password";

        return view('user.password', $this->viewdata);
    }

    public function deleteUser(Request $request)
    {
        $user = $this->usersRepository->deleteById($request);

        return response()->json([
            'status' => TRUE,
            'message' => 'successfully deleted'
        ]);
    }

    public function permission($id)
    {
        $user = $this->usersRepository->find($id);
        $userChain = $this->usersRepository->pluckUserPermsChain($id);
        $perms = $this->usersRepository->getAllUserPerms();

        $groupPerms = [];
        foreach ($perms as $key => $value) {
            if (!isset($groupPerms[$value->group]))
                $groupPerms[$value->group] = [];

            $value->name = str_replace("_"," ",$value->name);
            array_push($groupPerms[$value->group], $value->toArray());
        }

        $this->viewdata['group_perms'] = $groupPerms;
        $this->viewdata['user'] = $user;
        $this->viewdata['user_chain'] = $userChain->toArray();
        $this->viewdata['page_title'] = "$user->name's Permissions";

        return view('user.permission', $this->viewdata);
    }

    public function updatePermission(Request $request, $id)
    {
        $this->usersRepository->deletePermsChain($id, $request->checkChild);
        $userChain = $this->usersRepository->pluckUserPermsChain($id)->toArray();
        
        $val = [];
        foreach ($request->checkChild as $key => $value) {
            if (!in_array($value, $userChain))
                array_push($val, ['user_perms' => $value, 'user' => $id]);
        }

        $userChain = $this->usersRepository->insertUserPermsChain($val);

        return redirect()->back()->with('message', 'Successfully updated');
    }

    public function log(Datatables $datatables)
    {
        $users = $this->usersRepository->getAllUser();
        $types = $this->usersRepository->getAccessLogTypePluck();

        $this->viewdata['mod_alias'] = $this->mod_alias;
        $this->viewdata['mod_active'] = $this->mod_active;
        $this->viewdata['users'] = $users;
        $this->viewdata['types'] = $types;
        $this->viewdata['page_title'] = "Log User N-Admin";

        $datatables->options([
            'url' => route('users.logdt'),
            'additional' => (object)[
                'user' => "$('#dt_select_user')",
                'type' => "$('#dt_select_type')",
                'datestart' => "$('#datestart')",
                'dateend' => "$('#dateend')",
            ]
        ]);

        $table = $datatables->columns([
            ['field' => 'user', 'title' => 'User'],
            ['field' => 'type', 'title' => 'Type'],
            ['field' => 'action', 'title' => 'Action'],
            ['field' => 'reff', 'title' => 'Reff'],
            ['field' => 'created_at', 'title' => 'Created'],
        ]);

        $this->viewdata['table'] = $table;

        return view('user.log', $this->viewdata);
    }

    public function usersLogDT(Request $request)
    {
        $limit = (int) (isset($request->pagination['perpage']) && is_numeric($request->pagination['perpage']) ? $request->pagination['perpage'] : 5);
        $page  = (int) (isset($request->pagination['page']) && is_numeric($request->pagination['page']) ? $request->pagination['page'] : 0);
        $offset = $page > 0 ? (($page - 1) * $limit) : 0;

        $field = [
            'created_at' => 'created',
            'action' => 'page',
            'reff' => 'ref'];


        $sort = isset($request['sort']['sort']) ? $request['sort']['sort'] : 'desc';
        $sortBy = isset($request['sort']['field']) ? $request['sort']['field'] : 'created_at';

        $sortBy = isset($field[$sortBy]) ? $field[$sortBy] : $sortBy;

        $logs = $this->usersRepository->getDtLog($sort, $sortBy);

        $rowIds = $logs->pluck('user.id');

        if(isset($request['query']['user']))
        {
            $logs->where('user', $request['query']['user']);
        }

        if(isset($request['query']['type']))
        {
            $logs->where('type', $request['query']['type']);
        }

        if(isset($request['query']['dateStart']))
        {
            $logs->where('created_at', '>=' ,date('Y-m-d H:i:s', strtotime($request['query']['dateStart'])));
        }

        if(isset($request['query']['dateEnd']))
        {
            $logs->where('created_at', '<=' ,date('Y-m-d H:i:s', strtotime($request['query']['dateEnd'])));
        }

        $total = count($logs->get());

        $logs = $logs->limit($limit)->offset($offset)->get();

        $data = [];
        foreach($logs as $key => $val)
            array_push($data, [
                'user' => $val->name,
                'type' => $val->type,
                'action' => $val->page,
                'reff' => $val->ref,
                'created_at' => date('Y-m-d H:i:s', strtotime($val->created_at)),
            ]);

        return [
            'meta' => [
                'page' => $page,
                'pages' => ceil($total / $limit),
                'perpage' => $limit,
                'total' => $total,
                'sort' => $sort,
                'field' => $sortBy,
                'rowIds' => $rowIds
            ],
            'data' => $data
        ];
    }

}
