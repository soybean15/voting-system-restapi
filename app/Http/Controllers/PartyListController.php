<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartyList;

class PartyListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $partyList = PartyList::with('candidates')->get();
       return view('layouts.partylist.show_partylist', compact('partyList'));
        return response()->json([
            "status" => 1,
            "data" => $partyList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('layouts.partylist.add_partylist');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $partyList = new PartyList(['name'=>$request->name]);
        if ($file = $request->file('image')){
            $partyList->storeImage('images/partylist/', $file);
                              
        }
        $partyList->save();
        return redirect('/api/partylist');
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
        $partylist = PartyList::find($id);
        return view('layouts.partylist.edit_partylist',compact('partylist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $updatedPartylist =$request->all();
        
        $partylist= PartyList::find($id); 

        if($file =  $request->file('file')){
            $partylist->restoreImage('images/partylist/', $file);

        }

        
        $partylist->update($updatedPartylist);



       return redirect('api/partylist');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partylist = PartyList::find($id);
        // $partylist ->unlinkImage();
        $partylist->delete();

 
        return redirect('api/partylist');
  
    }
}
