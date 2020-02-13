@extends('layouts.final_layout')

@section('content')
<?php
use Carbon\Carbon;
?>
<div class="row">
  @if (count($tasks))
    @foreach ($tasks as $task)
      <div class="col-sm-6 col-md-4 mb-3">
        <div class="card my-card">
          <div class="card-body">
            <div class="row">
              <div class=" col-sm-10 col-md-11">
                <h5 class="card-title">{{ $task->title }}</h5>
                @if ($task->seo_phase)
                  <p> Deadline: 
                    @if ($task->seo_phase->show_to_client)
                      @php
                        $created = new Carbon($task->seo_phase->dev_end_date);
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

            @if ($task->seo_phase)
                @if ($task->seo_phase->show_to_client)
                  @if ($task->seo_phase->seo_keywords)
                    <h5 class="card-text">SEO Keywords: 
                      <span style="color: green">{{$task->seo_phase->seo_keywords}}</span>
                    </h5>
                    <div role="separator" class="dropdown-divider"></div>
                    <form action="#" method="post">
                      <div class="form-group">
                        <textarea name="design_feedback" cols="10" rows="4" class="form-control" placeholder="Give Feedback Here."></textarea>
                      </div>

                      <button type="submit" class="btn btn-info">Feedback</button>
                    </form>
                  @else
                    <p>No SEO Keywords available.</p>
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