@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-8">
    <div class="card mb-3">
     <div class="card-body">
      <h3 class="text-center my-3">
       Edit Task
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

      

      <form method="POST" action="{{ route('admin.task.edit', $task->id) }}" enctype="multipart/form-data">
       @csrf
       <div class="form-group">
          <select name="client_name" id="client_name" class="selectpicker form-control select-client" data-live-search="true">
            <option value="">SELECT CLIENT NAME</option>
            @foreach ($clients as $client)
              <option @if(count($task->users)) @if($task->users[0]->id == $client->id) selected @endif @endif value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
          </select>
        </div>
      
       <div class="form-group">
         <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ $task->title }}">
       </div>

       <div class="form-group">
         <textarea name="details" id="details" class="form-control" cols="30" rows="5" placeholder="Enter details">{{ $task->details }}</textarea>
       </div>

       <div class="form-group">
        <select name="user_name" id="user_name" class="selectpicker form-control select-client" data-live-search="true">
          <option value="">ASSIGN TO USER</option>
          @foreach ($users as $user)
            <option @if(count($task->users) > 1) @if($task->users[1]->id == $user->id) selected @endif @endif value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
      </div>

      
      <div class="custom-file mb-3">
        <label class="custom-file-label" for="file_upload">Choose file...</label>
        <input type="file" name="task_files[]" class="custom-file-input" id="file_upload" multiple>
      </div>

      <button type="submit" class="btn btn-primary">Edit Task</button>
      </form>
     </div>
    </div>

  
    @if (count($task->task_files))
      <div class="card">
        <div class="card-body">
            <p class="card-text"><strong>Attached Files: </strong></p>
            <ul class="list-group">
              @foreach ($task->task_files as $file)
                <li class="list-group-item list-group-item-default">
                  <div class="row">
                    <div class="col-10">
                        <a href="{{ asset($file->file_url) }}" target="_blank">{{ $file->file_url }}</a>
                    </div>
                    <div class="col-2">
                      <center>

                        {{-- <a href="{{route('user.file.edit', [$task->id, $file->id])}}" class="edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit Feedback">
                            <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                        </a> --}}
                        
                        {!! Form::open(['method' => 'DELETE','route'=> ['admin.file.delete', $file->id], 'style' => 'display:inline']) !!}
                        {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove File','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                        {!! Form::close()!!}
                      </center>
                    </div>
                  </div>
                </li>
                
                <div role="separator" class="dropdown-divider"></div>
              @endforeach
            </ul>
        </div>
      </div>
    @endif

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