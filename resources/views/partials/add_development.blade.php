<div class="row mt-2">
  <div class="col-12">
   <div class="card">
   <form method="POST" action="{{ route('admin.task.create-development-phase') }}">
     <div class="card-header">
       <div class="d-flex justify-content-between">
         <span class="h3">Add Project Development URL</span>
         <div>
           <div class="custom-control custom-switch">
             <input type="checkbox" name="show_to_client" class="custom-control-input" id="customSwitchDevelopment">
             <label class="custom-control-label" for="customSwitchDevelopment">Show To Client</label>
           </div>
         </div>
       </div>
     </div>
      <div class="card-body">
    
       @if( Session::get('successDevelopment') )
         <div class="form-group row">
             <div class="col-md-12">
               <div class="alert alert-success" id="div3">
                   <strong>Success!</strong> {{Session::get('successDevelopment')}}
               </div>
             </div>
         </div>
       @endif
    
       @if( Session::get('errDevelopment') )
         <div class="form-group row">
           <div class="col-md-12">
             <div class="alert alert-danger" id="div3">
               <strong>Error!</strong> {{Session::get('errDevelopment')}}
             </div>
           </div>
         </div>
       @endif
    
       @if( Session::get('tab') == "development")
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
       @endif
    
        @csrf
    
        <div class="form-group row">
         <label for="dev_project_title" class="col-sm-2 col-form-label">Project Title: </label>
         <div class="col-sm-10">
          <select name="project_title" id="dev_project_title" class="selectpicker form-control select-search" data-live-search="true">
           <option value="">Please Choose</option>
           @foreach ($tasks as $task)
             <option value="{{ $task->id }}">{{ $task->title }}</option>
           @endforeach
          </select>
         </div>
        </div>
        
        <div class="form-group row">
         <label for="dev_project_details" class="col-sm-2 col-form-label">Project Details: </label>
         <div class="col-sm-10">
           <textarea name="project_details" class="form-control" id="dev_project_details" readonly cols="30" rows="3" placeholder="Other details"></textarea>
         </div>
        </div>
            
           
       <div class="form-group row">
          <label for="repo_url" class="col-sm-2 col-form-label">Repo URL: </label>
          <div class="col-sm-10">
            <input type="url" class="form-control" name="repo_url" id="repo_url" value="{{ old('repo_url') }}" placeholder="Project Repository URL">
          </div>
        </div>

        <div class="form-group row">
         <label for="dev_pm_name" class="col-sm-2 col-form-label">Dev PM: </label>
         <div class="col-sm-10" id="dev_pm_user">
          <select name="dev_pm_name" id="dev_pm_name" class="selectpicker form-control select-search" data-live-search="true">
           <option value="">Please Choose</option>
           @foreach ($users as $user)
             <option value='{{ $user->id }}'>{{ $user->name }}</option>
           @endforeach
          </select>
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
{{--  
 @section('customJS')
     <script>
       $('#dev_project_title').on('change', (event) => {
         console.log(event.target.value);
         if (event.target.value) {
           $.ajax({
             type: 'GET',
             url: '/project-details/development/'+event.target.value,
             success: (res) => {
               console.log(res);
               let task = res.data;
               $('#dev_project_details').val(task.details);
 
               if (task.dev_phase) {
                 if(task.dev_phase.show_to_client){
                   $('#customSwitchDevelopment').attr('checked', 'checked');
                 }else{
                   $('#customSwitchDevelopment').removeAttr('checked');
                 }
                 $('#repo_url').val(task.dev_phase.repo_url);
                 $("#dev_pm_name").val(task.dev_phase.dev_pm_id);
                 $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html(task.dev_phase.dev_pm.name);
               }else{
                 $('#repo_url').val('');
      
                 $("#dev_pm_name").val('');
                 $('#customSwitchDevelopment').removeAttr('checked');
                 $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html("Please Choose");
               }
             },
             error: (err) => console.log(err)
           });
         }
         $('#customSwitchDevelopment').removeAttr('checked');
         $('#dev_project_details').val('');
         $('#repo_url').val('');
         $("#dev_pm_name").val('');
         $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html("Please Choose");
 
       })
     </script>
 @endsection --}}