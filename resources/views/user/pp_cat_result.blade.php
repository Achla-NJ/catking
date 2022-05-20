@extends('layout')
@section('title','Cat Predictor')
@section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
@endsection
@section('page_css')
<link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
@endsection
@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3">
   <div class="breadcrumb-title pe-3">Home</div>
   <div class="ps-3">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item">   @if (Auth::user()->role=="student")
              <a href="{{route('profile.view')}}"><i class="bx bx-home-alt"></i></a>
           @else
              <a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
           @endif
            </li>
            <li class="breadcrumb-item active" aria-current="page">Personal Interviews</li>
         </ol>
      </nav>
   </div>
</div>
@endsection
@section('main_content')
<div class="card">
   <div class="card-body">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="x_panel">
             <div class="x_title">
               <h2>Submit your details to get the CAT Percentile Prediction</h2>
               <div class="clearfix"></div>
             </div>
             <div class="x_content">
                           <div class="row">
                 <div class="col-md-6">
                   <table class="table table-striped" style="width:90% !important;">
                     <thead>
                       <tr style="background-color:#006699!important;color:white;">
                         <th scope="col">#</th>
                         <th scope="col">Section</th>
                         <th scope="col">Score</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <th scope="row">1</th>
                         <th><a href="#">VARC</a></th>
                         <td><a href="#">-1</a></td>
                       </tr>
                       <tr>
                         <th scope="row">2</th>
                         <th><a href="#">DILR</a></th>
                         <td><a href="#">0</a></td>
                       </tr>
                       <tr>
                         <th scope="row">3</th>
                         <th><a href="#">Quants</a></th>
                         <td><a href="#">0</a></td>
                       </tr>
                       <tr>
                         <th scope="row"></th>
                         <th scope="row">Total Score</th>
                         <th><a href="#">-1 </a></th>
                       </tr>
                       <tr style="background-color:#dedede !important;color:#006699 !important; font-size:13px;">
                         <th scope="row"></th>
                         <th scope="row">Expected Percentile</th>
                         <th scope="row">0%tile - 10%tile </th>
                       </tr>
   
                     </tbody>
                   </table>
                 </div>
   
                 <div class="col-md-6">
                   <div class="row">
                     <div class="col-md-6">
   
                       <a href="https://www.courses.catking.in/iim-wat-pi-courses/" target="_blank"><img src="{{asset('assets/images/pp_poster_iim_wat.png')}}" class="img img-responsive"></a>
   
                     </div>
                     <div class="col-md-6">
   
                       <a href="https://www.courses.catking.in/xat-courses/"target="_blank"><img src="{{asset('assets/images/pp_poster_xat.png')}}" class="img img-responsive"></a>
   
                     </div>
                   </div>
                 </div>
               </div>
               <p style="color:red;">PS: The scores, percentiles and cut-offs mentioned in this analysis are indicators based on the feedback from students and CATKing experts and are in no way related to the results which will be declared by the IIMs in January. You are advised to wait for the results.</p>           
   
    @include('components.partial_college_list')
       </div>
   </div>
   
   <br>

               <p style="color:#006699; font-size:18px;">
                 <br><br>
                 <strong> Need Help with your Personal Interviews? <br><a href="profile_edit.php">Click here to Update your profile to be evaluated by SPJain &amp; NMIMS Alumni!</a> </strong>
               </p>
               
             </div>
           </div>
         </div>
   
   
       </div>
   </div>
</div>
@endsection
@section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
@endsection
@section('script')

   @if(Session::has('success'))
<script>
   successMessage("{{ Session::get('success') }}")
</script>
@endif
@endsection