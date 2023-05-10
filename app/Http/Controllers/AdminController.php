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

         $hasVoted = User::has('voteLog')->count();
         $notVoted = User::doesntHave('voteLog')->count();

        $voteLogs = VoteLog::with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
            foreach ($voteLogs as $voteLog) {
                $voteLog->created_at = \Carbon\Carbon::parse($voteLog->created_at)->format('Y-m-d H:i:s');
            }

        return response()->json([
            "status" => 1,
            "partylist_count"=>$partylist_count,
            "candidate_count" =>$candidate_count,
            "position_count"=> $position_count,
            "user_count"=> $user_count,
            "positions"=>$positions,
            "vote_logs"=>$voteLogs,
            "voters"=>[
                "has_voted"=>$hasVoted,
                "not_voted"=>$notVoted
            ]

        ]);
    }

    public function filterByDate(Request $request){
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $voteLogs = VoteLog::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
    
        // Return the filtered vote logs
        return response()->json([
            'vote_logs' => $voteLogs
        ]);

    }
}
