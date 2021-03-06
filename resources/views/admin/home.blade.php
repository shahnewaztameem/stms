@extends('layouts.final_layout')

@section('header_tag')
    <style>
      .my-card{
        min-height: 280px;
        margin: 10px 10px 10px;
      }
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
<div class="row pb-3">
 <div class="col-sm-4">
  <div class="row">
   <div class="col-10">
    <strong>Designs</strong>
   </div>
   <div class="col-2">
    <a href="{{route('admin.task.create-design-phase')}}" data-toggle="tooltip" data-placement="bottom" title="Add Design">
     <span><i class="fa fa-plus" style="font-size: 1.3rem"></i></span>
    </a>
   </div>
  </div>
 </div>
 <div class="col-sm-4">
  <div class="row">
   <div class="col-10">
    <strong>Developements</strong>
   </div>
   <div class="col-2">
    <a href="{{route('admin.task.create-development-phase')}}" data-toggle="tooltip" data-placement="bottom" title="Add Development">
     <span><i class="fa fa-plus" style="font-size: 1.3rem"></i></span>
    </a>
   </div>
  </div>
 </div>
 <div class="col-sm-4">
  <div class="row">
   <div class="col-10">
    <strong>SEO</strong>
   </div>
   <div class="col-2">
    <a href="{{route('admin.task.create-seo-phase')}}" data-toggle="tooltip" data-placement="bottom" title="Add SEO">
     <span><i class="fa fa-plus" style="font-size: 1.3rem"></i></span>
    </a>
   </div>
  </div>
 </div>
</div>

@if( Session::get('success') )
<div class="form-group row">
    <div class="col-md-12">
      <div class="alert alert-success" id="div3">
          <strong>Success!</strong> {{Session::get('success')}}
      </div>
    </div>
</div>
@endif

<div class="row">
  @if (count($tasks))
    @foreach ($tasks as $task)
        <div class="col-sm-6 col-md-4">
          <div class="card my-card">
            <div class="card-body">
              <h5 class="card-title">{{ $task->title }}</h5>
              <p class="card-text">{{ $task->details }}</p>
        
              <div role="separator" class="dropdown-divider"></div>
              
              <p class="card-text"><strong> Client: {{ $task->client->name }}, {{ $task->client->company }} </strong></p>
              
              <div role="separator" class="dropdown-divider"></div>
              
              <div class="row">
                <div class="col-8">
                  @if ($task->design_phase)
                  {{-- {{ new Carbon($task->design_phase->end_date) }} --}}
                  @php
                    $created = new Carbon($task->design_phase->end_date);
                        $now = Carbon::now();
                        $difference = ($created->diff($now)->days < 1)
                        ? 'today'
                        : $created->diffForHumans($now);
                        @endphp
                  {{ $difference }}
                  {{-- {{ date('Y-m-d:H:i:s', strtotime($task->design_phase->end_date))->diffForHumans() }} --}}
                  @else
                   No Deadline Set
                  @endif
                </div>
                <div class="col-4">
                  <a href="{{route('admin.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                    <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                  </a>
                  <a href="{{route('admin.task.edit', $task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit Project">
                    <i class="fa fa-pencil" style="font-size: 1.3rem"></i>
                  </a>
                </div>
              </div>
              
              <div role="separator" class="dropdown-divider"></div>
                <p class="card-text"><strong>Client Accessibility:</strong> 
                  @if ($task->design_phase)
                    @if ($task->design_phase->show_to_client)
                      <span class="badge badge-dark">Design</span> 
                    @endif
                  @endif
                  @if ($task->development_phase)
                    @if ($task->development_phase->show_to_client)
                      <span class="badge badge-dark">Dev</span>  
                    @endif
                  @endif
                  @if ($task->seo_phase)
                    @if ($task->seo_phase->show_to_client)
                      <span class="badge badge-dark">SEO</span>
                    @endif
                  @endif
                  @if (!$task->design_phase && !$task->development_phase && !$task->seo_phase)
                    <span class="badge badge-warning">Only Project</span>
                  @endif
                </p>
              <div role="separator" class="dropdown-divider"></div>

              <a href="{{ route('admin.notify.client', $task->id) }}" class="btn btn-info">Notify Client</a>
            </div>
          </div>
        </div>
    @endforeach
  @else
    <div class="col-12 text-center mt-1">
      <div role="separator" class="dropdown-divider"></div>
      <h2 class="text-center">
        No project available now. Please add project first.
      </h2>
      <a href="{{ route('admin.task.add') }}" class="btn btn-info">Add Project</a>
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