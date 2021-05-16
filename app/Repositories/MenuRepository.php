<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\Menu;
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

    public function getParentMenu()
    {
         // $user = User::WithUserLogin();
         $menu = Menu::with(['SubMenu' => function($q){
              $q->where('use_flag', 'Y');
              $q->orderBy('sort', 'asc');
         }])->where('use_flag', 'Y')->orderBy('sort', 'asc')->get();
         // $role_id = $user->role_id;
         // $role_has_perm = FpRoleHasPermission::where('module_id', '=', $module_id)->where('status', '=', 'T')->where('role_id', '=', $role_id)->first();
         // // dd($role_has_perm);
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
         return $menu;
    }
}
