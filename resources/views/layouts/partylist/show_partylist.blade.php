@extends('layouts.app')


@section('content')
<h1>Party List</h1>

    @if (!$partyList->isEmpty())
        <ul>
        @foreach($partyList as $item)
            <li>{{$item->name}}</li>
            
        @endforeach
        </ul>
        
    @else
        <h3>no items</h3>

    @endif
    <a href="/partylist/create"><button>add</button> </a>



@endsection