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
              <th>Name</th>
              <th>Company</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Other info</th>
              <th style="width: 15%">Actions</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($clients as $index => $client)
              <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $client->name }}</td>
                  <td>{{ $client->company }}</td>
                  <td>{{ $client->email }}</td>
                  <td>{{ $client->phone_number }}</td>
                  <td>{{ $client->other_info }}</td>
                  <td>
                    <center>

                     <a href="{{route('admin.client.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
                      <i class="fa fa-user-plus" style="font-size: 1.3rem"></i></span>
                     </a>

                     <a href="{{route('admin.client.edit',$client->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit client">
                         <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                     </a>
                        {!! Form::open(['method' => 'DELETE','route'=> ['admin.client.delete', $client->id], 'style' => 'display:inline']) !!}
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
