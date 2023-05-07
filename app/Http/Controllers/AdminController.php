<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Position;
use App\Models\PartyList;

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

    public function dashboard(){

        $partylist_count = \App\Models\PartyList::count();
        $candidate_count = Candidate::count();
        $position_count = Position::count();
        $user_count = \App\Models\User::count();


        return response()->json([
            "status" => 1,
            "partylist_count"=>$partylist_count,
            "candidate_count" =>$candidate_count,
            "position_count"=> $position_count,
            "user_count"=> $user_count

        ]);
    }
}
