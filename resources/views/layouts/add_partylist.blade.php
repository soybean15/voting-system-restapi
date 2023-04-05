@extends('layouts.app')

@section('content')

<h2>Add PartyList</h2>
    <form method="POST" action="/partylist" enctype="multipart/form-data">

        <div class="form-group">

            <input type="text" name="name" placeholder="Enter Name" required>
        </div>
        {{csrf_field()}}


        <input class="btn btn-primary" type="file" name="image" value="Save">

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>
@endsection