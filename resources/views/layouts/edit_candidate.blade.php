
<h2>{{$position->name}}</h2>
<h2>Edit Candidate</h2>
    <form method="POST" action="/candidate/{{ $candidate->id}}" enctype="multipart/form-data">
        {{$candidate->id}}
      
        <div class="form-group">

            <input type="text" name="name" placeholder="Enter Name"  value="{{ $candidate->name }}" >
        </div>
        {{csrf_field()}}

        <input type="hidden" name="_method" value="PUT">


        <input class="btn btn-primary" type="file" name="image" value="Save"  value="{{ $candidate->image }}">

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>
