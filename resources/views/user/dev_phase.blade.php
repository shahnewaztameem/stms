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
  @if (count($dev_phase))
    @foreach ($dev_phase as $dev)
      <div class="col-sm-6 col-md-4 mb-3">
        <div class="card my-card">
          <div class="card-body">
            <div class="row">
              <div class=" col-sm-10 col-md-11">
                <h5 class="card-title">
                  {{ $dev->task->title }}
                   @if ($dev->dev_status)
                     <span class="badge badge-info">In Progress</span>
                   @else
                     <span class="badge badge-success">Completed</span>
                   @endif
                </h5>
              </div>
              <div class="col-sm-10">
               <p> Deadline: 
                @php
                  $created = new Carbon($dev->dev_end_date);
                  $now = Carbon::now();
                  $difference = ($created->diff($now)->days < 1)
                  ? 'today'
                  : $created->diffForHumans($now);
                @endphp
                <span style="color: red">{{ $difference }}</span>
               </p> 
              </div>
              <div class="col-sm-2">
                <a href="{{route('user.task.view', $dev->task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                  <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                </a>
              </div>
            </div>
            <div role="separator" class="dropdown-divider"></div>
            <h5 class="card-text">Repository URL: 
              <a href="{{asset($dev->repo_url)}}" target="_blank">{{asset($dev->repo_url)}}</i></a>
            </h5>
            <div role="separator" class="dropdown-divider"></div>
            @if ($dev->dev_feedback)
                <div class="row">
                 <strong class="col-12">Client Feedback: </strong>
                  <div class="col-10">
                    <p class="card-text">{{ $dev->dev_feedback }}</p>
                  </div>
                  <div class="col-2">
                  </div>
                </div>
            @else 
              <strong>Client Feedback: </strong>
              <p>No Feedback given.</p>
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
  
@if (count($dev_phase))
  <div class="row page-nav">
    <div>
      <nav aria-label="Page navigation">
        {{ $dev_phase->links() }}
      </nav>
    </div>
  </div>
@endif
@endsection