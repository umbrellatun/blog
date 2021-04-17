<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class CenterFunctionController extends Controller
{
     public function thb_to_lak (Request $request)
     {
          $thb = $request->thb;
          $currency = Currency::find(2);
          $res = $currency->exchange_rate * $thb;

          return $res;
     }
}
