<div class="row mt-2">
 <div class="col-12">
  <div class="card">
  <form method="POST" id="design_form" action="{{ route('admin.task.create-design-phase') }}" enctype="multipart/form-data">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <span class="h3">Add Project Design</span>
        <div>
          <div class="custom-control custom-switch">
            <input type="checkbox" name="show_to_client" class="custom-control-input" id="customSwitchDesign">
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
         <select name="project_title" id="project_title" class="selectpicker form-control select-search" data-live-search="true">
          <option value="">Please Choose</option>
          @foreach ($tasks as $task)
            <option value="{{ $task->id }}">{{ $task->title }}</option>
          @endforeach
         </select>
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
         <select name="design_pm_name" id="design_pm_name" class="selectpicker form-control select-search" data-live-search="true">
          <option value="">Please Choose</option>
          @foreach ($users as $user)
            <option value='{{ $user->id }}'>{{ $user->name }}</option>
          @endforeach
         </select>
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
          {{--  <input type="text" class="form-control mb-3" name="title[]" placeholder="Wireframe Title">
          <div class="custom-file mb-3">
            <label class="custom-file-label" for="file_upload">Choose file...</label>
            <input type="file" name="task_files[]" class="custom-file-input" id="file_upload" multiple>
          </div>  --}}
        </div>
        {{--  <div class="col-sm-2">
          <button class="btn btn-info" id="plus-btn">
            <i class="fa fa-plus"></i>
          </button>
        </div>  --}}
       </div>
       
   
       <div class="row justify-content-end">
         <button class="btn btn-primary mr-2" id="cancel">Cancel</button>
         <button type="submit" class="btn btn-primary mr-3">Add</button>
       </div>
      </form>
   </div>
 </div>
 </div>
</div>

@section('customJS')
    <script>
      $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
     });

       // For name of the file appear on select
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });


      // DYNAMIC FILE FIELD
      $('document').ready(()=>{
        let fieldNo = 1;

        // dynamic_file_input(fieldNo);

        function dynamic_file_input(number) {
          let html = `<div class="row" id="${number}">`;
          html += '<div class="col-10">'
          html += '<input type="text" class="form-control mb-3" name="file_title[]" placeholder="Wireframe Title">';
          html += '<div class="custom-file mb-3">';
          html += '<label class="custom-file-label" for="file_upload">Choose file...</label>';
          html += '<input type="file" name="task_files[]" class="custom-file-input" id="file_upload">';
          html += '</div>';
          html += '</div>';
          html += '<div class="col-2">';
          html += '<button class="btn btn-danger" id="remove-btn">';
          html += '<i class="fa fa-minus"></i>';
          html += '</button>'
          html += '</div>';
          html += '</div>';

          $("#wireframe_file").append(html);
        }

        $('#plus-btn').click((e)=>{
          e.preventDefault();
          fieldNo++;
          dynamic_file_input(fieldNo);
        });

        $(document).on('click', '#remove-btn', (e)=>{
          // console.log("re")
          e.preventDefault();
          $(`#wireframe_file #${fieldNo}`).remove();
          fieldNo--;
        });

        $('#cancel').click((e)=>{
          e.preventDefault();
          $('#design_form')[0].reset();
        });
      });

      $('#project_title').on('change', (event) => {
        // console.log(event.target.value);
        if (event.target.value) {
          $.ajax({
            type: 'GET',
            url: '/project-details/design/'+event.target.value,
            success: (res) => {
              console.log(res);
              let task = res.data;
              $('#design_details').val(task.details);

              if (task.design_phase) {
                if(task.design_phase.show_to_client){
                  $('#customSwitchDesign').attr('checked', 'checked');
                }else{
                  $('#customSwitchDesign').removeAttr('checked');
                }
                $('#start_date').val(task.design_phase.start_date);
                $('#end_date').val(task.design_phase.end_date);
                $("#design_pm_name").val(task.design_phase.design_pm_id);
                $("button[data-id='design_pm_name'] div.filter-option-inner-inner").html(task.design_phase.design_pm.name);
              }else{
                $('#start_date').val('');
                $('#end_date').val('');
                $("#design_pm_name").val('');
                $('#customSwitchDesign').removeAttr('checked');
                $("button[data-id='design_pm_name'] div.filter-option-inner-inner").html("Please Choose");
              }
            },
            error: (err) => console.log(err)
          });
        }
        $('#design_details').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $("#design_pm_name").val('');
        $('#customSwitchDesign').removeAttr('checked');
        $("button[data-id='design_pm_name'] div.filter-option-inner-inner").html("Please Choose");

      })
    </script>

{{-- DEVELOPMENT PAGE SCRIPT  --}}
    <script>
      $('#dev_project_title').on('change', (event) => {
        // console.log(event.target.value);
        if (event.target.value) {
          $.ajax({
            type: 'GET',
            url: '/project-details/development/'+event.target.value,
            success: (res) => {
              console.log(res);
              let task = res.data;
              $('#dev_project_details').val(task.details);

              if (task.development_phase) {
                if(task.development_phase.show_to_client){
                  $('#customSwitchDevelopment').attr('checked', 'checked');
                }else{
                  $('#customSwitchDevelopment').removeAttr('checked');
                }
                $('#repo_url').val(task.development_phase.repo_url);
                $('#dev_start_date').val(task.development_phase.dev_start_date);
                $('#dev_end_date').val(task.development_phase.dev_end_date);
                $("#dev_pm_name").val(task.development_phase.dev_pm_id);
                $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html(task.development_phase.dev_pm.name);
              }else{
                $('#repo_url').val('');
                $('#dev_start_date').val('');
                $('#dev_end_date').val('');
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
        $('#dev_start_date').val('');
        $('#dev_end_date').val('');
        $("#dev_pm_name").val('');
        $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html("Please Choose");

      })
    </script>

{{-- SEO PAGE SCRIPT  --}}
    <script>
      $('#seo_project_title').on('change', (event) => {
        // console.log(event.target.value);
        if (event.target.value) {
          $.ajax({
            type: 'GET',
            url: '/project-details/seo/'+event.target.value,
            success: (res) => {
              console.log(res);
              let task = res.data;
              $('#seo_project_details').val(task.details);

              if (task.seo_phase) {
                if(task.seo_phase.show_to_client){
                  $('#customSwitchSEO').attr('checked', 'checked');
                }else{
                  $('#customSwitchSEO').removeAttr('checked');
                }
                $('#seo_keywords').val(task.seo_phase.seo_keywords);
                $('#seo_start_date').val(task.seo_phase.seo_start_date);
                $('#seo_end_date').val(task.seo_phase.seo_end_date);
                $("#seo_pm_name").val(task.seo_phase.seo_pm_id);
                $("button[data-id='seo_pm_name'] div.filter-option-inner-inner").html(task.seo_phase.seo_pm.name);
              }else{
                $('#seo_keywords').val('');
                $('#seo_start_date').val('');
                $('#seo_end_date').val('');
                $("#seo_pm_name").val('');
                $('#customSwitchSEO').removeAttr('checked');
                $("button[data-id='seo_pm_name'] div.filter-option-inner-inner").html("Please Choose");
              }
            },
            error: (err) => console.log(err)
          });
        }
        $('#customSwitchSEO').removeAttr('checked');
        $('#seo_project_details').val('');
        $('#seo_keywords').val('');
        $('#seo_start_date').val('');
        $('#seo_end_date').val('');
        $("#seo_pm_name").val('');
        $("button[data-id='seo_pm_name'] div.filter-option-inner-inner").html("Please Choose");

      })
    </script>
@endsection