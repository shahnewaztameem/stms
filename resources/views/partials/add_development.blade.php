<div class="row mt-2">
 <div class="col-12">
  <div class="card">
     <h3 class="card-header">Add Development URL</h3>
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
   
      <form method="POST" action="{{ route('admin.task.create') }}">
       @csrf
       <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">Project Title: </label>
        <div class="col-sm-10">
          <select name="title" id="title" class="selectpicker form-control select-search" data-live-search="true">
           <option value="">Please Choose</option>
            @foreach ($tasks as $task)
              <option value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
          </select>
        </div>
       </div>
       
       <div class="form-group row">
        <label for="details" class="col-sm-2 col-form-label">Project Details: </label>
        <div class="col-sm-10">
          <textarea name="details" class="form-control" id="details" cols="30" rows="3" placeholder="Project details">{{ old('details') }}</textarea>
        </div>
       </div>

       <div class="form-group row">
        <label for="repo_url" class="col-sm-2 col-form-label">Repo URL: </label>
        <div class="col-sm-10">
         <input type="text" name="repo_url" id="repo_url" class="form-control" placeholder="Repository URL">
        </div>
       </div>
   
       <div class="row justify-content-end">
         <button type="submit" class="btn btn-primary mr-2">Cancel</button>
         <button type="submit" class="btn btn-primary mr-3">Add</button>
       </div>
      </form>
   </div>
 </div>
 </div>
</div>