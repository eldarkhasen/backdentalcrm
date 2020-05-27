<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebBaseController;

class HomeController extends WebBaseController
{
    public function index()
    {
        return view('web.admin.home');
    }
}
