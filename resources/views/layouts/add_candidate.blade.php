@extends('layouts.app')

@section('content')
<h2>{{$position->name}}</h2>
<h2>Add Candidate</h2>
    <form method="POST" action="/candidate/store" enctype="multipart/form-data">

        <div class="form-group">

            <input type="text" name="name" placeholder="Enter Name" required>
        </div>
        {{csrf_field()}}

        <div class="form-group mb-3">
            <label for="name">PartyList:</label>

            <select name="party_list_id">Select PartyList
                <option value=""> Independent </option>
                @foreach ($partylists as $partylist)
                    <option value="{{ $partylist->id}}" >{{$partylist->name }}</option>
                @endforeach
            </select>

        </div>
        <input class="btn btn-primary" type="file" name="image" value="Save">

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>
@endsection