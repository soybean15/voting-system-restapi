<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('isAdmin');


    }

    public function index(){
        return  response()->json([
            "status" => 1,
            "message" => "Welcome Admin"
        ]);
    }
}
