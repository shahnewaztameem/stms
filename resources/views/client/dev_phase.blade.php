@extends('layouts.final_layout')

@section('content')
<?php
use Carbon\Carbon;
?>
<div class="row">
    @if (count($tasks))
      @foreach ($tasks as $task)
          <div class="col-sm-6 col-md-4">
            <div class="card my-card">
              <div class="card-body">
                <h5 class="card-title">{{ $task->title }}</h5>
                <p class="card-text">{{ $task->details }}</p>
          
                <div role="separator" class="dropdown-divider"></div>
                
                <div class="row">
                  <div class="col-10">
                    @if ($task->design_phase)
                        @php
                            $created = new Carbon($task->design_phase->end_date);
                            $now = Carbon::now();
                            $difference = ($created->diff($now)->days < 1)
                            ? 'today'
                            : $created->diffForHumans($now);
                        @endphp
                    {{ $difference }}
                    @else
                     No Deadline Set
                    @endif
                  </div>
                  <div class="col-2">
                    <a href="{{route('client.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                      <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                    </a>
                  </div>
                </div>
                
                <div role="separator" class="dropdown-divider"></div>
  
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