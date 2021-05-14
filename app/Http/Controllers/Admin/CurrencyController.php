<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use Validator;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index()
     {
          $data["menus"] = $this->menupos->getParentMenu();
          $data["lak"] = Currency::find(2);
          return view('Admin.Currency.index', $data);
     }

}
