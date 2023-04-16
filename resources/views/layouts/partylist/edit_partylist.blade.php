@extends('layouts.app')

@section('content')
<h1>Add Party List</h1>

    <form method="POST" action="{{route('partylist.update', $partylist->id)}}"  enctype="multipart/form-data">
        @method('PUT')
        <div class="form-group">

            <input type="text" name="name" placeholder="Enter Name" required value="{{$partylist->name}}">
        </div>
        {{csrf_field()}}


        <input class="btn btn-primary" type="file" name="image" value="Save">

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>


@endsection
