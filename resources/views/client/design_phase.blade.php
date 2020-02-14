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
          <div class="col-sm-12 mb-3">
            <div class="card my-card">
              <div class="card-body">
                <div class="row">
                  <div class=" col-sm-10 col-md-11">
                    <h5 class="card-title">{{ $task->title }}</h5>
                    @if ($task->design_phase)
                      <p> Deadline: 
                        @if ($task->design_phase->show_to_client)
                          @php
                            $created = new Carbon($task->design_phase->end_date);
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
                {{-- <p class="card-text">{{ $task->details }}</p> --}}
          
                <div role="separator" class="dropdown-divider"></div>

                @if ($task->design_phase)
                    @if ($task->design_phase->show_to_client)
                      @if ($task->task_files)
                        <div class="row">
                          @foreach ($task->task_files as $file)
                            <div class="col-sm-6 col-md-4 mt-3">
                              <div class="card">
                                <img class="card-img-top" src="{{asset($file->file_url)}}" alt="Card image cap">
                                <div class="card-body">
                                  <h5 class="card-title">Full View: 
                                    <a href="{{asset($file->file_url)}}" target="_blank">{{ $file->file_title }}</a>
                                  </h5>
                                  <div role="separator" class="dropdown-divider"></div>
                                  @if ($file->wireframe_feedback)
                                    <div class="row">
                                      @foreach ($file->wireframe_feedback as $feedback)
                                        <div class="col-10">
                                          <p class="card-text">{{ $feedback->comment }}</p>
                                        </div>
                                        <div class="col-2">
                                          {!! Form::open(['method' => 'DELETE','route'=> ['client.design_feedback.delete', $feedback->id], 'style' => 'display:inline']) !!}
                                          {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                                          {!! Form::close()!!}
                                        </div>
                                      @endforeach
                                    </div>
                                  @endif
                                  <div role="separator" class="dropdown-divider"></div>
                                  <form action="{{ route('client.design_feedback', $file->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                      <textarea name="design_feedback" cols="10" rows="4" class="form-control" placeholder="Give Feedback Here."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-info">Feedback</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          @endforeach 
                        </div>
                      @else
                        <p>No Wireframes available.</p>
                      @endif
                    @else
                      <p>No Allowed from Admin.</p>
                    @endif
                @else
                    <p>No Design Phase for this project.</p>
                @endif
  
                {{-- <a href="{{ route('admin.notify.client', $task->id) }}" class="btn btn-info">Notify Client</a> --}}
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