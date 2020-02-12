@extends('layouts.final_layout')

@section('content')

<?php
use Carbon\Carbon;
?>

<div class="text-center" style="text-transform: uppercase">
  <h2>Hello <strong>{{$client->name}} !!</strong></h2>
  <h2 class="my-5">Welcome to your portal</h2>
  <h2>Please use this portal to review the progress of the project</h2>
  <h2>&</h2>
  <h2>Correspond with any feedback</h2>
</div>

<div role="separator" class="dropdown-divider"></div>
<div class="d-flex flex-column align-items-center">
  @if (count($tasks))
      @foreach ($tasks as $task)
          <p class="h3 mt-4">Task Title: {{$task->title}}</p>
          <div style="color: red; text-align: left">
            <p class="h3">
              Design-phase:
              @if ($task->design_phase)
                  @php
                    $created = new Carbon($task->design_phase->end_date);
                        $now = Carbon::now();
                        $difference = ($created->diff($now)->days < 1)
                        ? 'today'
                        : $created->diffForHumans($now);
                  @endphp
                {{ $task->design_phase->show_to_client ? $difference : "Not Allowed"}}
              @else
                {{"Not Found"}}
              @endif
            </p>              
            <p class="h3">
              Development-phase:
              @if ($task->development_phase)
                @php
                  $created = new Carbon($task->development_phase->dev_end_date);
                  $now = Carbon::now();
                  $difference = ($created->diff($now)->days < 1)
                  ? 'today'
                  : $created->diffForHumans($now);
                @endphp
                {{ $task->development_phase->show_to_client ? $difference : "Not Allowed"}}
              @else
                {{"Not Found"}}
              @endif
            </p>              
            <p class="h3">
              SEO-phase:
              @if ($task->seo_phase)
                @php
                $created = new Carbon($task->seo_phase->seo_end_date);
                $now = Carbon::now();
                $difference = ($created->diff($now)->days < 1)
                ? 'today'
                : $created->diffForHumans($now);
                @endphp
                {{ $task->seo_phase->show_to_client ? $difference : "Not Allowed"}}
              @else
                {{"Not Found"}}
              @endif
            </p>              
          </div>
      @endforeach
  @else
      <p class="h3">You have no project</p>
  @endif
</div>

@endsection