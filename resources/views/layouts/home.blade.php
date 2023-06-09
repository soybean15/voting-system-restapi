@extends('layouts.app')

@section('content')
<h1>Candidates</h1>
<ul>
    @if(!$positions->isEmpty())
        @foreach ($positions as $position)

            <li>Position: {{$position->name}} <br>
          
                 <a href="/api/candidate/position/{{ $position->id }}"><button >Add Candidate</button></a>
                <a href="{{route('candidate.edit_position',$position->id)}}"> <button > Edit Position</button></a>
                <form action="{{ route('candidate.destroy_position', $position->id) }}" method="POST">
                    @csrf
                   

                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <ul>
                    @if(!$position->candidates->isEmpty())
                        @foreach ($position->candidates as $candidate )
                            <li>
                               <img src ="{{asset($candidate->image)}} " height="90"/> {{$candidate->name}}   {{asset($candidate->image)}}<br>
                               PartyList: {{$candidate->party_list_name}}
                              <br> <a class="" href="{{route('candidate.edit', $candidate)}}">Edit</a>
                               <form action="{{route('candidate.destroy',$candidate->id)}}" method="POST">
                                @csrf                            
                                @method('DELETE')
                                
                                  <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            </li>
                        
                        @endforeach
                    @endif
                </ul>
                
            </li>
            
            
        @endforeach

    @endif

</ul>
<a href="{{route('candidate.create')}}"><button>Add</button></a>
@endsection