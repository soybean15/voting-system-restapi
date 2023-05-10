<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Position;
use App\Models\PartyList;
use App\Models\User;
use App\Models\VoteLog;

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
        $positions= Position::with('candidates')->get();

        $partylist_count = \App\Models\PartyList::count();
        $candidate_count = Candidate::count();
        $position_count = $positions->count();
        $user_count = \App\Models\User::count();

        // $hasVoted = User::has('voteLog')->get();
        // $notVoted = User::doesntHave('vote_log')->get();

        $voteLogs = VoteLog::with('user')
            ->orderBy('created_at')
            ->get();
        return response()->json([
            "status" => 1,
            "partylist_count"=>$partylist_count,
            "candidate_count" =>$candidate_count,
            "position_count"=> $position_count,
            "user_count"=> $user_count,
            "positions"=>$positions,
            "vote_logs"=>$voteLogs

        ]);
    }
}
