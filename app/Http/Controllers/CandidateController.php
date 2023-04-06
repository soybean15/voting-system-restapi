<?php

namespace App\Http\Controllers;
use App\Models\Candidate;
use App\Models\Position;
use App\Models\PartyList;

use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        
        $positions = \App\Models\Position::with('candidates')->get();
        $partylist = \App\Models\PartyList::with('candidates')->get();
     
       return view('layouts.home',compact('positions','partylist'));
        return response()->json([
            "status" => 1,
            "data" => $positions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('layouts.add_position');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $position = $request->all();

     
        \App\Models\Position::create($position);
        return redirect('/candidate');
        
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
    public function edit(String $id)
    {  
            
        $candidate = Candidate::find($id);
        $position = $candidate->position;
        return view('layouts.edit_candidate',compact('position', 'candidate'));
  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   

        $updatedCandidate =$request->all();
        
        $candidate= Candidate::find($id); 

        if($file =  $request->file('file')){
            $candidate->restoreImage('images/candidates/', $file);

        }

        
        $candidate->update($updatedCandidate);



       return redirect('/candidate');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate )
    {
        $candidate->delete();
        return redirect('/candidate')->with('success' , 'Candidate has been deleted successfully'); 
  
    }




    public function createCandidate(String $id){
        
        $partylists = PartyList::all();
        \Session::put('position_object',$partylists);

        $position = \App\Models\Position::findOrFail($id);
        \Session::put('position_object',$position);
        \Session::save();
        return view('layouts.add_candidate',compact('position','partylists'));
    }

    public function storeCandidate(Request $request){ 


        $position =\Session::get('position_object');
        $candidate = new \App\Models\Candidate(['name'=>$request->name]);
        $candidate->partylist()->associate($request->party_list_id);
       
        
        if ($file = $request->file('image')){
            $candidate->storeImage('images/candidates/', $file);
                              
        }
            
        $position->candidates()->save($candidate);
        

        return redirect('/candidate');
      
    }



    public function destroyPosition(string $id )

    {
        //return $id;
        $position = Position::findOrFail($id);
        $position->delete();
        return redirect('/candidate')->with('success' , 'Candidate has been deleted successfully'); 
  
    }


    public function editPosition(string $id)
    {

             $position = Position::findorFail($id);
             return view('layouts.edit_position',compact('position')); 

    }

    public function updatePosition(Request $request, $id)
    {   

        $updatedPosition = $request->all();      
        $position= Position::find($id);            
        $position->update($updatedPosition);  

       return redirect('/candidate');
    }


  
}
