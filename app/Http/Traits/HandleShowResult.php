<?php

namespace App\Http\Traits;

trait HandleShowResult
{
    public function showResult()
    {
        
        $positions= \App\Models\Position::with('candidates')->get();
        return $positions;
    }
    public function loadSettings(){
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
}
