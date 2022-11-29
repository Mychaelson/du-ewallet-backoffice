<?php

namespace App\Repositories\Users;
use App\Models\User;
use App\Models\Role;
use App\Models\UserPerms;
use App\Models\UserPermsChain;
use App\Models\AccessLog;

class UsersRepository
{
    // USER

    public function find($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function getAllUser()
    {
        $users = User::select('id', 'name')->get();

        return $users;
    }

    public function paginate($sortBy, $sort)
    {
        $users = User::join('backoffice.roles', 'roles.id', '=', \DB::raw('CAST("user"."role" AS INTEGER)'))->select('user.id', 'user.name', 'fullname', 'nickname', 'user.role', 'created_at', 'roles.name as description')->orderBy($sortBy, $sort);

        return $users;
    }

    public function insertUser($request)
    {
        $user = new User;
        $user->id;
        $user->name = $request->name;
        $user->password = '';
        $user->nickname = '';
        $user->fullname = $request->fullname;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        return $user;
    }

    public function updateUser($id, $request)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->nickname = $request->nickname;
        $user->fullname = $request->fullname;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        return $user;
    }

    public function updatePassword($id, $password)
    {
        $user = User::find($id);
        $user->password = \Hash::make($password);
        $user->save();
    }

    public function deleteById($request)
    {
        $users = User::whereIn('id', $request->id)->delete();
     
        return $users;
    }

    // ROLE
    public function getAllRole()
    {
        $roles = Role::select('id', 'name as description')->get();

        return $roles;
    }

    // PERMISSION
    public function pluckUserPermsChain($userId)
    {
        $userChain = UserPermsChain::where(['user' => $userId])->pluck('user_perms');
        
        return $userChain;
    }

    public function getAllUserPerms()
    {
        $perms = UserPerms::select('id', 'name', 'group', 'about')->get();
        return $perms;
    }

    public function deletePermsChain($id, $checkChild)
    {
        UserPermsChain::where(['user' => $id])->whereNotIn('user_perms', $checkChild)->delete();
    }

    public function insertUserPermsChain($val)
    {
        UserPermsChain::insert($val);
    }

    //ACCESS LOG
    public function getAccessLogTypePluck()
    {
        $types = AccessLog::select('type')->groupBy('type')->pluck('type');

        return $types;
    }

    public function getDtLog($sort, $sortBy)
    {
        $logs = AccessLog::join('backoffice.user', 'user.id', 'user')->orderBy($sortBy, $sort);
    
        return $logs;
    }
}
