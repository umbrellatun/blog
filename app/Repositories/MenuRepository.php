<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\Menu;
use App\Models\Permission;
use App\User;

/**
 * Class MenuRepository.
 */
class MenuRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Menu::class;
    }

    public function getMenuPermission()
    {
         $user = User::where('id', '=', \Auth::guard('admin')->id())->first();
         $role_id = $user->role_id;
         $permissions = Permission::where('role_id', '=', $role_id)->get();
         $permission_arr = [];
         foreach ($permissions as $key => $permission) {
              array_push($permission_arr, $permission->menu_id);
         }
         return array_filter($permission_arr);
    }

    public function getSubMenuPermission()
    {
         $user = User::where('id', '=', \Auth::guard('admin')->id())->first();
         $role_id = $user->role_id;
         $permissions = Permission::where('role_id', '=', $role_id)->get();
         $permission_arr = [];
         foreach ($permissions as $key => $permission) {
              array_push($permission_arr, $permission->submenu_id);
         }
         return array_filter($permission_arr);
    }

    public function getParentMenu()
    {
         // $user = User::where('id', '=', \Auth::guard('admin')->id())->first();
         // $role_id = $user->role_id;
         $menu_arr = self::getMenuPermission();
         $sub_menu_arr = self::getSubMenuPermission();
         $menu = Menu::with(['SubMenu' => function($q) use ($sub_menu_arr){
              $q->where('use_flag', 'Y');
              $q->orderBy('sort', 'asc');
              $q->whereIn('id', $sub_menu_arr);
         }])->where('use_flag', 'Y')->whereIn('id', $menu_arr)->orderBy('sort', 'asc')->get();
         // $role_has_perm = FpRoleHasPermission::where('module_id', '=', $module_id)->where('status', '=', 'T')->where('role_id', '=', $role_id)->first();
         // dd($role_has_perm);
         // if ($role_has_perm) {
         //      $result = FpMenu::with(['FpRoleHasPermission' => function($q)use($module_id, $role_id, $role_has_perm){
         //           $q->where('module_id', '=', $module_id);
         //           $q->where('status', '=', 'T');
         //           $q->where('role_id', '=', $role_id);
         //           $q->with(['FpRoleHasPermissionMenu' => function($query)use($role_has_perm){
         //                $query->where('fprole_has_permission_id', '=', $role_has_perm->id);
         //                $query->where('status', '=', 'T');
         //           }]);
         //      }])
         //      ->where('module_id', '=', $module_id)
         //      ->where('status', '=', 'T')
         //      ->orderBy('sort', 'asc')
         //      ->get();
         //      return $result;
         // }

         // $menu = Permission::with('Menu')->where('role_id', '=', $role_id)->get();
         // dd($menu);
         return $menu;
    }


}
