<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $this->viewdata['mod_active'] = 'dashboard';

        $this->viewdata['page_title'] = 'Dashboard';
        return view('home.content', $this->viewdata);
    }
}
