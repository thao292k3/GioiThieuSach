<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        return view('admin.index'); // Tạo view này trong resources/views/manager
    }
}
