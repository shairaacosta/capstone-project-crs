<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
         $fname = "Charlton Stephen";
         $lname = "Larano";

        $data = [];

        $data['fname'] = $fname;
        $data['lname'] = $lname;

         return view('main.index', compact('data'));

    }
}
