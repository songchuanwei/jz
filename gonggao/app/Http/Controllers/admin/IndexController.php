<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\Admin;

class IndexController extends Controller
{

    public function getIndex()
    {
        return view('admin.index.index');
    }

}
