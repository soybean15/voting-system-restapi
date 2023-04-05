<?php

namespace App\Http\Controllers;
use App\Models\PartyList;
use Illuminate\Http\Request;

class PartyListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.show_partylist');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.add_partylist');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $candidate = new PartyList;
        $candidate ->name= $request ->input('name');
      
      
        if ($request->hasfile('image')){
          $file = $request->file('image');
          $extension = $file->getClientOriginalEXtension();
          $filename= time(). '.' . $extension;
          $file->move('images/candidates/', $filename);
          $candidate->image = $filename;
        }
  
        $candidate->save();
         
         return redirect()->route('partylist.create')
                          ->with('status', 'Candidate added successfully');
         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
