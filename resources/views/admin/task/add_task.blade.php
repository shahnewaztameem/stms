@extends('layouts.final_layout')

@section('content')

  <div class="row project">
    <div class="col-md-10 project__nav">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link @if (request()->is('admin/task/phase/create-design-phase')) active @endif" href="{{ route('admin.task.create-design-phase') }}">Design</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if (request()->is('admin/task/phase/create-development-phase')) active @endif" href="{{ route('admin.task.create-development-phase') }}">Development</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if (request()->is('admin/task/phase/create-seo-phase')) active @endif" href="{{ route('admin.task.create-seo-phase') }}">SEO</a>
        </li>
      </ul>
    </div>
    <div class="col-md-2 project__btn">
    <a href="{{route('admin.task.all')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Project's List">
      <span>PROJECT'S LIST</span>
    </a>
    </div>
  </div>

  @yield('phase')
@endsection


@section('customJS')
    <script>
      $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
     });

       // For name of the file appear on select
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        console.log('called');
      });

      // DYNAMIC FILE FIELD
      $('document').ready(()=>{
        let fieldNo = 1;

        // dynamic_file_input(fieldNo);

        function dynamic_file_input(number) {
          let html = `<div class="row mt-2" id="${number}">`;
          html += '<div class="col-10">'
          html += '<input type="text" class="form-control mb-3" name="file_title[]" placeholder="Wireframe Title">';
      
          html += `<input type="file" id="file_upload" name="task_files[]" class="input-file">`;
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
          $("button[data-id='project_title'] div.filter-option-inner-inner").html("Please Choose");
          $("button[data-id='design_pm_name'] div.filter-option-inner-inner").html("Please Choose");
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

                if (task.design_phase.design_status) {
                  $('#inlineRadio1').attr('checked', 'checked');
                } else {
                  $('#inlineRadio2').attr('checked', 'checked');
                }

                $("#design_pm_name").val(task.design_phase.design_pm_id);
                $("button[data-id='design_pm_name'] div.filter-option-inner-inner").html(task.design_phase.design_pm.name);
                $('#design-submit').text('Update');

                if (task.task_files) {
                  let files = `<div class="col-12"><ul class="list-group">`;
                  task.task_files.forEach(element => {
                  files += '<li class="list-group-item list-group-item-default mb-3">';
                  files += '<div class="row">';
                  files += '<div class="col-10">';
                  files += "<a href='{{ asset('/') }}"+element.file_url+"' target='_blank'>"+element.file_title+"</a>";
                  files += '</div>';
                  files += '<div class="col-2">';
                  files +=  '<center>'; 
                  files += "<form method='POST' action="+"{{ asset('/admin/task/file/delete/')}}/"+element.id+">";
                  files += `<button type='submit' class='delete-btn' onclick="return confirm('Are you want to delete?')"><i class='fa fa-trash' style='font-size: 1.3rem; color: red'></i></button>`;
                  files += '{{method_field("DELETE")}}{{ csrf_field() }}</form>';
                  files += '</center>';
                  files += '</div>'
                  files += '</div>'
                  files += '</li>';
                  });
                  files += `</ul></div>`;
                  
                  $('#files').append(files);
                }

              }else{
                $('#start_date').val('');
                $('#end_date').val('');
                $("#design_pm_name").val('');
                $('#inlineRadio1').attr('checked', 'checked');
                $('#customSwitchDesign').attr('checked', 'checked');
                $("button[data-id='design_pm_name'] div.filter-option-inner-inner").html("Please Choose");
                $('#design-submit').text('Add');
                $('#files').html('');

              }
            },
            error: (err) => console.log(err)
          });
        }
        $('#design_details').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $("#design_pm_name").val('');
        $('#customSwitchDesign').attr('checked', 'checked');
        $('#inlineRadio1').attr('checked', 'checked');
        $("button[data-id='design_pm_name'] div.filter-option-inner-inner").html("Please Choose");
        $('#design-submit').text('Add');
        $('#files').html('');

      })
    </script>
  {{-- DEVELOPMENT PAGE SCRIPT  --}}
    <script>

        $('#dev-cancel').click((e)=>{
          e.preventDefault();
          $('#dev_form')[0].reset();
          $("button[data-id='dev_project_title'] div.filter-option-inner-inner").html("Please Choose");
          $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html("Please Choose");
        });

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
                
                if (task.development_phase.dev_status) {
                  $('#inlineRadio1').attr('checked', 'checked');
                } else {
                  $('#inlineRadio2').attr('checked', 'checked');
                }

                $("#dev_pm_name").val(task.development_phase.dev_pm_id);
                $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html(task.development_phase.dev_pm.name);
                $('#dev-submit').text('Update');
              }else{
                $('#repo_url').val('');
                $('#dev_start_date').val('');
                $('#dev_end_date').val('');
                $("#dev_pm_name").val('');
                $('#inlineRadio1').attr('checked', 'checked');
                $('#customSwitchDevelopment').removeAttr('checked');
                $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html("Please Choose");
                $('#dev-submit').text('Add');

              }
            },
            error: (err) => console.log(err)
          });
        }
        $('#customSwitchDevelopment').removeAttr('checked');
        $('#inlineRadio1').attr('checked', 'checked');
        $('#dev_project_details').val('');
        $('#repo_url').val('');
        $('#dev_start_date').val('');
        $('#dev_end_date').val('');
        $("#dev_pm_name").val('');
        $("button[data-id='dev_pm_name'] div.filter-option-inner-inner").html("Please Choose");
        $('#dev-submit').text('Add');

      })
    </script>

  {{-- SEO PAGE SCRIPT  --}}
    <script>

      
        $('#seo-cancel').click((e)=>{
          e.preventDefault();
          $('#seo_form')[0].reset();
          $("button[data-id='seo_project_title'] div.filter-option-inner-inner").html("Please Choose");
          $("button[data-id='seo_pm_name'] div.filter-option-inner-inner").html("Please Choose");
        });

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


                if (task.seo_phase.seo_status) {
                  $('#inlineRadio1').attr('checked', 'checked');
                } else {
                  $('#inlineRadio2').attr('checked', 'checked');
                }

                $("#seo_pm_name").val(task.seo_phase.seo_pm_id);
                $("button[data-id='seo_pm_name'] div.filter-option-inner-inner").html(task.seo_phase.seo_pm.name);
                $('#seo-submit').text('Update');
              }else{
                $('#seo_keywords').val('');
                $('#seo_start_date').val('');
                $('#seo_end_date').val('');
                $("#seo_pm_name").val('');
                $('#inlineRadio1').attr('checked', 'checked');
                $('#customSwitchSEO').removeAttr('checked');
                $("button[data-id='seo_pm_name'] div.filter-option-inner-inner").html("Please Choose");
                $('#seo-submit').text('Add');
              }
            },
            error: (err) => console.log(err)
          });
        }
        $('#customSwitchSEO').removeAttr('checked');
        $('#inlineRadio1').attr('checked', 'checked');
        $('#seo_project_details').val('');
        $('#seo_keywords').val('');
        $('#seo_start_date').val('');
        $('#seo_end_date').val('');
        $("#seo_pm_name").val('');
        $("button[data-id='seo_pm_name'] div.filter-option-inner-inner").html("Please Choose");
        $('#seo-submit').text('Add');

      })
    </script>
@endsection
