@extends('layouts.app')

@section('content')
<h2>Edit Position</h2>
    <form method="POST" action="/candidate/position/{{ $position->id}}">

       
        <div class="form-group">

            <input type="text" name="name" placeholder="Enter New Position" value={{$position->name}} required>
          
        </div>
        <div>
             <input type="number" name="winner_count" placeholder="Enter Winner count" value={{$position->winner_count}} required>

        </div>
        {{csrf_field()}}

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>
@endsection