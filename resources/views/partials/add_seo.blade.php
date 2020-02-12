<div class="row mt-2">
  <div class="col-12">
   <div class="card">
   <form method="POST" action="{{ route('admin.task.create-seo-phase') }}">
     <div class="card-header">
       <div class="d-flex justify-content-between">
         <span class="h3">Add Project SEO</span>
         <div>
           <div class="custom-control custom-switch">
             <input type="checkbox" name="show_to_client" class="custom-control-input" id="customSwitchSEO">
             <label class="custom-control-label" for="customSwitchSEO">Show To Client</label>
           </div>
         </div>
       </div>
     </div>
      <div class="card-body">
    
       @if( Session::get('successSEO') )
         <div class="form-group row">
             <div class="col-md-12">
               <div class="alert alert-success" id="div3">
                   <strong>Success!</strong> {{Session::get('successSEO')}}
               </div>
             </div>
         </div>
       @endif
    
       @if( Session::get('errSEO') )
         <div class="form-group row">
           <div class="col-md-12">
             <div class="alert alert-danger" id="div3">
               <strong>Error!</strong> {{Session::get('errSEO')}}
             </div>
           </div>
         </div>
       @endif
    
       @if( Session::get('tab') == "seo")
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
         <label for="seo_project_title" class="col-sm-2 col-form-label">Project Title: </label>
         <div class="col-sm-10">
          <select name="project_title" id="seo_project_title" class="selectpicker form-control select-search" data-live-search="true">
           <option value="">Please Choose</option>
           @foreach ($tasks as $task)
             <option value="{{ $task->id }}">{{ $task->title }}</option>
           @endforeach
          </select>
         </div>
        </div>
        
        <div class="form-group row">
         <label for="seo_project_details" class="col-sm-2 col-form-label">Project Details: </label>
         <div class="col-sm-10">
           <textarea name="project_details" class="form-control" id="seo_project_details" readonly cols="30" rows="3" placeholder="Project details"></textarea>
         </div>
        </div>
            
           
       <div class="form-group row">
          <label for="seo_keywords" class="col-sm-2 col-form-label">Keywords: </label>
          <div class="col-sm-10">
            <textarea name="seo_keywords" id="seo_keywords" class="form-control" id="seo_keywords" cols="30" rows="3" placeholder="Keywords for SEO">{{ old('seo_keywords') }}</textarea>
          </div>
        </div>

        <div class="form-group row">
          <label for="client_name" class="col-sm-2 col-form-label">Start/ End Date: </label>
          <div class="row col-sm-10">
            <div class="col-5">
              <div class="input-group" style="border-bottom: none">
              <input type="text" class="form-control datepicker" name="seo_start_date" id="seo_start_date" placeholder="SEO Start Date" autocomplete="off">
              <div class="input-group-append">
                <span class="input-group-text" style="border: 1px solid #ced4da">
                  <i class="fa fa-calendar" style="font-size: 1.3rem"></i>
                </span>
              </div>
              </div>
            </div>
            <div class="col-5">
            <div class="input-group" style="border-bottom: none">
              <input type="text" class="form-control datepicker" name="seo_end_date" id="seo_end_date" placeholder="SEO End Date" autocomplete="off">
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
         <label for="seo_pm_name" class="col-sm-2 col-form-label">SEO PM: </label>
         <div class="col-sm-10" id="seo_pm_user">
          <select name="seo_pm_name" id="seo_pm_name" class="selectpicker form-control select-search" data-live-search="true">
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