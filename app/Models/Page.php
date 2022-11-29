<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

use App\Models\Role;

class Page extends Model
{
    use HasFactory;

    public function viewdata()
    {
        return [];
    }

    public function total_users_in_group(Int $guid)
    {
        return DB::table('backoffice.user')->where(['role' => $guid])->select('role')->count();
    }

    public function roles($guid = '')
    {
        if($guid)
        {
            $group = Role::find($guid);
        }
        else
        {
            $group = Auth::user()->role();
        }
        $roles = json_decode($group->role);
        $_roles = ['view' => [], 'create' => [], 'alter' => [], 'drop' => []];

        if(is_object($roles))
        {
            foreach($roles as $k => $r)
            {
                $_roles[$k] = explode(',', $r);
            }
        }

        return $_roles;
    }

    public function get_modules($parent_id = 0, $_flag = 0)
    {


        $query = DB::table('backoffice.module')->where(['parent_id' => $parent_id])->orderByRaw('parent_id asc, mod_order asc');

        $_module = [];
        if($_flag == 0)
        {
            $_module[] = [
                'modid' => 0,
                'alias' => 'dashboard',
                'parent' => NULL,
                'name' => 'Dashboard',
                'url' => '/',
                'section' => NULL,
                'icon' => 'flaticon-home-2'
            ];
        }

        if($query->count() > 0 )
        {
            foreach($query->get() as $val)
            {
                $_mods = [
                    'modid' => $val->modid,
                    'alias' => $val->mod_alias,
                    'parent' => $val->parent_id,
                    'name' => $val->mod_name,
                    'url' => !empty($val->permalink) ? $val->permalink : NULL,
                    'section' => NULL,
                    'icon' => $val->icon
                ];

                if($val->parent_id == 0)
                {
                    $_mods['submenu'] = $this->get_modules($val->modid, 1);
                }

                $_module[] = $_mods;
            }
        }

        return $_module;
    }

    public function modules(Array $alias, $mod_config = '')
    {
        $mod_config = $mod_config ?: $this->get_modules();

        $_mods = NULL;
        foreach($mod_config as $mod)
        {
            if(empty($alias['set']))
            {
                $modules[] = $mod;
            }
            else
            {
                if(isset($mod['submenu']) && count($mod['submenu']) > 0)
                {
                    $key = array_search($alias['set'], array_column($mod['submenu'], 'parent'));
                    if($key !== FALSE)
                    {
                        $modules = [$mod['submenu'][$key]];
                    }

                    if($alias['set'] == $mod['alias'])
                    {
                        $modules = $mod['submenu'];
                    }
                }
            }

            $modules[] = $_mods;
        }

        $modules = array_filter($modules);

        return ($modules);
    }

    public function module_id($alias)
    {
        return DB::table('backoffice.module')->where(['mod_alias' => $alias])->select('modid')->first()->modid;
    }

    public function blocked_page($alias = '', $role = 'view')
    {
        $roles = $this->roles();

        $module_id = $this->module_id($alias);

        if(!array_key_exists($role, $roles) || !$module_id)
        {
            return abort('404');
        }

        $show_page = TRUE;
        if(!in_array($module_id, $roles[$role]))
        {
            $show_page = FALSE;
        }

        if($show_page === FALSE)
        {
            return abort('404');
        }
    }

    public function mod_action_roles($alias = '', $role = 'view')
    {
        $roles = $this->roles();

        $module_id = $this->module_id($alias);

        if(!array_key_exists($role, $roles) || !$module_id)
        {
            return FALSE;
        }

        $show_page = TRUE;
        if(!in_array($module_id, $roles[$role]))
        {
            $show_page = FALSE;
        }

        return $show_page;
    }

    public function module_roles(Array $alias, $modules = '', $params = 0, $guid = '')
    {
        $modules = $this->modules(['set' => $params > 0 ? $alias['set'] : ''], $modules);
        $decode_modules = (array) json_decode(json_encode($modules));

        $template = NULL;

        $template .= $params == 0 ? '<ul class="menu-nav pl-0">' : NULL;
        if(is_array($decode_modules) && count($modules) > 0)
        {
            $roles = [
                ['name' => 'view', 'color' => 'primary', 'text' => 'User can view this page'],
                ['name' => 'create', 'color' => 'success', 'text' => 'User can create the new data'],
                ['name' => 'alter', 'color' => 'warning', 'text' => 'User can update existing data'],
                ['name' => 'drop', 'color' => 'danger', 'text' => 'User can delete existing data'],
            ];
            $selected_roles = old('roles') ?: ($guid?$this->roles($guid):[]);
            foreach($decode_modules as $mod)
            {
                if($mod->alias != 'dashboard')
                {
                    $template .= '<div class="form-group row">';
                    $template .= '<label class="col-xxl-3 col-form-label align-middle'.($mod->parent ? ' pl-'.($params > 1 ? $params * 7 : 5) : '').'">'.($mod->parent ? '<i class="flaticon-more-v2 mr-4"></i>' : '').$mod->name.'</label>';
                    $template .= '<div class="col-9 col-form-label">';
                        $template .= '<div class="row role-options" id="role-'.$mod->alias.'">';
                        foreach($roles as $role)
                        {
                            $allowed_roles = ['view'];
                            if(!empty($mod->url))
                            {
                                $allowed_roles = ['view','create','alter','drop'];
                            }

                            if(in_array($role['name'], $allowed_roles))
                            {
                                $template .= '
                                    <div class="col-lg-3">
                                        <label class="option'.(count($selected_roles) > 0 && in_array($mod->modid, $selected_roles[$role['name']]) ? ' bg-'.$role['color'].'-o-30' : '').'">
                                            <span class="option-control">
                                                <span class="checkbox check-'.$role['name'].'" id="'.$role['name'].'-'.$mod->modid.'">
                                                    <input type="checkbox" name="roles['.$role['name'].'][]" value="'.$mod->modid.'" data-role="'.$role['name'].'" data-color="'.$role['color'].'" data-alias="'.$mod->modid.'" data-parent="'.$mod->parent.'"'.(count($selected_roles) > 0 && in_array($mod->modid, $selected_roles[$role['name']]) ? ' checked' : '').'>
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="option-label">
                                                <span class="option-head">
                                                    <span class="option-title">'.ucwords($role['name']).'</span>
                                                </span>
                                                <span class="option-body">'.$role['text'].'</span>
                                            </span>
                                        </label>
                                    </div>';
                            }
                        }
                        $template .= '</div>';
                    $template .= '</div>';
                    $template .= '</div>';

                    if(isset($mod->submenu))
                    {
                        $template .= $this->module_roles(['set' => $mod->alias, 'active' => $alias['active']], $modules, $params + 1, $guid);
                    }
                }
            }
        }

        return $template;
    }

    public function module_sidebar(Array $alias, $modules = '', $params = 0)
    {
        $modules = $this->modules(['set' => $params > 0 ? $alias['set'] : ''], $modules);
        $decode_modules = (array) json_decode(json_encode($modules));

        $template = NULL;

        $template .= $params == 0 ? '<ul class="menu-nav">' : NULL;
        if(is_array($decode_modules) && count($modules) > 0)
        {
            $roles = $this->roles();
            foreach($decode_modules as $mod)
            {
                $show_menu = FALSE;
                if(in_array($mod->modid, $roles['view']) || $mod->alias == 'dashboard')
                {
                    $show_menu = TRUE;
                }

                if($show_menu == TRUE)
                {
                    $li_class = $toggle_hover = NULL;
                    if(isset($mod->submenu) && count($mod->submenu) > 0)
                    {
                        $li_class = ' menu-item-submenu';
                        $toggle_hover = ' data-menu-toggle="hover"';
                    }

                    if(in_array($mod->alias, explode(',',$alias['active'])))
                    {
                        $li_class = ' menu-item-active menu-item-open';
                    }

                    $template .= '<li class="menu-item'.$li_class.'" aria-haspopup="true"'.$toggle_hover.'>';

                    $template .= '<a href="'.($mod->url? url($mod->url) :'javascript:;').'" class="menu-link'.(isset($mod->submenu) && count($mod->submenu) > 0 ? ' menu-toggle' : '').'">';

                    if($mod->icon)
                    {
                        $template .= '<i class="menu-icon '.$mod->icon.'">';
                            // $template .= $mod->icon;
                        $template .= '</i>';
                    }
                    else
                    {
                        if(isset($mod->submenu) && count($mod->submenu) > 0)
                        {
                            $template .= '<i class="menu-bullet menu-bullet-line"><span></span></i>';
                        }
                        else
                        {
                            $template .= '<i class="menu-bullet menu-bullet-dot"><span></span></i>';
                        }
                    }

                    $template .= '<span class="menu-text">'.$mod->name.'</span>';

                    if(isset($mod->submenu) && count($mod->submenu) > 0)
                    {
                        $template .= '<i class="menu-arrow"></i>';
                    }

                    $template .= '</a>';

                    if(isset($mod->submenu) && count($mod->submenu) > 0)
                    {
                        $template .= '<div class="menu-submenu"><ul class="menu-subnav">';
                        $template .= $this->module_sidebar(['set' => $mod->alias, 'active' => $alias['active']], $modules, 1);
                        $template .= '</ul></div>';
                    }

                    $template .= '</li>';
                }
            }
        }
        $template .= $params == 0 ? '</ul>' : NULL;

        return $template;
    }

    public function paginate($items, $perPage = 10, $total_row = 0, $page = 0, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items, $total_row == 0 ? $items->count() : $total_row, $perPage, $page, $options);
    }
   
}
