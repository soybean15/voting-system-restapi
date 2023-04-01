@extends('layouts.app')

@section('content')
<h2>{{$position->name}}</h2>
<h2>Add Candidate</h2>
    <form method="POST" action="/candidate/store">

        <input type="hidden" name="position_id" value="{{$position->id}}" required>
        <div class="form-group">

            <input type="text" name="name" placeholder="Enter Name" required>
        </div>
        {{csrf_field()}}

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>
@endsection