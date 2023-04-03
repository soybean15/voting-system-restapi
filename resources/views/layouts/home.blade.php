@extends('layouts.app')

@section('content')
<h1>Candidates</h1>
<ul>
    @if(!$positions->isEmpty())
        @foreach ($positions as $position)
            
            <li>Position: {{$position->name}} <a href="/candidate/position/{{ $position->id }}/add"><button >Add Candidate</button></a>
                <ul>
                    @if(!$position->candidates->isEmpty())
                        @foreach ($position->candidates as $candidate )
                            <li>
                               <img src ="{{ $candidate->image }} " height="90"/>        {{$candidate->name}}
                            </li>
                        
                        @endforeach
                    @endif
                </ul>
                
            </li>
            
            
        @endforeach

    @endif

</ul>
<a href="/candidate/create"><button>Add</button></a>
@endsection