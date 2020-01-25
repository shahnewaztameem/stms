@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-8">
    <div class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Edit Task
      </h3>

      @if( Session::get('success') )
        <div class="alert alert-success container" id="div3">
            <strong>Success!</strong> {{Session::get('success')}}
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

      

      <form method="POST" action="{{ route('admin.task.edit', $task->id) }}">
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

       <button type="submit" class="btn btn-primary">Edit Task</button>
      </form>
     </div>
    </div>
   </div>
 </div>
</div>
@endsection