@extends('layouts.app')

@section('content')
<div class="container" style="overflow-x:auto">
    <div class="row justify-content-center">
        <div class="col-md-10">
                
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
                        <th>Email</th>
                        <th>Member Since</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $index => $client)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->created_at->diffForHumans() }}</td>
                            <td>
                                <center>
                                 <a href="{{route('admin.client.create')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Add client">
                                     <i class="fa fa-user-plus" style="font-size: 1.3rem"></i></span>
                                 </a>

                                 <a href="{{route('admin.client.edit',$client->id)}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Edit client">
                                     <i class="fa fa-edit" style="font-size: 1.3rem"></i></span>
                                 </a>
                                 
                                 {!! Form::open(['method' => 'DELETE','route'=> ['admin.client.delete', $client->id], 'style' => 'display:inline']) !!}
                                 {!! Form::button('<i class="fa fa-trash" style="font-size: 1.3rem; color: currentColor"></i></span>',['class'=> 'btn btn-danger','type' => 'submit','data-toggle'=>'tooltip', 'data-placement'=>'bottom', 'title'=>'Remove client','onclick'=>'return confirm("Are you want to delete?")'])  !!}
                                 {!! Form::close()!!}
                                </center>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
