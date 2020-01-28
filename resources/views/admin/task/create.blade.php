@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-8">
    <div class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Create New Task
      </h3>

      @if( Session::get('success') )
        <div class="alert alert-success container" id="div3">
            <strong>Success!</strong> {{Session::get('success')}}
        </div>
      @endif

      
      @if( Session::get('err') )
      <div class="alert alert-danger container" id="div3">
        <strong>Error!</strong> {{Session::get('err')}}
      </div>
      @endif

      @if ($errors->any())
      <div class="form-group row">
        <div class="col-md-12">
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @endif

      

      <form method="POST" action="{{ route('admin.task.create') }}" enctype="multipart/form-data">
       @csrf
       <div class="form-group">
          <select name="client_name" id="client_name" class="selectpicker form-control select-search" data-live-search="true">
            <option value="">SELECT CLIENT NAME</option>
            @foreach ($clients as $client)
              <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
          </select>
        </div>
      
       <div class="form-group">
         <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title') }}">
       </div>

       <div class="form-group">
         <textarea name="details" id="details" class="form-control" cols="30" rows="5" placeholder="Enter details">{{ old('details') }}</textarea>
       </div>

       <div class="form-group">
        <select name="user_name" id="user_name" class="selectpicker form-control select-search" data-live-search="true">
          <option value="">ASSIGN TO USER</option>
          @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="custom-file mb-3">
        <label class="custom-file-label" for="file_upload">Choose file...</label>
        <input type="file" name="task_files[]" class="custom-file-input" id="file_upload" multiple required>
      </div>

      <button type="submit" class="btn btn-primary">Create Task</button>
      </form>
     </div>
    </div>
   </div>
 </div>
</div>
@endsection


@section('customJS')
<script>
  // For name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = this.files.length;
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName +' files selected');
  });
  </script>
@endsection