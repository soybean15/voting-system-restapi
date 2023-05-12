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
    public function getResult(){
        $positions= Position::with('candidates')->get();
        return  response()->json([
            "status" => 1,
            "positions" => $positions
        ]);
    }

    public function dashboard(){


        $partylist_count = \App\Models\PartyList::count();
        $candidate_count = Candidate::count();
        $position_count = Position::count();
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

    public function getSettings(){
        $settings = \DB::table('dashboard')->get();
        if ($settings->count() === 0) {
            \DB::table('dashboard')->insert([
                'show_result' => false
            ]);
            $settings = \DB::table('dashboard')->get();
        }
        return response()->json([
            'settings' => $settings
        ]);

    }

    public function handleShowResult(){

        
        $settings = \DB::table('dashboard')->first();

        $newStatus = !$settings->show_result;

        \DB::table('dashboard')->where('id', $settings->id)->update(['show_result' => $newStatus]);

        $updatedSettings = \DB::table('dashboard')->where('id', $settings->id)->first();
        return response()->json([
            'settings' => $updatedSettings 
        ]);

    }

    public function openVoting(){

        $settings = \DB::table('dashboard')->first();
        $timeOpen = $settings->time_open;
    
        if (!$timeOpen) {
            // Add the current date and time to the `time_open` column if it is currently null
            \DB::table('dashboard')->where('id', $settings->id)->update(['time_open' => \Carbon\Carbon::now()]);
        } else {
            // Set the `time_open` column to null if it has a value
            \DB::table('dashboard')->where('id', $settings->id)->update(['time_open' => null]);
        }
    
        $updatedSettings = \DB::table('dashboard')->where('id', $settings->id)->first();
        return response()->json([
            'settings' => $updatedSettings 
        ]);


    }
    
}
