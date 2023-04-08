
<h2>{{$position->name}}</h2>
<h2>Edit Candidate</h2>
    <form method="POST" action="{{route('candidate.update',$candidate->id)}}" enctype="multipart/form-data">
        {{$candidate->id}}

        <img height="90" src="{{ asset($candidate->image) }}">
      
        <div class="form-group">

            <input type="text" name="name" placeholder="Enter Name"  value="{{ $candidate->name }}" >
        </div>
        {{csrf_field()}}

        <input type="hidden" name="_method" value="PUT">


        <input class="btn btn-primary" type="file" name="file" value="Save" id="fileToUpload"  >

        <input class="btn btn-primary" type="submit" name="submit" value="Save">

    </form>
