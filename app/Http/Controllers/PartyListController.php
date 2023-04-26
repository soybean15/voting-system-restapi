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
        $partyList = PartyList::with('candidates')->paginate(5);
       // return view('layouts.partylist.show_partylist', compact('partyList'));
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
        $request->validate([
            'name'=> 'required'
        ]);

        $partyList = new PartyList(['name'=>$request->name]);
        if ($file = $request->file('image')){
            $partyList->storeImage('images/partylist/', $file);
                              
        }
        $partyList->save();
     
        $partyLists = PartyList::with('candidates')->paginate(5);
        return response()->json([
            
            "status" =>[
                "status" => 1,
                "message" => "Data added successfully"
            ],
            "data"=>$partyLists
        ]);
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

        $name = $request->input('name');
        $image = $request->file('image');

        $partylist->name = $name;
        //$partylist->image=$image;


        if($file =  $request->file('image')){
            $partylist->restoreImage('images/partylist/', $file);

        }        
        $partylist->save();


       $partyLists = PartyList::with('candidates')->paginate(5);
        return response()->json([
            
            "status" =>[
                "status" =>$id,
                "message" =>"Updated Successfully"
            ],
            "data"=>$partyLists
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partylist = PartyList::find($id);
        $partylist ->unlinkImage();
        $partylist->delete();

 
        return   response()->json([
            "status" => 1,
            "message" => "Data Deleted"
        ]);;
  

    }
}
