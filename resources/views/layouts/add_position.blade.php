@extends('layouts.app')

@section('content')
<h2>Add New Position</h2>
    <form method="POST" action="/candidate">

       
        <div class="form-group">

            <input type="text" name="name" placeholder="Enter New Position" required>
          
        </div>
        <div>
             <input type="number" name="winner_count" placeholder="Enter Winner count" required>

        </div>
        {{csrf_field()}}

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>
@endsection