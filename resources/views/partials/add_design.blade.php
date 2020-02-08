<div class="row mt-2">
 <div class="col-12">
  <div class="card">
     <h3 class="card-header">Add Project Design</h3>
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
          <textarea name="details" class="form-control" id="details" cols="30" rows="3" placeholder="Other details">{{ old('details') }}</textarea>
        </div>
       </div>
           
       <div class="form-group row">
        <label for="client_name" class="col-sm-2 col-form-label">Start/ End Date: </label>
        <div class="row col-sm-10">
         <div class="col-5">
          <div class="input-group" style="border-bottom: none">
           <input type="text" class="form-control datepicker" name="start_date" placeholder="Start Date">
           <div class="input-group-append">
             <span class="input-group-text" style="border: 1px solid #ced4da">
              <i class="fa fa-calendar" style="font-size: 1.3rem"></i>
             </span>
           </div>
          </div>
          </div>
          <div class="col-5">
           <div class="input-group" style="border-bottom: none">
            <input type="text" class="form-control datepicker" name="end_date" placeholder="End Date">
            <div class="input-group-append">
              <span class="input-group-text" style="border: 1px solid #ced4da">
               <i class="fa fa-calendar" style="font-size: 1.3rem"></i>
              </span>
            </div>
           </div>
          </div>
        </div>
        </div>
           
       <div class="form-group row">
        <label for="client_name" class="col-sm-2 col-form-label">Project Manager: </label>
        <div class="col-sm-10">
         <select name="client_name" id="client_name" class="selectpicker form-control select-search" data-live-search="true">
          <option value="">Please Choose</option>
          @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
      
       <div class="form-group row">
        <label class="col-sm-2 col-form-label">Wireframes: </label>
        <div class="col-sm-10">
          <div class="custom-file mb-3">
            <label class="custom-file-label" for="file_upload">Choose file...</label>
            <input type="file" name="task_files[]" class="custom-file-input" id="file_upload" multiple required>
          </div>
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