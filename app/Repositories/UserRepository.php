<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\User;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
        return User::class;
    }

    public function GetRoleId()
    {
         $user = User::with('Role')->find(\Auth::guard('admin')->id());
         return $user->Role->id;
    }

}
