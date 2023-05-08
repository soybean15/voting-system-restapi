<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\PartyList;
use App\Models\User;
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

        $user = User::find($request->user_id);
        
        foreach($request->positions as $position){
            foreach($position['candidates'] as $candidate){
                $item = Candidate::find($candidate['id']);
                if ($candidate['isSelected']) {
                    $item->increment('vote_count');
                }


            }
        }
        $voteLog = new \App\Models\VoteLog;

        $voteLog->user_id = $user->id;
        $voteLog->save();

        return response()->json([
            "status" => $request->positions,
            "message" =>"Your Vote has been recorded please wait for the result"
        ]);
    }
}
