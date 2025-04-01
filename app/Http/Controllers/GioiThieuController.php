<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GioiThieuController extends Controller
{
    public function index()
    {
        return view('gioithieu');
    }
}
