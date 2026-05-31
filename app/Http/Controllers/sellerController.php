<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sellerController extends Controller
{
    public function sellerLogin(){
        return view('seller.login');
    }
}
