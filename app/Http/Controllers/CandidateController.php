<?php

namespace App\Http\Controllers;
use App\Models\Candidate;
use App\Models\Position;

use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        //test
        $positions = \App\Models\Position::with('candidates')->get();
     
     //   return view('layouts.home',compact('positions'));
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

      
       // return $id;
        // $id = $request->position_id;
        // $position =\Session::get('position_object');
       
        // $candidate = Candidate::find($id); 

        // $name = $request->name;
        // $candidate = new \App\Models\Candidate(['name'=>$name]);

        // // $candidate ->name = $request ->input ('name');
        // if ($request->hasfile('image')){
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalEXtension();
        //     $filename= time(). '.' . $extension;
        //     $file->move('images/candidates/', $filename);
        //     $candidate->image = $filename;
        //   }
        //   $candidate->update($request->all());

      
        $updatedCandidate =$request->all();
        
        $candidate= Candidate::find($id); 
        //return $candidate->getRawImageAttribute();
        if($file =  $request->file('file')){

            if($candidate->getRawImageAttribute() != '' && $candidate->getRawImageAttribute() != null){
                         
                if( $file_old = $candidate->getRawImageAttribute()){
                    unlink($file_old);
                }
                       
              
            }

      
            $extension = $file->getClientOriginalEXtension();
            $filename= time(). '.' . $extension;
            $file->move('images/candidates/',$filename);
            $candidate['image']= $filename;
    


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
        $position = \App\Models\Position::findOrFail($id);
        \Session::put('position_object',$position);
        \Session::save();
        return view('layouts.add_candidate',compact('position'));
    }

    public function storeCandidate(Request $request){ 

        $id = $request->position_id;
        $position =\Session::get('position_object');

        $name = $request->name;
        $candidate = new \App\Models\Candidate(['name'=>$name]);
        if ($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalEXtension();
            $filename= time(). '.' . $extension;
            $file->move('images/candidates/', $filename);
            $candidate->image = $filename;
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
