@extends('layouts.final_layout')

@section('content')

<div class="row pb-3">
 <div class="col-sm-4">
  <div class="row">
   <div class="col-10">
    <strong>Designs</strong>
   </div>
   <div class="col-2">
    <a href="{{route('admin.client.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
     <span><i class="fa fa-plus" style="font-size: 1.3rem"></i></span>
    </a>
   </div>
  </div>
 </div>
 <div class="col-sm-4">
  <div class="row">
   <div class="col-10">
    <strong>Developemnts</strong>
   </div>
   <div class="col-2">
    <a href="{{route('admin.client.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
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
    <a href="{{route('admin.client.create')}}" data-toggle="tooltip" data-placement="bottom" title="Add client">
     <span><i class="fa fa-plus" style="font-size: 1.3rem"></i></span>
    </a>
   </div>
  </div>
 </div>
</div>

<div class="row">
 <div class="col-sm-4">
   <div class="card">
     <div class="card-body">
       <h5 class="card-title">Special title treatment</h5>
       <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
       <a href="#" class="btn btn-primary">Go somewhere</a>
     </div>
   </div>
 </div>
 <div class="col-sm-4 pt-xs-2 pt-sm-0">
   <div class="card">
     <div class="card-body">
       <h5 class="card-title">Special title treatment</h5>
       <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
       <a href="#" class="btn btn-primary">Go somewhere</a>
     </div>
   </div>
 </div>

 <div class="col-sm-4 pt-xs-2 pt-sm-0">
   <div class="card">
     <div class="card-body">
       <h5 class="card-title">Special title treatment</h5>
       <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
       <a href="#" class="btn btn-primary">Go somewhere</a>
     </div>
   </div>
 </div>
</div>
@endsection