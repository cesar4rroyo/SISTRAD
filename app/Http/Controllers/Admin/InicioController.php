<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InicioController extends Controller
{
    public function index(){
        // return view('welcome');
        return redirect('/auth/logout');
    }
}
