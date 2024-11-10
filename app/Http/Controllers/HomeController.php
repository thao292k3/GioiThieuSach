<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    public function blog()
    {
        return view('site.blog');
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function shop()
    {
        return view('site.shop');
    }
}
