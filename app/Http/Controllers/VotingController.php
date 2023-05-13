<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\PartyList;
use App\Models\User;
use App\Http\Traits\HandleShowResult;
class VotingController extends Controller
{
    use HandleShowResult;
    // public function __construct(){
    //     $this;

    // }
    public function index(){

         
        $positions = \App\Models\Position::with('candidates')->get();
    

     
   //  return view('layouts.home',compact('positions','partyLists'));
        return response()->json([
            "status" => 1,
            "data" =>$positions
        ]);

    }

    public function check(){


   //  return view('layouts.home',compact('positions','partyLists'));
        return response()->json([
            "status" => 1,
            "data" =>'welcome User'
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
            "title" => 'Vote Submitted',
            "message" =>"Your Vote has been recorded please wait for the result"
        ]);
    }

    public function getResult(){
        $result = $this->showResult();
        return  response()->json([
            "status" => 1,
            "positions" => $result
        ]);
        
    }

    public function getSettings(){
        return $this->loadSettings();
    }
   
}
