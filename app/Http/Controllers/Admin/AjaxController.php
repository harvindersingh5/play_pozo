<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function setPage(Request $request){
        return redirect()->back();
        dd('this is ajaxController');
    }
}
