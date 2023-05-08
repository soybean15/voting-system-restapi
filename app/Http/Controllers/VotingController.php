<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\PartyList;
class VotingController extends Controller
{
    public function index(){

         
        $positions = \App\Models\Position::with('candidates')->get();
    

     
   //  return view('layouts.home',compact('positions','partyLists'));
        return response()->json([
            "status" => 1,
            "data" =>$positions
        ]);

    }

    public function store(Request $request){

        $voteLog = new VoteLog;
        $voteLog->vote = 'up';
        $voteLog->user_id = $user->id;
        $voteLog->save();



    }
}
