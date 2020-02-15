@extends('layouts.final_layout')

@section('content')
<div class="container">
  <div class="row">
    @if( Session::get('success') )
      <div class="alert alert-success container" id="div3">
        <strong>Success!</strong> {{Session::get('success')}}
      </div>
    @endif

    <div class="card mb-3" style="width: 100%">
      <div class="card-body">

        <blockquote class="blockquote mb-0">
        <h3>
          {{ $task->title }}<small class="text-muted posted-text"> created {{ $task->created_at->diffForHumans() }}</small>
        </h3>
        </blockquote>

        <div role="separator" class="dropdown-divider"></div>

        <p class="card-text">{{ $task->details }}</p>

        <div role="separator" class="dropdown-divider"></div>
        
        @if ($task->client)
          <p class="card-text"><strong>Project Client Info: </strong></p> 
            <p class="card-text"><strong>Client Name:</strong> {{ $task->client->name }}</p>
            <p class="card-text"><strong>Company Name:</strong> {{ $task->client->company }}</p>
            <p class="card-text"><strong>Client Email:</strong> {{ $task->client->email }}</p>
          @endif

        <div role="separator" class="dropdown-divider"></div>
        
        @if ($task->project_manager)
          <p class="card-text"><strong>PM Info: </strong></p> 
            <p class="card-text"><strong>PM Name:</strong> {{ $task->project_manager->name }}</p>
            <p class="card-text"><strong>PM Number:</strong> {{ $task->project_manager->phone_number }}</p>
            <p class="card-text"><strong>PM Email:</strong> {{ $task->project_manager->email }}</p>
          @endif


          @if ($task->feedback)
          <div role="separator" class="dropdown-divider"></div>
          <div class="row">
          <div class="col-10">
            <p class="card-text"><strong>Client Comment :</strong>{{ $task->feedback->comment }}</p>
          </div>
          </div>
          @endif

      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="card my-2">
          <div class="card-body">
            <div>
              <h4>Design Phase
                @if ($task->design_phase)
                    @if ($task->design_phase->design_status)
                      <span class="badge badge-info">In Progress</span>
                    @else
                      <span class="badge badge-success">Completed</span>
                    @endif
                @endif
              </h4>
            </div>
            <div role="separator" class="dropdown-divider"></div>

            @if ($task->design_phase)
              <p class="card-text"> <strong>Start Date: </strong> {{ $task->design_phase->start_date }}</p>
              <p class="card-text"> <strong>End Date: </strong> {{ $task->design_phase->end_date }}</p>
    
              <div role="separator" class="dropdown-divider"></div>
            
              @if ($task->design_phase->design_pm)
                  <p class="card-text"><strong>Design PM Info: </strong></p> 
                  <p class="card-text">
                    <strong>PM Name:</strong>
                    {{ $task->design_phase->design_pm->name }}
                  </p>
                  <p class="card-text">
                    <strong>PM Number:</strong>
                    {{ $task->design_phase->design_pm->phone_number }}
                  </p>
                  <p class="card-text"><strong>PM Email:</strong> {{ $task->design_phase->design_pm->email }}</p>
              @endif
            @else
                <p>No Design Phase Data Found.</p>
            @endif

          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card my-2">
          <div class="card-body">
            <div>
              <h4>Development Phase
                @if ($task->development_phase)
                    @if ($task->development_phase->dev_status)
                      <span class="badge badge-info">In Progress</span>
                    @else
                      <span class="badge badge-success">Completed</span>
                    @endif
                @endif
              </h4>
            </div>
            <div role="separator" class="dropdown-divider"></div>

            @if ($task->development_phase)

            <p class="card-text"> <strong>Start Date: </strong> {{ $task->development_phase->dev_start_date }}</p>
            <p class="card-text"> <strong>End Date: </strong> {{ $task->development_phase->dev_end_date }}</p>
  
            <div role="separator" class="dropdown-divider"></div>
              <p class="card-text"> <strong>Repo URL: </strong><a href="{{ $task->development_phase->repo_url }}" target="_blank">{{ $task->development_phase->repo_url }}</a></p>
    
              <div role="separator" class="dropdown-divider"></div>
              <strong>Feedback:</strong> 
              @if ($task->development_phase->dev_feedback)
                  <div class="row">
                    <div class="col-10">
                      <p class="card-text" style="color: green">{{ $task->development_phase->dev_feedback }}</p>
                    </div>
                    <div class="col-2">
                      {{--  {!! Form::open(['method' => 'DELETE','route'=> ['client.dev_feedback.delete', $task->development_phase->id], 'style' => 'display:inline']) !!}
                      {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                      {!! Form::close()!!}  --}}
                    </div>
                  </div>
              @else
                  <div style="color: red">
                    No Feedback
                  </div>
              @endif 
              <div role="separator" class="dropdown-divider"></div>
            
              @if ($task->development_phase->dev_pm)
                  <p class="card-text"><strong>Dev PM Info: </strong></p> 
                  <p class="card-text">
                    <strong>PM Name:</strong>
                    {{ $task->development_phase->dev_pm->name }}
                  </p>
                  <p class="card-text">
                    <strong>PM Number:</strong>
                    {{ $task->development_phase->dev_pm->phone_number }}
                  </p>
                  <p class="card-text"><strong>PM Email:</strong> {{ $task->development_phase->dev_pm->email }}</p>
              @endif
            @else
                <p>No Development Phase Data Found.</p>
            @endif

          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card my-2">
          <div class="card-body">
            <h4 class="card-text">Wireframes</h4>
            <div role="separator" class="dropdown-divider"></div>

              @if(count($task->task_files))
                <ul class="list-group">
                  @foreach ($task->task_files as $file)
                    <li class="list-group-item list-group-item-default mb-3">
                      <div class="row">
                        <div class="col-10">
                            <a href="{{ asset($file->file_url) }}" target="_blank">
                              {{ $file->file_title }}
                            </a>
                        </div>
                        <div class="col-2">
                          <center>  
                            {!! Form::open(['method' => 'DELETE','route'=> ['admin.file.delete', $file->id], 'style' => 'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove File','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                            {!! Form::close()!!}
                          </center>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <strong> Feedback:</strong> 
                          @if (count($file->wireframe_feedback))
                            <div class="alert alert-success" role="alert">
                              @foreach ($file->wireframe_feedback as $feedback)
                                {{ $feedback->comment }}
                                <hr>
                                @endforeach
                            </div>
                          @else
                             <span style="color: red">No Feedback</span>
                          @endif
                        </div>
                      </div>
                    </li>
                  @endforeach
                </ul>
              @else
                <p>No Wireframes.</p>
              @endif
            </div>
          </div>
      </div>

      <div class="col-sm-6">
        <div class="card my-2">
          <div class="card-body">
            <div>
              <h4>SEO Phase
                @if ($task->seo_phase)
                    @if ($task->seo_phase->seo_status)
                      <span class="badge badge-info">In Progress</span>
                    @else
                      <span class="badge badge-success">Completed</span>
                    @endif
                @endif
              </h4>
            </div>
            <div role="separator" class="dropdown-divider"></div>

            @if ($task->seo_phase)

              <p class="card-text">
                <strong>Start Date: </strong> 
                {{ $task->seo_phase->seo_start_date }}
              </p>
              <p class="card-text">
                <strong>End Date: </strong>
                {{ $task->seo_phase->seo_end_date }}
              </p>

              <div role="separator" class="dropdown-divider"></div>

              <p class="card-text"> <strong>Keywords: </strong> {{ $task->seo_phase->seo_keywords }}</p>
    
              <div role="separator" class="dropdown-divider"></div>
              <strong>Feedback:</strong> 
              @if ($task->seo_phase->seo_feedback)
                  <div class="row">
                    <div class="col-10">
                      <p class="card-text" style="color: green">{{ $task->seo_phase->seo_feedback }}</p>
                    </div>
                    <div class="col-2">
                      {{--  {!! Form::open(['method' => 'DELETE','route'=> ['client.seo_feedback.delete', $task->seo_phase->id], 'style' => 'display:inline']) !!}
                      {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                      {!! Form::close()!!}  --}}
                    </div>
                  </div>
              @else
                  <div style="color: red">
                    No Feedback
                  </div>
              @endif 

              <div role="separator" class="dropdown-divider"></div>
            
              @if ($task->seo_phase->seo_pm)
                  <p class="card-text"><strong>SEO PM Info: </strong></p> 
                  <p class="card-text">
                    <strong>PM Name:</strong>
                    {{ $task->seo_phase->seo_pm->name }}
                  </p>
                  <p class="card-text">
                    <strong>PM Number:</strong>
                    {{ $task->seo_phase->seo_pm->phone_number }}
                  </p>
                  <p class="card-text"><strong>PM Email:</strong> {{ $task->seo_phase->seo_pm->email }}</p>
              @endif
            @else
                <p>No SEO Phase Data Found.</p>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div role="separator" class="dropdown-divider"></div>
      <h5 style="color: red">
        Danger Zone: Once You delete - All the Phases and Files will be deleted.
      </h5>
      {!! Form::open(['method' => 'DELETE','route'=> ['admin.task.delete', $task->id]]) !!}
      {!! Form::button('<i>Delete Project</i>',['class'=> 'btn btn-danger','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove Project','onclick'=>'return confirm("Are you want to delete?")'])  !!}
      {!! Form::close()!!}
    </div>
  </div>
</div>
@endsection