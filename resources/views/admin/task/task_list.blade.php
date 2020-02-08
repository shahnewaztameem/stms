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
              <th>Client</th>
              <th>Phase</th>
              <th>Project Manager</th>
              <th>Start Date</th>
              <th style="width: 15%">Actions</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($tasks as $index => $task)
              <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $task->title }}</td>
                  <td>{{ $task->client }}</td>
                  <td>{{ $task->phase }}</td>
                  <td>{{ $task->user }}</td>
                  <td>{{ $task->start_date }}</td>
                  <td>
                    <center>

                     <a href="{{route('admin.user.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
                      <i class="fa fa-user-plus" style="font-size: 1.3rem"></i></span>
                     </a>

                     <a href="{{route('admin.user.edit',$user->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit User">
                         <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                     </a>
                      {!! Form::open(['method' => 'DELETE','route'=> ['admin.user.delete', $user->id], 'style' => 'display:inline']) !!}
                      {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: red"></i></span>',['class'=> 'delete-btn','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove task','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                      {!! Form::close()!!}
                    </center>
                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>
</div>
@endsection
