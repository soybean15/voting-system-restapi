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


        
        $positions = \App\Models\Position::paginate(5);
        $partyLists = PartyList::all();
        $candidates = Candidate::whereNull('position_id')->orWhere('position_id', '')->get();


     
   //  return view('layouts.home',compact('positions','partyLists'));
        return response()->json([
            "status" => 1,
            "data" => [
                "positions"=>$positions,
                "partylist"=>$partyLists,
                "candidates"=>$candidates
            ]
        ]);
    }

    public function insertCandidates(String $id,Request $request){
        
        return response()->json([
            "id"=>$id,
            "status" => $request->all()
            
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
       

        $request->validate([
            'name'=> 'required',
            'voteCount'=>'required'
        ]);

         $position = $request->all();


     
        \App\Models\Position::create($position);
        return response()->json([
            "status" => 1,
            "message" => 'New Position Added'
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

        $name = $request->name;
        $party_list_id = $request->party_list_id;
        
        $candidate= Candidate::find($id); 
        $candidate->name = $name;
        $candidate->party_list_id = $party_list_id;

        if($file =  $request->file('image')){
            $candidate->restoreImage('images/candidates/', $file);

        }

        $candidate->save();
       // $candidate->update($updatedCandidate);



       return response()->json([
            "status" => 1 ,
            "message" => 'Successfully updated'
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id )
    {


        $candidate = \App\Models\Candidate::find($id);
        $candidate->unlinkImage();
        $candidate->delete();

 
     //   return redirect('api/candidate')->with('success' , 'Candidate has been deleted successfully'); 
        return response()->json([
            "status" => 1,
            "message" => 'Candidate Deleted!'
        ]);
  
    }




    public function createCandidate(String $id){


        
        $partylists = PartyList::all();
      
        $position = \App\Models\Position::findOrFail($id);

  
        return view('layouts.add_candidate',compact('position','partylists'));
    }

    public function storeCandidate(Request $request){ 



        $request->validate([
            'name'=> 'required',
           
        ]);



        
        $candidate = new \App\Models\Candidate(['name'=>$request->name]);
        $candidate->partylist()->associate($request->party_list_id); 
        
        if ($file = $request->file('image')){
            $candidate->storeImage('images/candidates/', $file);                          
        }
            
        if($request->position_id != null){
            $position = \App\Models\Position::findOrFail($request->position_id);
            $position->candidates()->save($candidate);
        }else{
            $candidate->save();
        }
        
       
        

        return response()->json([
            "status" => 1,
            "message" => "New Candidate Added"
        ]);
      
    }



    public function destroyPosition(string $id )

    {
 
        $position = Position::findOrFail($id);
        $candidates =$position->candidates;
        foreach ($candidates as $candidate){
            $candidate->unlinkImage();
        }
        $position->delete();
        return redirect('api/candidate'); 
  
     
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

       return redirect('api/candidate');
    }


    public function getCandidates(){
        $candidates = Candidate::with('position')->paginate(5);
        $partyLists = PartyList::all();
        
        return response()->json([
            "status" => 1,
            "data" => [
                "partylist"=>$partyLists,
                "candidates"=>$candidates
            ]
        ]);

    }



  
}
