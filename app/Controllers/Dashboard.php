<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
      return view('dashboard',['title' => env('app.systemName'),'logo'=>env('app.systemLogo')]);
    }
}
