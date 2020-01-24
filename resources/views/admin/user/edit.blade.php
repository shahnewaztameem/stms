@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-8">
    <div class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Edit User
      </h3>

      @if( Session::get('success') )
        <div class="alert alert-success container" id="div3">
            <strong>Success!</strong> {{Session::get('success')}}
        </div>
      @endif

      @if ($errors->any())
      <div class="form-group row">
        <div class="col-md-12">
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @endif

      <form method="POST" action="{{ route('admin.user.edit', $user->id) }}">
       @csrf
       <div class="form-group">
         <input type="text" class="form-control" name="name" id="email" placeholder="Enter name" value="{{ $user->name }}">
       </div>
       <div class="form-group">
         <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email-address" value="{{ $user->email }}">
       </div>
       <div class="form-group">
         <input type="password" name="password" class="form-control" id="password" placeholder="Password">
       </div>
       <div class="form-group">
         <input type="password" class="form-control" name="password_confirmation" id="password" placeholder="Re-type Password">
       </div>
       <button type="submit" class="btn btn-primary">Update User</button>
      </form>
     </div>
    </div>
   </div>
 </div>
</div>
@endsection