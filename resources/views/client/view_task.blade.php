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
         
         @if (count($task->users) > 1)
          <p class="card-text"><strong>Assigned User Info: </strong></p> 
           @foreach ($task->users as $user)
            @if ($user->user_type == 2)
            <p class="card-text">User Name: {{ $user->name }}</p>
            <p class="card-text">User Email: {{ $user->email }}</p>
            @endif
           @endforeach
          @endif



          @if (count($task->task_files))
          
          <div role="separator" class="dropdown-divider"></div>
          
          <p class="card-text"><strong>Attachment From User: </strong></p>
          <ul class="list-group">
            @foreach ($task->task_files as $file)
             <li class="list-group-item list-group-item-default">
              <a href="{{ asset($file->file_url) }}" target="_blank">{{ $file->file_url }}</a>
             </li>
             
             <div role="separator" class="dropdown-divider"></div>
            @endforeach
          </ul>
          @endif

       </div>
      </div>

      <div class="card">
       <div class="card-body">
        
        @if ($task->feedback)
        <div class="row">
         <div class="col-10">
          <strong>You Rate :</strong> {{$task->feedback->rating}}/5
          <p class="card-text"><strong>Comment :</strong>{{ $task->feedback->comment }}</p>
         </div>
         <div class="col-2">
          <center>

           {{-- <a href="{{route('client.feedback.edit', [$task->id, $task->feedback->id])}}" class="edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit Feedback">
               <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
           </a> --}}
           
           {!! Form::open(['method' => 'DELETE','route'=> ['client.feedback.delete', $task->feedback->id], 'style' => 'display:inline']) !!}
           {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove Feedback','onclick'=>'return confirm("Are you want to delete?")'])  !!}
           {!! Form::close()!!}
          </center>
         </div>
        </div>
        
        @else

        <blockquote class="blockquote mb-0">
         <h3 class="text-center">
          Give Feedback
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

        <div role="separator" class="dropdown-divider"></div>

        <div class="col-10 offset-1">
         <form action="{{ route('client.feedback', $task->id) }}" method="post">
          @csrf
          <div class="form-group">
           <div class="stars">
            <input type="radio" name="star" value="1" class="star-1" id="star-1" />
            <label class="star-1" for="star-1">1</label>
            <input type="radio" name="star" value="2" class="star-2" id="star-2" />
            <label class="star-2" for="star-2">2</label>
            <input type="radio" name="star" value="3" class="star-3" id="star-3" />
            <label class="star-3" for="star-3">3</label>
            <input type="radio" name="star" value="4" class="star-4" id="star-4" />
            <label class="star-4" for="star-4">4</label>
            <input type="radio" name="star" value="5" class="star-5" id="star-5" />
            <label class="star-5" for="star-5">5</label>
            <span></span>
           </div>
          </div>

          <div class="form-group">
           <textarea class="form-control" name="comment" id="comment" cols="30" rows="3" placeholder="Enter Comment"></textarea>
          </div>

          <div role="separator" class="dropdown-divider"></div>

          <div class="form-group row mb-0">
           <div class="col-md-4 offset-md-4 text-center">
             <button type="submit" class="btn btn-primary">
                 {{ __('Submit Feedback') }}
             </button>
           </div>
          </div>

         </form>
        </div>
        {{-- END OF FEEDBACK  --}}       
        @endif
       </div>
      </div>
   </div>
 </div>
</div>
@endsection