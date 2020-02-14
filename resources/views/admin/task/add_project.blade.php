@extends('layouts.final_layout')

@section('content')
<div class="row mt-2">
 <div class="col-12">
  <div class="card">
     <div class="card-header">
      <div class="row">
       <div class="col-sm-10">
        <h3>Add Project</h3>
       </div>
       <div class="col-md-2 project__btn">
        <a href="{{route('admin.task.all')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Project's List">
         <span>PROJECT'S LIST</span>
        </a>
       </div>
      </div>
     </div>
     <div class="card-body">
   
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
   
      <form method="POST" id="add-project" action="{{ route('admin.task.create') }}">
       @csrf
   
       <div class="form-group row">
          <label for="title" class="col-sm-2 col-form-label">Project Title: </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" placeholder="Project Title">
          </div>
       </div>
       
       <div class="form-group row">
          <label for="details" class="col-sm-2 col-form-label">Project Details: </label>
          <div class="col-sm-10">
            <textarea name="details" class="form-control" id="details" cols="30" rows="4" placeholder="Other details">{{ old('details') }}</textarea>
          </div>
       </div>
           
       <div class="form-group row">
          <label for="client_name" class="col-sm-2 col-form-label">Client: </label>
          <div class="col-sm-10">
           <div class="row">
            <div class="col-11">
              <select name="client_name" id="client_name" class="selectpicker form-control select-search" data-live-search="true">
                <option value="">Please Choose</option>
                @foreach ($clients as $client)
                  <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-1 project__btn">
             <a href="{{route('admin.client.create')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Add Client">
              <span><i class="fa fa-plus"></i></span>
             </a>
            </div>
           </div>
          </div>
       </div>
           
       <div class="form-group row">
          <label for="project_manager_name" class="col-sm-2 col-form-label">Project Manager: </label>
          <div class="col-sm-10">
           <div class="row">
            <div class="col-11">
              <select name="project_manager_name" id="project_manager_name" class="selectpicker form-control select-search" data-live-search="true">
                <option value="">Please Choose</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-1 project__btn">
             <a href="{{route('admin.user.create')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Add Manager">
              <span><i class="fa fa-plus"></i></span>
             </a>
            </div>
           </div>
          </div>
       </div>
   
       <div class="row justify-content-end">
         <button id="cancel" class="btn btn-danger mr-2">Cancel</button>
         <button type="submit" class="btn btn-primary mr-3">Add</button>
       </div>
      </form>
   </div>
 </div>
 </div>
</div>
@endsection
@section('customJS')
   <script>
    $('#cancel').click((e)=>{
      e.preventDefault();
      $('#add-project')[0].reset();
      $("button[data-id='client_name'] div.filter-option-inner-inner").html("Please Choose");
      $("button[data-id='project_manager_name'] div.filter-option-inner-inner").html("Please Choose");
    });
   </script>
@endsection