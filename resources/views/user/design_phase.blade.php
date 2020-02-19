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
<div class="row">
    @if (count($designPhase))
      @foreach ($designPhase as $design)
          <div class="col-sm-12 mb-3">
            <div class="card my-card">
              <div class="card-body">
                <div class="row">
                  <div class=" col-sm-10 col-md-11">
                    <h5 class="card-title">{{ $design->task->title }}</h5>
                      <p> Deadline: 
                        @php
                          $created = new Carbon($design->end_date);
                          $now = Carbon::now();
                          $difference = ($created->diff($now)->days < 1)
                          ? 'today'
                          : $created->diffForHumans($now);
                        @endphp
                        <span style="color: red">{{ $difference }}</span>
                      </p>
                  </div>
                  <div class="col-sm-2 col-md-1">
                    <a href="{{route('user.task.view', $design->task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                      <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                    </a>
                  </div>
                </div>
          
                <div role="separator" class="dropdown-divider"></div>

                   @if ($design->task->task_files)
                     <div class="row">
                       @foreach ($design->task->task_files as $file)
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
                                  <strong class="col-12">Client Feedback: </strong>
                                   @foreach ($file->wireframe_feedback as $feedback)
                                     <div class="col-10">
                                       <p class="card-text">{{ $feedback->comment }}</p>
                                     </div>
                                     <div class="col-2">
                                       {{-- {!! Form::open(['method' => 'DELETE','route'=> ['user.design_feedback.delete', $feedback->id], 'style' => 'display:inline']) !!}
                                       {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                                       {!! Form::close()!!} --}}
                                     </div>
                                   @endforeach
                                 </div>
                               @endif
                               <div role="separator" class="dropdown-divider"></div>
                             </div>
                           </div>
                         </div>
                       @endforeach 
                     </div>
                   @else
                    <strong>Client Feedback: </strong>
                     <p>No Wireframes available.</p>
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
  
@if (count($designPhase))
  <div class="row page-nav">
    <div>
      <nav aria-label="Page navigation">
        {{ $designPhase->links() }}
      </nav>
    </div>
  </div>
@endif
@endsection