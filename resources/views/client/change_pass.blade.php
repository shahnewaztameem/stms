@extends('layouts.final_layout')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-8">
    <div class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Change Password
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

      <form method="POST" action="{{ route('client.change.pass') }}">
       @csrf
        <div class="form-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password_confirmation" id="password" placeholder="Re-type Password">
        </div>
        <button type="submit" class="btn btn-primary">Change Pass</button>
      </form>
     </div>
    </div>
   </div>
 </div>
</div>
@endsection