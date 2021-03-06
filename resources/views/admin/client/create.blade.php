@extends('layouts.final_layout')

@section('content')
<div class="row justify-content-end pb-3 mr-3">
  <a href="{{route('admin.client.list')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Client's List">
   <span>CLIENT'S LIST</span>
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

   <form method="POST" id="create-client" action="{{ route('admin.client.create') }}">
    @csrf

    <div class="form-group row">
     <label for="staticName" class="col-sm-2 col-form-label">Name: </label>
     <div class="col-sm-10">
       <input type="text" class="form-control" name="name" id="staticName" value="{{ old('name') }}" placeholder="Point of contact">
     </div>
    </div>

    <div class="form-group row">
     <label for="staticCompany" class="col-sm-2 col-form-label">Company: </label>
     <div class="col-sm-10">
       <input type="text" class="form-control" name="company" id="staticCompany" value="{{ old('company') }}" placeholder="Company Name">
     </div>
    </div>

    <div class="form-group row">
     <label for="staticEmail" class="col-sm-2 col-form-label">Email: </label>
     <div class="col-sm-10">
       <input type="text" class="form-control" name="email" id="staticEmail" value="{{ old('email') }}" placeholder="Email Address">
     </div>
    </div>

        
    <div class="form-group row">
     <label for="staticPhoneNumber" class="col-sm-2 col-form-label">Telephone: </label>
     <div class="col-sm-10">
       <input type="number" class="form-control" name="phone_number" id="staticPhoneNumber" value="{{ old('phone_number') }}" placeholder="Phone Number">
     </div>
    </div>

    <div class="form-group row" style="display: none">
      <input class="form-check-input" type="text" name="user_type" id="inlineRadio1" value="1">
    </div>
    
    <div class="form-group row">
     <label for="other_details" class="col-sm-2 col-form-label">Other Info: </label>
     <div class="col-sm-10">
       <textarea name="other_info" class="form-control" id="other_details" cols="30" rows="2" placeholder="Other Info">{{ old('other_info') }}</textarea>
     </div>
    </div>
        
    <div class="form-group row">
     <label for="password" class="col-sm-2 col-form-label">Password: </label>
     <div class="col-sm-10">
       <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Password">
     </div>
    </div>
        
    <div class="form-group row">
     <label for="password_confirmation" class="col-sm-2 col-form-label">Re-Type Password: </label>
     <div class="col-sm-10">
       <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Re-Type Password">
     </div>
    </div>

    <div class="row justify-content-end">
      <button id="cancel" class="btn btn-danger mr-2">Cancel</button>
      <button type="submit" class="btn btn-primary mr-3">Add</button>
    </div>
   </form>
  </div>
 </div>
</div>
@endsection

@section('customJS')
    <script>
      $('#cancel').click((e)=>{
        e.preventDefault();
        $('#create-client')[0].reset();
      });
    </script>
@endsection