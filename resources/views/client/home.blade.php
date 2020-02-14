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
{{--  <div class="d-flex flex-column align-items-center">
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
</div>  --}}

<div class="row">
  <div class="col-12">
    <h4>Your Projects: </h4>
    <div role="separator" class="dropdown-divider"></div>
  </div>
</div>
<div style="overflow-x: auto">
  @if( Session::get('success') )
      <div class="alert alert-success container" id="div3">
          <strong>Success!</strong> {{Session::get('success')}}
      </div>
  @endif
  <table id="example" class="table table-striped table-bordered" style="width:100%">
      <thead>
          <tr>
              <th>#</th>
              <th>Project</th>
              <th>Client Name</th>
              <th>Phase</th>
              <th>Project Manager</th>
              <th>Start Date</th>
              <th style="width: 15%">Actions</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($tasks as $index => $task)
            @if ($task->design_phase)
              @if ($task->design_phase->show_to_client) 
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $task->title }}</td>
                  <td>{{ $task->client->name }}</td>
                  <td>
                      Design
                  </td>
                  <td>{{ $task->design_phase->design_pm->name }}</td>
                  <td>{{$task->design_phase->start_date}}</td>
                  <td>
                      <center>
                          <a href="{{route('client.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                              <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                          </a>

                          <a href="{{route('client.task.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit Project">
                              <i class="fa fa-edit" style="font-size: 1.3rem"></i>
                          </a>
                          {!! Form::open(['method' => 'DELETE','route'=> ['client.task.delete-design', $task->design_phase->id], 'style' => 'display:inline']) !!}
                          {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove Design Phase','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                          {!! Form::close()!!}
                      </center>
                  </td>
                </tr>
              @endif
            @endif   
            @if($task->development_phase)
              @if ($task->development_phase->show_to_client) 
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->client->name }}</td>
                    <td>
                        Development
                    </td>
                    <td>
                        {{ $task->development_phase->dev_pm->name }}
                    </td>
                    <td>  
                        {{$task->development_phase->dev_start_date}}
                    </td>
                    <td>
                        <center>
                            <a href="{{route('client.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                                <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                            </a>

                            <a href="{{route('client.task.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit Project">
                                <i class="fa fa-edit" style="font-size: 1.3rem"></i>
                            </a>
                            {!! Form::open(['method' => 'DELETE','route'=> ['client.task.delete-dev', $task->development_phase->id], 'style' => 'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove Development','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                            {!! Form::close()!!}
                        </center>
                    </td>
                </tr>
              @endif
            @endif
            @if($task->seo_phase)
              @if ($task->development_phase->show_to_client) 
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->client->name }}</td>
                    <td>
                        SEO
                    </td>
                    <td>
                        {{ $task->seo_phase->seo_pm->name }}
                    </td>
                    <td>  
                        {{$task->seo_phase->seo_start_date}}
                    </td>
                    <td>
                        <center>
                            <a href="{{route('client.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                                <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                            </a>

                            <a href="{{route('client.task.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit Project">
                                <i class="fa fa-edit" style="font-size: 1.3rem"></i>
                            </a>
                            {!! Form::open(['method' => 'DELETE','route'=> ['client.task.delete-seo', $task->seo_phase->id], 'style' => 'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove SEO phase','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                            {!! Form::close()!!}
                        </center>
                    </td>
                </tr>
              @endif
            @endif
            @if(!$task->design_phase && !$task->development_phase && !$task->seo_phase)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->client->name }}</td>
                    <td>
                        Initial(Set other)
                    </td>
                    <td>{{ $task->project_manager->name }}</td>
                    <td>Not Set</td>
                    <td>
                        <center>
                            <a href="{{route('client.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                                <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                            </a>

                            {{--  <a href="{{route('client.task.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit Project">
                                <i class="fa fa-edit" style="font-size: 1.3rem"></i>
                            </a>  --}}
                            {{-- {!! Form::open(['method' => 'DELETE','route'=> ['client.task.delete', $task->id], 'style' => 'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove Project','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                            {!! Form::close()!!} --}}
                        </center>
                    </td>
                </tr>
            @else
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->client->name }}</td>
                <td>
                    Initial(Set other)
                </td>
                <td>{{ $task->project_manager->name }}</td>
                <td>Not Set</td>
                <td>
                    <center>
                        <a href="{{route('client.task.view', $task->slug)}}" data-toggle="tooltip" data-placement="bottom" title="View Project">
                            <i class="fa fa-eye" style="font-size: 1.3rem"></i>
                        </a>

                        {{--  <a href="{{route('client.task.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit Project">
                            <i class="fa fa-edit" style="font-size: 1.3rem"></i>
                        </a>  --}}
                        {{-- {!! Form::open(['method' => 'DELETE','route'=> ['client.task.delete', $task->id], 'style' => 'display:inline']) !!}
                        {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove Project','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                        {!! Form::close()!!} --}}
                    </center>
                </td>
              </tr>
            @endif
          @endforeach
      </tbody>
  </table>
</div>

@endsection