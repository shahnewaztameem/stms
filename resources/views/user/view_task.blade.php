@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-10">
      @if( Session::get('success') )
      <div class="alert alert-success container" id="div3">
        <strong>Success!</strong> {{Session::get('success')}}
      </div>
      @endif

      <div class="card mb-3">
       <div class="card-body">

        <blockquote class="blockquote mb-0">
         <h3>{{ $task->title }}<small class="text-muted posted-text"> Posted {{ $task->created_at->diffForHumans() }}</small>
         </h3>
        </blockquote>

        <div role="separator" class="dropdown-divider"></div>

         <p class="card-text">{{ $task->details }}</p>

         <div role="separator" class="dropdown-divider"></div>
         
         @if (count($task->users))
          <p class="card-text"><strong>Task Owner Info: </strong></p> 
           @foreach ($task->users as $user)
            @if ($user->user_type == 1)
            <p class="card-text"><strong>Client Name:</strong> {{ $user->name }}</p>
            <p class="card-text"><strong>Client Email:</strong> {{ $user->email }}</p>
            @endif
           @endforeach
          @endif


          @if ($task->feedback)
          <div role="separator" class="dropdown-divider"></div>
          <div class="row">
           <div class="col-10">
            <strong>Client Rate :</strong> {{$task->feedback->rating}}/5
            <p class="card-text"><strong>Client Comment :</strong>{{ $task->feedback->comment }}</p>
           </div>
          </div>
          @endif

       </div>
      </div>

      @if (count($task->task_files))
        <div class="card mb-3">
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
                          
                          {{-- {!! Form::open(['method' => 'DELETE','route'=> ['user.file.delete', $file->id], 'style' => 'display:inline']) !!}
                          {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove File','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                          {!! Form::close()!!} --}}
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

      {{-- <div class="card">
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <h3 class="text-center">
              Add Attachment
            </h3>
          </blockquote>

          @if ($errors->any())
            <div class="form-group row">
                <div class="col-md-8 offset-md-2">
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


          @if( Session::get('err') )
            <div class="alert alert-danger container" id="div3">
              <strong>Error!</strong> {{Session::get('err')}}
            </div>
          @endif

          <div role="separator" class="dropdown-divider"></div>

          <div class="col-8 offset-2">
            <form action="{{ route('user.file.create', $task->id) }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="custom-file mb-3">
                <label class="custom-file-label" for="file_upload">Choose file...</label>
                <input type="file" name="task_files[]" class="custom-file-input" id="file_upload" multiple required>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-4 offset-md-4 text-center">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Upload File') }}
                  </button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div> --}}
      {{-- END OF FILE UPLOAD  --}}
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