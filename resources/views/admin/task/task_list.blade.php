@extends('layouts.final_layout')

@section('content')
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

                     <a href="{{route('admin.user.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
                      <i class="fa fa-user-plus" style="font-size: 1.3rem"></i></span>
                     </a>

                     <a href="{{route('admin.user.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit User">
                         <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                     </a>
                      {!! Form::open(['method' => 'DELETE','route'=> ['admin.user.delete', $task->id], 'style' => 'display:inline']) !!}
                      {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                      {!! Form::close()!!}
                    </center>
                  </td>
              </tr>
            @endif   
            @if($task->development_phase)
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
                        @if ($task->design_phase)    
                        {{$task->design_phase->start_date}}
                        @else
                            Not Set
                        @endif
                    </td>
                    <td>
                        <center>

                        <a href="{{route('admin.user.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
                        <i class="fa fa-user-plus" style="font-size: 1.3rem"></i></span>
                        </a>

                        <a href="{{route('admin.user.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit User">
                            <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                        </a>
                        {!! Form::open(['method' => 'DELETE','route'=> ['admin.user.delete', $task->id], 'style' => 'display:inline']) !!}
                        {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                        {!! Form::close()!!}
                        </center>
                    </td>
                </tr>
            @endif
            @if($task->seo_phase)
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
                        @if ($task->design_phase)    
                        {{$task->design_phase->start_date}}
                        @else
                            Not Set
                        @endif
                    </td>
                    <td>
                        <center>

                        <a href="{{route('admin.user.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
                        <i class="fa fa-user-plus" style="font-size: 1.3rem"></i></span>
                        </a>

                        <a href="{{route('admin.user.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit User">
                            <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                        </a>
                        {!! Form::open(['method' => 'DELETE','route'=> ['admin.user.delete', $task->id], 'style' => 'display:inline']) !!}
                        {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                        {!! Form::close()!!}
                        </center>
                    </td>
                </tr>
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

                        <a href="{{route('admin.user.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
                        <i class="fa fa-user-plus" style="font-size: 1.3rem"></i></span>
                        </a>

                        <a href="{{route('admin.user.edit',$task->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit User">
                            <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                        </a>
                        {!! Form::open(['method' => 'DELETE','route'=> ['admin.user.delete', $task->id], 'style' => 'display:inline']) !!}
                        {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                        {!! Form::close()!!}
                        </center>
                    </td>
                </tr> 
            @endif
          @endforeach
      </tbody>
  </table>
</div>
@endsection
