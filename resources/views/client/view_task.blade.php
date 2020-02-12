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
        <h3>{{ $task->title }}<small class="text-muted posted-text"> created {{ $task->created_at->diffForHumans() }}</small>
        </h3>
        </blockquote>

        <div role="separator" class="dropdown-divider"></div>

        <p class="card-text">{{ $task->details }}</p>

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
              <h4>Design Phase</h4>
            </div>
            <div role="separator" class="dropdown-divider"></div>

            @if ($task->design_phase)
              @if ($task->design_phase->show_to_client)
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
                <p>Not allowed to view from admin.</p>
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
              <h4>Development Phase</h4>
            </div>
            <div role="separator" class="dropdown-divider"></div>

            @if ($task->development_phase)
              @if ($task->development_phase->show_to_client)
                <p class="card-text"> <strong>Repo URL: </strong><a href="{{ $task->development_phase->repo_url }}" target="_blank">{{ $task->development_phase->repo_url }}</a></p>
      
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
                <p>Not allowed to view from admin.</p>
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
              @if ($task->design_phase)
                @if ($task->design_phase->show_to_client)
                  @if(count($task->task_files))
                    <ul class="list-group">
                      @foreach ($task->task_files as $file)
                        <li class="list-group-item list-group-item-default mb-3">
                          <div class="row">
                            <div class="col-10">
                                <a href="{{ asset($file->file_url) }}" target="_blank">{{ $file->file_url }}</a>
                            </div>
                            <div class="col-2">
                              <center>  
                                {!! Form::open(['method' => 'DELETE','route'=> ['admin.file.delete', $file->id], 'style' => 'display:inline']) !!}
                                {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove File','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                                {!! Form::close()!!}
                              </center>
                            </div>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  @else
                  <p>No Wireframes.</p>
                  @endif
                @else 
                  <p>Not allowed to view from admin.</p> 
                @endif
              @endif
            </div>
          </div>
      </div>

      <div class="col-sm-6">
        <div class="card my-2">
          <div class="card-body">
            <div>
              <h4>SEO Phase</h4>
            </div>
            <div role="separator" class="dropdown-divider"></div>

            @if ($task->seo_phase)

              @if ($task->seo_phase->show_to_client)
                <p class="card-text"> <strong>Keywords: </strong> {{ $task->seo_phase->seo_keywords }}</p>
      
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
                <p>Not allowed to view from admin.</p> 
              @endif
            @else
                <p>No SEO Phase Data Found.</p>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection