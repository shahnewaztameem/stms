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
      @foreach ($tasks as $task)    
      <div class="card mb-2">
        <div class="card-header">
        <div class="row">
          <div class="col-10">
          <blockquote class="blockquote mb-0">
            <h3>{{ $task->title }} <small class="text-muted posted-text"> Posted {{ $task->created_at->diffForHumans() }}</small></h3>
            
            @if (count($task->users))    
            <footer class="blockquote-footer">{{ $task->users[0]->name }}</cite></footer>
            @endif
            
          </blockquote>
          </div>
          <div class="col-2">
          <center>
            <a href="{{route('admin.task.create')}}" class="add-btn" data-toggle="tooltip" data-placement="bottom" title="Add Task">
                <i class="fa fa-plus" style="font-size: 1.3rem;color: teal"></i></span>
            </a>

            <a href="{{route('admin.task.edit',$task->id)}}" class="edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit Task">
                <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
            </a>
            
            {!! Form::open(['method' => 'DELETE','route'=> ['admin.task.delete', $task->id], 'style' => 'display:inline']) !!}
            {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
            {!! Form::close()!!}
          </center>
          </div>
        </div>
        </div>
        <div class="card-body">
          <p class="card-text">{{ $task->details }}</p>
          @if(count($task->users) > 1)
            <a href="{{ route('admin.notify.client', $task->id) }}" class="btn btn-primary">Notify Client</a>
          @endif 
        </div>
      </div>
      @endforeach
   </div>
 </div>
</div>
@endsection