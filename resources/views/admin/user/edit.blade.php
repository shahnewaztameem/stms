@extends('layouts.final_layout')

@section('content')
<div class="row justify-content-end pb-3 mr-3">
  <a href="{{route('admin.user.list')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Manager's List">
   <span>MANAGER'S LIST</span>
  </a>
</div>

<div class="row">
 <div class="col-sm-12">
  <div class="card-body">

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

    <div class="form-group row">
     <label for="staticName" class="col-sm-2 col-form-label">Name: </label>
     <div class="col-sm-10">
       <input type="text" class="form-control" name="name" id="staticName" value="{{ $user->name }}" placeholder="Name">
     </div>
    </div>

    <div class="form-group row">
     <label for="staticEmail" class="col-sm-2 col-form-label">Email: </label>
     <div class="col-sm-10">
       <input type="text" class="form-control" name="email" id="staticEmail" value="{{ $user->email }}" placeholder="Email Address">
     </div>
    </div>

        
    <div class="form-group row">
     <label for="staticPhoneNumber" class="col-sm-2 col-form-label">PhoneNumber: </label>
     <div class="col-sm-10">
       <input type="text" class="form-control" name="phone_number" id="staticPhoneNumber" value="{{ $user->phone_number }}" placeholder="Phone Number">
     </div>
    </div>

    @if (auth()->user()->id != $user->id)
    <div class="form-group row">
     <label for="staticUserType" class="col-sm-2 col-form-label">Priviliges: </label>
     <div class="col-sm-10">
       <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="user_type" @if ($user->user_type == 2) checked @endif id="inlineRadio1" value="2">
        <label class="form-check-label" for="inlineRadio1">Manager</label>
       </div>
       <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="user_type" @if ($user->user_type == 0) checked @endif id="inlineRadio2" value="0">
         <label class="form-check-label" for="inlineRadio2">Admin</label>
       </div>
     </div>
    </div>
    @endif
    
    <div class="form-group row">
     <label for="other_info" class="col-sm-2 col-form-label">Other Details: </label>
     <div class="col-sm-10">
       <textarea name="other_info" class="form-control" id="other_info" cols="30" rows="2" placeholder="Other details">{{ $user->other_info }}</textarea>
     </div>
    </div>
        
    <div class="form-group row">
     <label for="password" class="col-sm-2 col-form-label">Password: </label>
     <div class="col-sm-10">
       <input id="password" type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Password">
     </div>
    </div>
        
    <div class="form-group row">
     <label for="password_confirmation" class="col-sm-2 col-form-label">Re-Type Password: </label>
     <div class="col-sm-10">
       <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Re-Type Password">
     </div>
    </div>

    <div class="row justify-content-end">
      <button type="submit" class="btn btn-danger mr-2">Cancel</button>
      <button type="submit" class="btn btn-info mr-3">Update</button>
    </div>
   </form>
  </div>
 </div>
</div>
@endsection