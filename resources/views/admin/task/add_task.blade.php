@extends('layouts.final_layout')

@section('content')
    <div class="row project">
     <div class="col-md-10 project__nav">
      <nav>
       <div class="nav nav-tabs" id="nav-tab" role="tablist">
         <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-project" role="tab" aria-controls="nav-project" aria-selected="true">Project</a>
         <a class="nav-item nav-link" id="nav-design-tab" data-toggle="pill" href="#nav-design" role="tab" aria-controls="nav-design" aria-selected="false">Design</a>
         <a class="nav-item nav-link" id="nav-development-tab" data-toggle="tab" href="#nav-development" role="tab" aria-controls="nav-development" aria-selected="false">Development</a>
         <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
       </div>
     </nav>
     </div>
     <div class="col-md-2 project__btn">
      <a href="{{route('admin.client.list')}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Client's List">
       <span>PROJECT'S LIST</span>
      </a>
     </div>
    </div>

    <div class="row">
     <div class="col-12">
      <div class="tab-content" id="nav-tabContent">
       <div class="tab-pane fade show active" id="nav-project" role="tabpanel" aria-labelledby="nav-home-tab">
        @include('partials.add_project')
       </div>
       <div class="tab-pane fade" id="nav-design" role="tabpanel" aria-labelledby="nav-design-tab">
        @include('partials.add_design')
       </div>
       <div class="tab-pane fade" id="nav-development" role="tabpanel" aria-labelledby="nav-development-tab">
        @include('partials.add_development')
       </div>
       <div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">
        @include('partials.add_seo')
       </div>
     </div>
     </div>
    </div>
@endsection
{{--  
@section('customJS')
    <script>
     $('.datepicker').datepicker({
      format: 'yyyy/mm/dd'
     });

     // For name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = this.files.length;
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName +' files selected');
    });
    </script>
@endsection  --}}
