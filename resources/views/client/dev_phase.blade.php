@extends('layouts.final_layout')


@section('header_tag')
    <style>
      .page-nav{
        display: flex;
        justify-content: center;
      }
    </style>
@endsection

@section('content')
<?php
use Carbon\Carbon;
?>

@if( Session::get('success') )
  <div class="row">
    <div class="col-12">
      <div class="alert alert-success container" id="div3">
        <strong>Success!</strong> {{Session::get('success')}}
      </div>
    </div>
  </div>
@endif

@if ($errors->any())
  <div class="row">
    <div class="col-12">
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

<div class="row">
  @if (count($tasks))
    @foreach ($tasks as $task)
      <div class="col-sm-6 col-md-4 mb-3">
        <div class="card my-card">
          <div class="card-body">
            <div class="row">
              <div class=" col-sm-10 col-md-11">
                <h5 class="card-title">
                  {{ $task->title }}
                  @if ($task->development_phase)
                    @if ($task->development_phase->dev_status)
                      <span class="badge badge-info">In Progress</span>
                    @else
                      <span class="badge badge-success">Completed</span>
                    @endif
                  @endif
                </h5>
                @if ($task->development_phase)
                  <p> Deadline: 
                    @if ($task->development_phase->show_to_client)
                      @php
                        $created = new Carbon($task->development_phase->dev_end_date);
                        $now = Carbon::now();
                        $difference = ($created->diff($now)->days < 1)
                        ? 'today'
                        : $created->diffForHumans($now);
                      @endphp
                      <span style="color: red">{{ $difference }}</span>
                    @else
                      Not Set 
                    @endif
                  </p> 
                @endif
              </div>
              <div class="col-sm-2 col-md-1">
                <a href="{{route('client.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                  <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                </a>
              </div>
            </div>
            <div role="separator" class="dropdown-divider"></div>

            @if ($task->development_phase)
                @if ($task->development_phase->show_to_client)
                  @if ($task->development_phase->repo_url)
                    <h5 class="card-text">Repository URL: 
                      <a href="{{asset($task->development_phase->repo_url)}}" target="_blank">{{asset($task->development_phase->repo_url)}}</i></a>
                    </h5>
                    <div role="separator" class="dropdown-divider"></div>
                    @if ($task->development_phase->dev_feedback)
                        <div class="row">
                          <div class="col-10">
                            <p class="card-text">{{ $task->development_phase->dev_feedback }}</p>
                          </div>
                          <div class="col-2">
                            {!! Form::open(['method' => 'DELETE','route'=> ['client.dev_feedback.delete', $task->development_phase->id], 'style' => 'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                            {!! Form::close()!!}
                          </div>
                        </div>
                    @else 
                      <form action="{{ route('client.dev_feedback', $task->development_phase->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                          <textarea name="dev_feedback" cols="10" rows="4" class="form-control" placeholder="Give Feedback Here."></textarea>
                        </div>

                        <button type="submit" class="btn btn-info">Feedback</button>
                      </form>
                    @endif
                  @else
                    <p>No Repository URL available.</p>
                  @endif
                @else
                  <p>No Allowed from Admin.</p>
                @endif
            @else
                <p>No Development Phase for this project.</p>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="col-12 text-center mt-1">
      <div role="separator" class="dropdown-divider"></div>
      <h2 class="text-center">
        No project available now.
      </h2>
    </div>
  @endif
</div>
  
@if (count($tasks))
  <div class="row page-nav">
    <div>
      <nav aria-label="Page navigation">
        {{ $tasks->links() }}
      </nav>
    </div>
  </div>
@endif
@endsection