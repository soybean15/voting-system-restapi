@extends('layouts.app')


@section('content')
<h1>Party List</h1>

    @if (!$partyList->isEmpty())
        <ul>
        @foreach($partyList as $item)
            <li>{{$item->name}}
                 <a href="{{route('partylist.edit', $item->id)}}"><button>Edit</button> </a>
                 <form action="{{route('partylist.destroy',$item->id)}}" method="POST">
                    @csrf                            
                    @method('DELETE')
                    
                      <button type="submit" class="btn btn-danger">Delete</button>
                </form>
               </li>
           
            
        @endforeach
        </ul>
        
    @else
        <h3>no items</h3>

    @endif
    <a href="{{route('partylist.create')}}"><button>add</button> </a>



@endsection