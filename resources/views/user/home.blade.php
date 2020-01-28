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
      @foreach ($user->tasks as $task)    
      <div class="card mb-2">
        <div class="card-header">
        <div class="row">
          <div class="col-10">
          <blockquote class="blockquote mb-0">
            <h3><a href="{{ route('user.task.view', $task->slug) }}">{{ $task->title }} </a><small class="text-muted posted-text"> Posted {{ $task->created_at->diffForHumans() }}</small></h3>
            
            {{-- @if (count($task->users))    
            <footer class="blockquote-footer">{{ $task->users[0]->name }}</cite></footer>
            @endif --}}
            
          </blockquote>
          </div>
          <div class="col-2">
          <center>
            <a href="{{route('user.task.view', $task->slug)}}" class="add-btn" data-toggle="tooltip" data-placement="bottom" title="View Task">
                <i class="fa fa-eye" style="font-size: 1.3rem;color: teal"></i></span>
            </a>
          </center>
          </div>
        </div>
        </div>
        <div class="card-body">
          <p class="card-text">{{ $task->details }}</p>
          {{-- @if(count($task->users) > 1)
            <a href="{{ route('admin.notify.client', $task->id) }}" class="btn btn-primary">Notify Client</a>
          @endif  --}}
        </div>
      </div>
      @endforeach

      @if (count($user->tasks) == 0)
        <div class="card">
            <ul class="card-body justify-content-center">
                <h3 class="card-text text-center">Not Task available for you.</h3>
            </ul>
        </div>          
      @endif

   </div>

 </div>
</div>
@endsection