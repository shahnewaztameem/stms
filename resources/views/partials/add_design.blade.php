<div class="row mt-2">
  <div class="col-12">
      <div class="card">
        <form method="POST" id="design_form" action="{{ route('admin.task.create-design-phase') }}" enctype="multipart/form-data">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <span class="h3">Add Project Design</span>
                <div>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" name="show_to_client" checked class="custom-control-input" id="customSwitchDesign">
                    <label class="custom-control-label" for="customSwitchDesign">Show To Client</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
        
            @if( Session::get('successDesign') )
              <div class="form-group row">
                  <div class="col-md-12">
                    <div class="alert alert-success" id="div3">
                        <strong>Success!</strong> {{Session::get('successDesign')}}
                    </div>
                  </div>
              </div>
            @endif
        
            @if( Session::get('errDesign') )
              <div class="form-group row">
                <div class="col-md-12">
                  <div class="alert alert-danger" id="div3">
                    <strong>Error!</strong> {{Session::get('errDesign')}}
                  </div>
                </div>
              </div>
            @endif
        
            @if( Session::get('tab') == "design")
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
              <label for="project_title" class="col-sm-2 col-form-label">Project Title: </label>
              <div class="col-sm-10">

                <div class="input-group" style="border-bottom: none">
                  <select name="project_title" id="project_title" class="selectpicker form-control select-search" data-live-search="true">
                    <option value="">Please Choose</option>
                    @foreach ($tasks as $task)
                      <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                    </select>

                  <div class="input-group-append">
                    <a href="{{route('admin.task.create')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Add Manager">
                      <span><i class="fa fa-plus"></i></span>
                    </a>
                  </div>
                </div>

              </div>
            </div>
            
            <div class="form-group row">
              <label for="design_details" class="col-sm-2 col-form-label">Project Details: </label>
              <div class="col-sm-10">
                <textarea name="design_details" class="form-control" id="design_details" readonly cols="30" rows="3" placeholder="Project details"></textarea>
              </div>
            </div>
                
            <div class="form-group row">
                <label for="client_name" class="col-sm-2 col-form-label">Start/ End Date: </label>
                <div class="row col-sm-10">
                  <div class="col-5">
                    <div class="input-group" style="border-bottom: none">
                    <input type="text" class="form-control datepicker" name="start_date" id="start_date" placeholder="Start Date" autocomplete="off">
                    <div class="input-group-append">
                      <span class="input-group-text" style="border: 1px solid #ced4da">
                        <i class="fa fa-calendar" style="font-size: 1.3rem"></i>
                      </span>
                    </div>
                    </div>
                  </div>
                  <div class="col-5">
                  <div class="input-group" style="border-bottom: none">
                    <input type="text" class="form-control datepicker" name="end_date" id="end_date" placeholder="End Date" autocomplete="off">
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
              <label for="design_pm_name" class="col-sm-2 col-form-label">Design Project Manager: </label>
              <div class="col-sm-10" id="design_pm_user">

                <div class="input-group" style="border-bottom: none">
                  <select name="design_pm_name" id="design_pm_name" class="selectpicker form-control select-search" data-live-search="true">
                    <option value="">Please Choose</option>
                    @foreach ($users as $user)
                      <option value='{{ $user->id }}'>{{ $user->name }}</option>
                    @endforeach
                  </select>
                  <div class="input-group-append">
                    <a href="{{route('admin.user.create')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Add Manager">
                      <span><i class="fa fa-plus"></i></span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="design_status" class="col-sm-2 col-form-label">Status: </label>
              <div class="col-sm-10">
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" checked name="design_status" id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">In Progress</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="design_status" id="inlineRadio2" value="0">
                  <label class="form-check-label" for="inlineRadio2">Completed</label>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Wireframes: </label>
              <div class="col-sm-10" id="wireframe_file">
                <div class="row">
                  <div class="col-10">
                    <input type="text" class="form-control mb-3" name="file_title[]" placeholder="Wireframe Title">
                    <div class="custom-file mb-3">
                      <label class="custom-file-label" for="file_upload">Choose file...</label>
                      <input type="file" name="task_files[]" class="custom-file-input" id="file_upload">
                    </div>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-info" id="plus-btn">
                      <i class="fa fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row" id="files"></div>

            <div class="row justify-content-end">
              <button class="btn btn-danger mr-2" id="cancel">Cancel</button>
              <button id="design-submit" type="submit" class="btn btn-primary mr-3">Add</button>
            </div>
        </form>
      </div>
  </div>
 </div>
</div>
