@extends('layout')
@section('title','Dashboard')
@section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}"  rel="stylesheet" />
@endsection
@section('page_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
<style>
   .card-h{
   height:100%;
   }
   .blue{
      background: #4472c4;
   }
   .orange{
      background: #ed7d31;
   }
   .gray{
      background: #6b7a99;
   }
   .text-blue{
      color: #4472c4;
   }
   .text-orange{
      color: #ed7d31;
   }
   .text-gray{
      color: #6b7a99;
   }
   .border-blue{
      border-color:  #4472c4!important;
   }
   .border-orange{
      border-color:  #ed7d31!important;
   }
   .border-gray{
      border-color:  #6b7a99!important;
   }
</style>
@endsection 
@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3" style="justify-content: space-between;">
   <div class="d-flex">
      <div class="breadcrumb-title pe-3">Home</div>
      <div class="ps-3">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
               <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
               </li>
               <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
         </nav>
      </div>
   </div>
</div>
@endsection
@section('main_content')
<div class="page-content" id="app">
   <div class="row ">
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-blue">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col">
                     <h6 class="mb-0">Total Students</h6>
                  </div>
                  <div class="col">
                     <input  type="text" class="form-control" name="daterange" id="present-student-date">
                  </div>
                  <div class="col-auto">
                     <button @click.prevent="getPresentStudent()" class="btn btn-sm btn-primary" id="student-btn">Go</button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-blue">@{{total_student}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle blue text-white ms-auto"><i class="bx bxs-group"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-orange">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col-md-10">
                     <h6 class="m-2">CATKing Students</h6>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-orange">@{{catking.total_catking_student}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle orange text-white ms-auto"><i class="bx bxs-bar-chart-alt-2"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-gray">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col-md-10">
                     <h6 class="m-2">Non-CATKing Students </h6>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-gray">@{{catking.total_non_catking_student}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle gray text-white ms-auto"><i class="bx bxs-user"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-orange">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col">
                     <h6 class="mb-0">Profile Reviewed</h6>
                  </div>
                  <div class="col">
                     <input  type="text" class="form-control" name="daterange" id="profile-review-range">
                  </div>
                  <div class="col-auto">
                     <button @click.prevent="fetchProfileReview()" class="btn btn-sm btn-primary" id="profile-review-btn">Go</button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-orange">@{{profile_review}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle orange text-white ms-auto"><i class="bx bx-message-rounded-check"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>      
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-gray">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col">
                     <h6 class="mb-0">SOP submitted</h6>
                  </div>
                  <div class="col">
                     <input  type="text" class="form-control" name="daterange" id="sop-submit-range">
                  </div>
                  <div class="col-auto">
                     <button @click.prevent="fetchSopSubmit()" class="btn btn-sm btn-primary" id="sop-submit-btn">Go</button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-gray">@{{total_sop_submit}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle gray text-white ms-auto"><i class="bx bx-copy-alt"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-blue">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col">
                     <h6 class="mb-0">SOP Reviewed</h6>
                  </div>
                  <div class="col">
                     <input  type="text" class="form-control" name="daterange" id="sop-review-range">
                  </div>
                  <div class="col-auto">
                     <button @click.prevent="fetchSopReview()" class="btn btn-sm btn-primary" id="sop-review-btn">Go</button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-blue">@{{total_sop_review}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle blue text-white ms-auto"><i class="bx bx-message-rounded-check"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-orange">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col">
                     <h6 class="mb-0">Interview Call Getters</h6>
                  </div>
                  <div class="col">
                     <input  type="text" class="form-control" name="daterange" id="call-get-range">
                  </div>
                  <div class="col-auto">
                     <button @click.prevent="fetchCallGet()" class="btn btn-sm btn-primary" id="call-get-btn">Go</button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-orange">@{{total_call_get}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle orange text-white ms-auto"><i class="bx bx-phone-call"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card radius-10 border-start border-0 border-3 border-blue">
            <div class="card-header bg-transparent">
               <div class="row">
                  <div class="col">
                     <h6 class="mb-0">Interview Taken</h6>
                  </div>
                  <div class="col">
                     <input  type="text" class="form-control" name="daterange" id="interview-range">
                  </div>
                  <div class="col-auto">
                     <button @click.prevent="fetchInterview()" class="btn btn-sm btn-primary" id="interview-btn">Go</button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div>
                     <h4 class="my-1 text-blue">@{{interview}}</h4>
                  </div>
                  <div class="widgets-icons-2 rounded-circle blue text-white ms-auto"><i class="bx bx-user-pin"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
   </div>

   <div class="row">
      <div class="col-md-12">
         <div class="card-header bg-transparent px-0">
            <div class="d-block align-items-center">
               <div class="row gy-3 gy-lg-0">
                  <div class="col">
                     <h6 class="mb-0">Actual vs Target profile registration achieved</h6>
                  </div>
                  <div class="col-auto">
                     <a data-bs-toggle="modal" data-bs-target="#exampleModal" role="button" class="btn-sm btn-primary"><i class="fa fa-edit"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="card radius-10 ">
            <div class="card-body">
               
               <div class="chart-container-1">
                  <registration-chart :actual-data="Object.values(actual_data)" :target-data="Object.values(target_data)" :chart-label="Object.keys(target_data)" chart-id="registration-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
              
               </div>
            </div>
          
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-6">
         <div class="card-header bg-transparent mb-3 px-0">
            <div class="row gy-3">
               <div class="col-12">
                  <h6 class="mb-0">Growth of  Total No. Of Students - CATKing and Non-CATKing</h6>
               </div>
            </div>
         </div>
         <div class="row align-items-center mb-3">
            <div class="col-md-5">
               Select Year:
            </div>
            <div class="col-md-6 ms-auto">
               <select class="form-control" @change.prevent="fetchCatkingGrowth" id="catking-growth-year" name="year-range">
               @for ($i = date('Y'); $i >= 1990; $i--)
               <option value="{{$i}}" {{ $i==date('Y') ? "selected":''}}>{{$i}}</option>
               @endfor
               </select>
            </div>
         </div>
         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <catking-growth-chart :catking-growth-label="Object.keys(catking_growth)" :non-catking-growth-data="Object.values(non_catking_growth)" :catking-growth-data="Object.values(catking_growth)" :total-growth-data="Object.values(total_growth)"   chart-id="catking-growth-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>

               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card-header bg-transparent mb-3 px-0">
            <div class="row gy-3">
               <div class="col-12">
                  <h6 class="mb-0">Growth % of Students</h6>
               </div>
            </div>
         </div>
         <div class="row align-items-center mb-3">
            <div class="col-md-5">
               Select Year:
            </div>
            <div class="col-md-6 ms-auto">
               <select class="form-control" @change.prevent="fetchStudentGrowth" id="student-year" name="year-range">
               @for ($i = date('Y'); $i >= 1990; $i--)
               <option value="{{$i}}" {{ $i==date('Y') ? "selected":''}}>{{$i}}</option>
               @endfor
               </select>
            </div>
         </div>
         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  
                  <student-chart :student-data="Object.values(student_growth)" :student-label="Object.keys(student_growth)" :student-noncatking="Object.values(student_non_catking_growth)" :student-catking="Object.values(student_catking_growth)" 
                  chart-id="student-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
         </div>
      </div>
      
   </div>

   <div class="row">
      <div class="col-md-6">
         <div class="card-header bg-transparent px-0">
            <div class="row ">
               <div class="col">
                  <h6 class="mb-0">Students appearing for different exams</h6>
               </div>
            </div>
         </div>
         <div class="row my-3 gy-3 gy-md-0">
            <div class="col ms-auto">
               <select name="exam" id="exams" class="form-control multiple-select" multiple >
                  
                  @php $exams = \App\Models\Exam::all(); @endphp
                  @foreach ($exams as $key => $item)
                     <option value="{{$item->name}}">{{$item->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col">
               <input  type="text" class="form-control" id="exam-range" name="daterange">
            </div>
            <div class="col-auto">
               <button  class="btn btn-primary btn-sm " @click.prevent="fetchExams" id="exam-btn">Go</button>
            </div>
         </div>
         <div class="card w-100 radius-10">
            <div class="card-body">
               <div class="chart-container-1">
                  <exam-chart  :exam-labels="Object.keys(exams)" :exam-data="Object.values(exams)"  chart-id="exam-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
               
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card-header bg-transparent px-0">
            <div class="d-flex align-items-center">
               <div class="row gy-3">
                  <div class="col">
                     <h6 class="mb-0">Students with @{{score_exam2.toUpperCase()}} percentile</h6>
                  </div>
               </div>
            </div>
         </div>
         <div class="row my-3 gy-3 gy-md-0">
            <div class="col-md-3">
               <select class="form-control" id="exam_type2" >
                  @php $exams = \App\Models\Exam::all(); @endphp
                  @foreach ($exams as $key => $item)
                     <option value="{{$item->name}}">{{$item->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="score-range2">
            </div>
            <div class="col-auto">
               <button  class="btn btn-primary btn-sm " @click.prevent="fetchScore2">Go</button>
            </div>
         </div>
         
         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <score-chart2  :score-label="score_label2" :score-data="score_data2" :score-exam="score_exam2.toUpperCase()" chart-id="score-chart2" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
            <!--end row-->
         </div>
      </div>
   </div>
   <!--end row-->
   <div class="row mb-4 gy-3 gy-lg-0">
      

      
      {{-- <div class="col-12 col-md-4">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">Growth % of profile reviewed</h6>
               </div>
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-5">
               Select Year:
            </div>
            <div class="col-md-6 ms-auto">
               <select class="form-control" @change.prevent="fetchProfileGrowth" id="profile-year">
               @for ($i = date('Y'); $i >= 1990; $i--)
               <option value="{{$i}}" {{ $i==date('Y') ? "selected":''}}>{{$i}}</option>
               @endfor
               </select>
            </div>
         </div>
         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <profile-chart :profile-data="Object.values(profile_growth)" :profile-label="Object.keys(profile_growth)" chart-id="profile-chart"  style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
         </div>
      </div> --}}
      

      

      <div class="col-md-6">
         <div class="card-header bg-transparent px-0">
            <div class="d-flex align-items-center">
               <div class="row gy-3">
                  <div class="col-md-12">
                     <h6 class="mb-0">Students with @{{score_exam.toUpperCase()}} percentile</h6>
                  </div>
               </div>
            </div>
         </div>
         <div class="row my-3 gy-3 gy-md-0">
            <div class="col-md-2">
               <select class="form-control" id="exam_type" >
                  @php $exams = \App\Models\Exam::all(); @endphp
                  @foreach ($exams as $key => $item)
                     <option value="{{$item->name}}">{{$item->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-3">
               <select class="form-control" id="score_type" >
                  <option value="percentile">Percentile</option>
                  <option value="score">Score</option>
               </select>
            </div>
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="score-range">
            </div>
         </div>
         <div class="row my-3">
           
            <div class="col">
               <input  type="number" class="form-control" id="score_from" placeholder="From" value="0">
            </div>
            <div class="col">
               <input  type="number" class="form-control" id="score_to" placeholder="To" value="100">
            </div>
            <div class="col-auto">
               <button  class="btn btn-primary btn-sm " @click.prevent="fetchScore" id="score-btn">Go</button>
            </div>
         </div>


         <div class="card w-100 radius-10">
            <div class="card-body">
               <div class="card radius-10 border shadow-none">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div>
                           <p class="mb-0 text-secondary"><b> Total Students In @{{score_label[0]}} Range</b></p>
                           <h4 class="my-1">@{{score_data[0]}}</h4>
                        </div>
                        <div class="widgets-icons-2 bg-gradient-cosmic text-white ms-auto"><i class="bx bxs-comment-detail"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>


      </div>
      
   </div>
   <!--end row-->

   <div class="row">
      <div class="col-md-6 ">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">Received And Converted Calls</h6>
               </div>
            </div>
         </div>
         <div class="row my-3 gy-3 gy-md-0">
            <div class="col ms-auto">
               <select name="call-college" id="call-college" multiple class="form-select multiple-select" >
                  
                  @php $college = \App\Models\College::where('created_by_user','no')->get(); @endphp
                  @foreach ($college as $key => $item)
                     <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="call-range">
            </div>
            <div class="col-auto">
               <button @click.prevent="fetchCall()" class="btn btn-sm btn-primary">Go</button>
            </div>
         </div>

         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <call-chart  :call-labels="call_labels" :call-received="call_received" :call-converted="call_converted" :call-dream="call_dream"  chart-id="call-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
            <div class="row row-group border-top g-0">
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-blue">@{{calls.converted}}</h4>
                     <p class="mb-0">Converted</p>
                  </div>
               </div>
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-orange">@{{calls.received}}</h4>
                     <p class="mb-0">Recieved</p>
                  </div>
               </div>
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-gray">@{{calls.dream}}</h4>
                     <p class="mb-0">Dream College</p>
                  </div>
               </div>
            </div>
            <!--end row-->
         </div>
      </div>
      <div class="col-md-6">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">Uploaded And Reviewed Sops</h6>
               </div>
            </div>
         </div>
         <div class="row my-3 gy-3 gy-md-0">
            <div class="col ms-auto">
               <select name="sop-college" id="sop-college" multiple class="form-select multiple-select" >
                  
                  @php $college = \App\Models\College::where('created_by_user','no')->get(); @endphp
                  @foreach ($college as $key => $item)
                     <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="sop-range">
            </div>
            <div class="col-auto">
               <button @click.prevent="fetchSop()" class="btn btn-sm btn-primary">Go</button>
            </div>
         </div>

        
         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <sop-chart  :sop-data="Object.values(interview_percent)" :sop-labels="sop_labels" :sop-uploads="sop_uploads" :sop-reviews="sop_reviews" chart-id="sop-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
            <div class="row row-group border-top g-0">
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-blue">@{{sops.upload}}</h4>
                     <p class="mb-0">Upload</p>
                  </div>
               </div>
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-orange">@{{sops.review}}</h4>
                     <p class="mb-0">Reviewed</p>
                  </div>
               </div>
            </div>
            <!--end row-->
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-6">
         <div class="card-header bg-transparent px-0">
            <div class="d-flex align-items-center">
               <div class="row gy-3">
                  <div class="col-md-12">
                     <h6 class="mb-0">CATKing & Non-CATKing Students</h6>
                  </div>
               </div>
            </div>
         </div>
         <div class="row my-3 gy-3 gy-md-0">
            <div class="col-md-4 col-sm-6">
               <select class="form-control" id="state">
                  <option value="">-Select State-</option>
                  {{$states = App\Models\State::all()}}
                  @foreach ($states as $state)
                     <option value="{{$state->id}}">{{$state->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="catking_student_range" >
            </div>
            <div class="col-auto">
               <button  class="btn btn-primary btn-sm " @click.prevent="getCatkingStudent()">Go</button>
            </div>
         </div>
         <div class="card radius-10">
            <div class="card-body">
               <p class="text-center">Distribution by state</p>
               <div class="chart-container-1">
                  <catking-chart :chart-data="Object.values(catking_percent)" chart-id="catking-chart-217921" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
            <ul class="list-group list-group-flush">
               <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">CATKing Students<span class="badge badge-warning  rounded-pill" style="background:#4472c4;">@{{catking.total_catking_student}}</span>
               </li>
               <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Non-CATKing Students <span class="badge rounded-pill" style="background:#ed7d31;">@{{catking.total_non_catking_student}}</span>
               </li>
            </ul>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">Top 5 states</h6>
               </div>
            </div>
         </div>
         <div class="row my-3">
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="top-state-range">
            </div>
            <div class="col-auto">
               <button @click.prevent="fetchTopState()" class="btn btn-sm btn-primary">Go</button>
            </div>
         </div>

        
         <div class="card radius-10 ">
            <div class="card-body">
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th>State</th>
                        <th>CATKing Students</th>
                        <th>Non CATKing Students</th>
                        <th>Total Students</th>
                     </tr>
                  </thead>
                  <tbody id="top_state">
                  </tbody>

               </table>
            </div>
            <!--end row-->
         </div>
      </div>
   </div>
   <div class="row">
      
      <div class="col-md-6 ">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">Students based on degrees</h6>
               </div>
            </div>
         </div>
         <div class="row my-3">
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="degree-range">
            </div>
            <div class="col-auto">
               <button  class="btn btn-primary btn-sm " @click.prevent="fetchStudentDegree" id="degree-btn">Go</button>
            </div>
         </div>
         <div class="card w-100 radius-10">
            <div class="card-body">
               <div class="chart-container-1">
                  <degree-chart  :degree-labels="Object.keys(student_degree)" :degree-data="Object.values(student_degree)"  chart-id="degree-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
               
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">Students work experience</h6>
               </div>
            </div>
         </div>
         <div class="row my-3">
            <div class="col">
               <input  type="text" class="form-control" id="work-range" name="daterange">
            </div>
            <div class="col-auto">
               <button  class="btn btn-primary btn-sm " @click.prevent="fetchWorks" id="work-btn">Go</button>
            </div>
         </div>
         <div class="card w-100 radius-10">
            <div class="card-body">
               <div class="chart-container-1">
                  <work-chart :chart-data="Object.values(work_percent)" chart-id="work-chart-217921" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>

               </div>

               
            </div>
            <ul class="list-group list-group-flush">
               <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Part Time<span class="badge badge-warning  rounded-pill" style="background:#4472c4;">@{{works.part_time}}</span>
               </li>
               <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Full Time <span class="badge rounded-pill" style="background:#ed7d31;">@{{works.full_time}}</span>
               </li>
               <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Internship <span class="badge rounded-pill" style="background:#6b7a99;">@{{works.internship}}</span>
               </li>
            </ul>
         </div>
      </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Actual vs Target profile registration achieved</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="mb-3">
                     <label for="target_no" class="form-label">Enter Target Value</label>
                     <input type="text" class="form-control" id="target_no">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" @click.prevent="fetchTargetData" data-bs-dismiss="modal" aria-label="Close">Save changes</button>
               </div>
            </div>
         </div>
      </div>
   </div>

      
      
      
      
      {{-- <div class="col-md-4">
         <div class="card-header bg-transparent px-0">
            <div class="d-flex align-items-center">
               <div class="row gy-3">
                  <div class="col-md-12">
                     <h6 class="mb-0">Interviews & Reviews</h6>
                  </div>
               </div>
            </div>
         </div>
         <div class="row my-3">
            <div class="col">
               <input  type="text" class="form-control" name="daterange" id="interview-range">
            </div>
            <div class="col-auto">
               <button @click.prevent="fetchInterview()" class="btn btn-sm btn-primary">Go</button>
            </div>
         </div>
         <div class="card radius-10 w-100 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <interview-chart :interview-data="interview_percent" chart-id="interview-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
            <ul class="list-group list-group-flush">
               <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Interview Taken <span class="badge rounded-pill" style="background:#f53541;">@{{interview.interview_taken}}</span>
               </li>
               <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Profile Reviewed<span class="badge rounded-pill" style="background:#2e676e;">@{{interview.profile_review}}</span>
               </li>
            </ul>
         </div>
      </div> --}}
      
      

   <!--end row-->
   
      
      
      


     

      
      

     

      {{-- <div class="col-md-3 col-md-5  col-xl-4">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">SOP review performance</h6>
               </div>
            </div>
         </div>
        
        
         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <sop-performance-chart  :sop-upload="[sop_performance.upload]"  :sop-review="[sop_performance.review]"  :sop-nonreview="[sop_performance.non_review]" chart-id="sop-performance-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
            <div class="row row-group border-top g-0">
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-danger">@{{sop_performance.upload}}</h4>
                     <p class="mb-0">Upload</p>
                  </div>
               </div>
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-success">@{{sop_performance.review}}</h4>
                     <p class="mb-0">Reviewed</p>
                  </div>
               </div>
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-success">@{{sop_performance.non_review}}</h4>
                     <p class="mb-0">Non-Reviewed</p>
                  </div>
               </div>
            </div>
            <!--end row-->
         </div>
      </div>

      <div class="col-md-3 col-md-5  col-xl-4">
         <div class="card-header bg-transparent px-0">
            <div class="row">
               <div class="col">
                  <h6 class="mb-0">College Wise performance</h6>
               </div>
            </div>
         </div>
        
        
         <div class="card radius-10 ">
            <div class="card-body">
               <div class="chart-container-1">
                  <call-performance-chart  :call-dream="[call_performance.dream]" :call-receive="[call_performance.receive]":call-convert="[call_performance.convert]" chart-id="call-performance-chart" style="position: absolute;width:100%;height:100%;top:0;left:0;"/>
               </div>
            </div>
            <div class="row row-group border-top g-0">
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-danger">@{{call_performance.dream}}</h4>
                     <p class="mb-0">Dream College</p>
                  </div>
               </div>
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-success">@{{call_performance.receive}}</h4>
                     <p class="mb-0">Receive Calls</p>
                  </div>
               </div>
               <div class="col">
                  <div class="p-3 text-center">
                     <h4 class="mb-0 text-success">@{{call_performance.convert}}</h4>
                     <p class="mb-0">Converted Calls</p>
                  </div>
               </div>
            </div>
            <!--end row-->
         </div>
      </div> --}}
   
</div>
@endsection

@section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/vue-chartjs@3.5.1/dist/vue-chartjs.min.js"></script>
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/chartjs/js/Chart.extension.js')}}"></script> --}}
<script src="https://unpkg.com/vue@2.6.12/dist/vue.js"></script>
<script src="https://unpkg.com/chart.piecelabel.js"></script>
@endsection
@section('script')
<script>
   $(function() {
      
      $(".yearpicker").datepicker({
         format: "yyyy",
         viewMode: "years", 
         minViewMode: "years",
         autoclose:true
      });   
   $('.multiple-select').select2();

   });

</script>
<script>
   Vue.component("student-chart", {
      extends: VueChartJs.Line,
      props: ['studentLabel','studentData','chartId','studentCatking','studentNoncatking'],
      data(){
         return{
            labels:[],
            student_data:[],
            student_catking:[],
            student_non_catking:[],
         }
      },
      mounted() {
         this.render()        
      },
      watch: {
         ['studentData'] (to, from) {
            this.labels = this.studentLabel;
            this.student_data = this.studentData;
            this.student_catking = this.studentCatking;
            this.student_non_catking = this.studentNoncatking;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.1)');

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, '#6b7a99');
            gradientStroke3.addColorStop(1, 'rgba(165, 165, 165, 0.1)');
   
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Student Growth',
                        data:this.student_data,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        borderColor: gradientStroke1,
                        borderWidth: 3
                     },
                     
                     {
                        label: 'Non CATKing Student Growth',
                        data: this.student_non_catking,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke2,
                        backgroundColor: gradientStroke2,
                        borderColor: gradientStroke2,
                        borderWidth: 3
                   },
                   {
                        label: 'CATKing Growth',
                        data: this.student_catking,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke3,
                        backgroundColor: gradientStroke3,
                        borderColor: gradientStroke3,
                        borderWidth: 3
                   }
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });

   Vue.component("catking-growth-chart", {
      extends: VueChartJs.Bar,
      props: ['catkingGrowthLabel','catkingGrowthData','chartId','nonCatkingGrowthData','totalGrowthData'],
      data(){
         return{
            labels:[],
            catking_growth_data:[],
            non_catking_growth_data:[],
            total_growth_data:[],
         }
      },
      mounted() {
         this.render()        
      },
      watch: {
         ['catkingGrowthData'] (to, from) {
            this.labels = this.catkingGrowthLabel;
            this.catking_data = this.catkingGrowthData;
            this.non_catking_data = this.nonCatkingGrowthData;
            this.total_growth_data = this.totalGrowthData;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.3)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            // gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.3)');

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, '#6b7a99');
            // gradientStroke3.addColorStop(1, 'rgba(165, 165, 165, 0.3)');
   
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Total Growth',
                        data: this.total_growth_data,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        borderColor: gradientStroke1,
                        borderWidth: 3
                     },
                     {
                           label: 'Non CATKing Student Growth',
                           data: this.non_catking_data,
                           pointBorderWidth: 2,
                           pointHoverBackgroundColor: gradientStroke2,
                           backgroundColor: gradientStroke2,
                           borderColor: gradientStroke2,
                           borderWidth: 3
                     },
                     {
                        label: 'CATKing Student Growth',
                        data:this.catking_data,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke3,
                        backgroundColor: gradientStroke3,
                        borderColor: gradientStroke3,
                        borderWidth: 3
                     },
                     
                   
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });

   Vue.component("profile-chart", {
      extends: VueChartJs.Line,
      props: ['profileLabel','profileData','chartId'],
      data(){
         return{
            labels:[],
            profile_data:[],
         }
      },
      mounted() {
         this.render()        
      },
      watch: {
         ['profileData'] (to, from) {
            this.labels = this.profileLabel;
            this.profile_data = this.profileData;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#fc4a1a');
            gradientStroke1.addColorStop(1, 'rgba(248, 157, 45,0.5)');
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'profile Growth',
                        data:this.profile_data,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        borderColor: gradientStroke1,
                        borderWidth: 3
                     }
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });


   Vue.component("registration-chart", {
      extends: VueChartJs.Line,
      props: ['actualData','chartLabel','chartId','targetData'],
      data(){
         return{
            labels:[],
            actual_data:[],
            target_data:[],
         }
      },
      mounted() {
         this.render()        
      },
      watch: {
         ['targetData'] (to, from) {
            this.labels = this.chartLabel;
            this.actual_data = this.actualData;
            this.target_data = this.targetData;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.3)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.3)');
   
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Target Data',
                        data:this.target_data,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke1,
                        // backgroundColor: gradientStroke1,
                        borderColor: gradientStroke1,
                        borderWidth: 3
                     },
                     {
                        label: 'Actual Growth',
                        data: this.actual_data,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: gradientStroke2,
                        // backgroundColor: gradientStroke2,
                        borderColor: gradientStroke2,
                        borderWidth: 3
                   },
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   
   Vue.component("catking-chart", {
      extends: VueChartJs.Doughnut,
      props: ['chartData', 'chartId'],
      mounted() {
         this.render()         
      },
      watch: {
         'chartData' (to, from) {
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.3)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            // gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.3)');
   
            this.renderChart(
               {
                  labels: ["CATKing", "Non-CATKing"],
                  datasets: [{
                     backgroundColor: [
                        gradientStroke1,
                        gradientStroke2
                     ],
                     hoverBackgroundColor: [
                        gradientStroke1,
                        gradientStroke2
                     ],
                     data: this.chartData,
                     borderWidth: [1, 1]
                  }]
               },
               
               { responsive: true, maintainAspectRatio: false , 
                  // pieceLabel: {
                  //    mode: 'percentage',
                  //    precision: 1
                  // }
               }
            );
         }
      },
   });
   Vue.component("work-chart", {
      extends: VueChartJs.Pie,
      props: ['chartData', 'chartId'],
      mounted() {
         this.render()         
      },
      watch: {
         'chartData' (to, from) {
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.3)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            // gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.3)');

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, '#6b7a99');
            // gradientStroke3.addColorStop(1, 'rgba(165, 165, 165, 0.3)');
   
            this.renderChart(
               {
                  labels: ["Part Time", "Full Time","Internship"],
                  datasets: [{
                     backgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3
                     ],
                     hoverBackgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3
                     ],
                     data: this.chartData,
                     borderWidth: [1, 1]
                  }]
               },
               
               { responsive: true, maintainAspectRatio: false , }
            );
         }
      },
   });
   
   Vue.component("interview-chart", {
      extends: VueChartJs.Pie,
      props: ['interviewData','chartId'],
      mounted() {
         this.render()         
      },
      watch: {
         'interviewData' (to, from) {
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.3)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            // gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.3)');

            this.renderChart(
               {
                  labels: ["Interview Taken", "Profile Reviewed"],
                  datasets: [{
                     backgroundColor: [
                        gradientStroke1,
                        gradientStroke2
                     ],
   
                     hoverBackgroundColor: [
                        gradientStroke1,
                        gradientStroke2
                     ],
                     data: this.interviewData,
                     borderWidth: [1, 1]
                  }]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   Vue.component("call-performance-chart", {
      extends: VueChartJs.Bar,
      props: ['callDream','callReceive','callConvert','chartId'],
      data(){
         return{
            dream:[],
            receive:[],
            convert:[],
         }
      },
      mounted() {
         this.render()
         
      },
      watch: {
         ['callDream'] (to,from) {
            this.dream = this.callDream;
            this.receive = this.callReceive;
            this.convert = this.callConvert;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#f54ea2');
            gradientStroke1.addColorStop(1, '#ff7676');
   
            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#42e695');
            gradientStroke2.addColorStop(1, '#3bb2b8');

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, '#334466');
            gradientStroke3.addColorStop(1, '#334466');
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Dream College',
                        data: this.dream,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
                     {
                        label: 'Received Calls',
                        data: this.receive,
                        borderColor: gradientStroke2,
                        backgroundColor: gradientStroke2,
                        hoverBackgroundColor: gradientStroke2,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
                     {
                        label: 'Converted Calls',
                        data: this.convert,
                        borderColor: gradientStroke3,
                        backgroundColor: gradientStroke3,
                        hoverBackgroundColor: gradientStroke3,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
   
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   Vue.component("sop-chart", {
      extends: VueChartJs.Bar,
      props: ['sopLabels','sopData','sopUploads','sopReviews','chartId'],
      data(){
         return{
            labels:[],
            uploads:[],
            reviews:[],
         }
      },
      mounted() {
         this.render()
         
      },
      watch: {
         ['sopLabels'] (to,from) {
            this.labels = this.sopLabels;
            this.uploads = this.sopUploads;
            this.reviews = this.sopReviews;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.3)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            // gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.3)');

            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'upload',
                        data: this.uploads,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
                     {
                        label: 'Review',
                        data: this.reviews,
                        borderColor: gradientStroke2,
                        backgroundColor: gradientStroke2,
                        hoverBackgroundColor: gradientStroke2,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
   
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
    Vue.component("sop-performance-chart", {
      extends: VueChartJs.Bar,
      props: ['sopUpload','sopReview','sopNonreview','chartId'],
      data(){
         return{
            dream:[],
            receive:[],
            convert:[],
         }
      },
      mounted() {
         this.render()
         
      },
      watch: {
         ['sopUpload'] (to,from) {
            this.dream = this.sopUpload;
            this.receive = this.sopReview;
            this.convert = this.sopNonreview;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#f54ea2');
            gradientStroke1.addColorStop(1, '#ff7676');
   
            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#42e695');
            gradientStroke2.addColorStop(1, '#3bb2b8');

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, '#334466');
            gradientStroke3.addColorStop(1, '#334466');
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Upload',
                        data: this.dream,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
                     {
                        label: 'Reviewed',
                        data: this.receive,
                        borderColor: gradientStroke2,
                        backgroundColor: gradientStroke2,
                        hoverBackgroundColor: gradientStroke2,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
                     {
                        label: 'Non Reviewed',
                        data: this.convert,
                        borderColor: gradientStroke3,
                        backgroundColor: gradientStroke3,
                        hoverBackgroundColor: gradientStroke3,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
   
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   Vue.component("call-chart", {
      extends: VueChartJs.Bar,
      props: ['callLabels','callData','callDream','callConverted','callReceived','chartId'],
      data(){
         return{
            labels:[],
            converted:[],
            received:[],
            dream:[],
         }
      },
      mounted() {
         this.render()
         
      },
      watch: {
         ['callLabels'] (to,from) {
            this.labels = this.callLabels;
            this.converted = this.callConverted;
            this.received = this.callReceived;
            this.dream = this.callDream;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.3)');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#ed7d31');
            // gradientStroke2.addColorStop(1, 'rgba(230 ,150 ,96 , 0.3)');

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, '#6b7a99');
            // gradientStroke3.addColorStop(1, 'rgba(165, 165, 165, 0.3)');
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'converted',
                        data: this.converted,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
                     {
                        label: 'received',
                        data: this.received,
                        borderColor: gradientStroke2,
                        backgroundColor: gradientStroke2,
                        hoverBackgroundColor: gradientStroke2,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
                     {
                        label: 'Dream College',
                        data: this.dream,
                        borderColor: gradientStroke3,
                        backgroundColor: gradientStroke3,
                        hoverBackgroundColor: gradientStroke3,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
   
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   
   Vue.component("score-chart", {
      extends: VueChartJs.Bar,
      props: ['scoreLabel','scoreData',"scoreExam","chartId"],
      data(){
         return{
            labels:[],
            score:[],
            exam:""
         }
      },
      mounted() {
         this.render()        
      },
      watch: {
         ['scoreData'] (to, from) {
            this.labels = this.scoreLabel;
            this.score = this.scoreData;
            this.exam=this.scoreExam;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Students for '+ this.exam+ " Exam" ,
                        data: this.score ,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     }
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   Vue.component("score-chart2", {
      extends: VueChartJs.Bar,
      props: ['scoreLabel','scoreData',"scoreExam","chartId"],
      data(){
         return{
            labels:[],
            score:[],
            exam:""
         }
      },
      mounted() {
         this.render()        
      },
      watch: {
         ['scoreData'] (to, from) {
            this.labels = this.scoreLabel;
            this.score = this.scoreData;
            this.exam=this.scoreExam;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Students for '+ this.exam+ " Exam" ,
                        data: this.score ,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     }
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   
   Vue.component("degree-chart", {
      extends: VueChartJs.Bar,
      props: ['degreeLabels','degreeData','chartId'],
      data(){
         return{
            labels:[],
            degree:[],
         }
      },
      mounted() {
         this.render()
         
      },
      watch: {
         ['degreeData'] (to,from) {
            this.degree = this.degreeData;
            this.labels = this.degreeLabels;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');
   
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'upload',
                        data: this.degree,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
   
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   Vue.component("exam-chart", {
      extends: VueChartJs.Bar,
      props: ['examLabels','examData','chartId'],
      data(){
         return{
            labels:[],
            exam:[],
         }
      },
      mounted() {
         this.render()
         
      },
      watch: {
         ['examData'] (to,from) {
            this.exam = this.examData;
            this.labels = this.examLabels;
            if(JSON.stringify(to) !== JSON.stringify(from)){
               this.render();
            }
         }
      },
      methods:{
         render () {
            var ctx = document.getElementById(this.chartId).getContext('2d');
   
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#4472c4');
            // gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');
   
            this.renderChart(
               {
                  labels: this.labels,
                  datasets: [
                     {
                        label: 'Exams',
                        data: this.exam,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 1
                     },
   
                  ]
               },
               { responsive: true, maintainAspectRatio: false }
            );
         }
      },
   });
   
   
   const VueSelect = window.VueSelect;
   
   window.app = new Vue({
       el: "#app",
       data() {
           return {
              user:{
                  total_student:"",
                  
               },
               total_student:"",
               exams:{},
               works:{},
               interview:"",
               profile_review:"",
               interview_percent:{},
               sops:{},
               sop_labels:{},
               sop_uploads:{},
               sop_reviews:{},
               scores:{},
               score_label:[],
               score_data:{},
               score_exam:"",
               calls:{},
               call_labels:{},
               call_received:{},
               call_dream:{},
               call_converted:{},
               student_growth:{},
               profile_growth:{},
               student_degree:{},
               target_data:{},
               actual_data:{},
               catking:{},
               catking_percent:{},
               work_percent:{},
               catking_growth:{},
               non_catking_growth:{},
               student_catking_growth:{},
               student_non_catking_growth:{},
               total_growth:{},
               total_sop_submit:"",
               total_sop_review:"",
               total_call_get:"",
               scores2:{},
               score_label2:[],
               score_data2:{},
               score_exam2:"",
               sop_performance:{},
               call_performance:{},
               top_state:"",
           }
       },
       mounted(){
         $('input[name="daterange"]').daterangepicker({startDate: '01/01/2022',});
         this.getPresentStudent();
         this.getCatkingStudent();
         this.fetchExams();
         this.fetchWorks();
         this.fetchInterview();
         this.fetchSop();
         this.fetchScore();
         this.fetchCall();
         this.fetchStudentGrowth();
         this.fetchProfileGrowth();
         this.fetchStudentDegree();
         this.fetchTargetData();
         this.fetchCatkingGrowth();
         this.fetchProfileReview();
         this.fetchSopSubmit();
         this.fetchSopReview();
         this.fetchCallGet();
         this.fetchScore2();
         this.fetchSopPerformance();
         this.fetchCallPerformance();
         this.fetchTopState();

       },
       created(){
          
       }, 
       methods: {
         fetchStudent(){
            $.ajax({
               url: "{{ route('api.admin.student') }}",
               method: 'POST',
               headers: { 'Content-Type': 'application/json' },
               data: {},
               beforeSend: function() {
                  $("#student-btn").html("<img src='{{asset('assets/images/loading.gif')}}' style='height: 25px;'>");
               },
            }).done(response => {
               this.total_student =response;
               $("#student-btn").html('Go')
            });
         },
         getPresentStudent(){
            const $ = window.$;
            const date = $("#present-student-date").daterangepicker().val();
         
            $.ajax({
               url: "{{ route('api.admin.present-students') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               this.total_student =response;
            });
         }, 
         getCatkingStudent(){
            const $ = window.$;
            const date = $("#catking_student_range").daterangepicker().val();
            const state = $("#state").val();
         
            $.ajax({
               url: "{{ route('api.admin.catking-students') }}",
               method: 'POST',
               data: {date,state},
            }).done(response => {
               this.catking =response;
               this.catking_percent =response.catking_percent;
            });
         },  
         fetchWorks(){
            const $ = window.$;
            const date = $("#work-range").daterangepicker().val();
            const work = $("#works").val();
         
            $.ajax({
               url: "{{ route('api.admin.work') }}",
               method: 'POST',
               data: {date,work},
               beforeSend: function() {
                  // setting a timeout
                  $("#work-btn").html("<img src='{{asset('assets/images/loading.gif')}}' style='height: 25px;'>");
               },
            }).done(response => {
               if(response.success){
                  this.works =response.result;
                  this.work_percent =response.result.percent;
               }
               $("#work-btn").html("Go");
            });
         }, 
         fetchExams(){
            const $ = window.$;
            const date = $("#exam-range").daterangepicker().val();
            const exam = $("#exams").val();
         
            $.ajax({
               url: "{{ route('api.admin.exam') }}",
               method: 'POST',
               data: {date,exam},
               beforeSend: function() {
                  $("#exam-btn").html("<img src='{{asset('assets/images/loading.gif')}}' style='height: 25px;'>");
               },
            }).done(response => {
               if(response.success){
                  this.exams = response.result;
               }
               $("#exam-btn").html('Go');
            });
         }, 
         fetchCall(){
            const $ = window.$;
            const date = $("#call-range").daterangepicker().val();
            const college = $("#call-college").val();
         
            $.ajax({
               url: "{{ route('api.admin.call') }}",
               method: 'POST',
               data: {date,college},
            }).done(response => {
               if(response.success){
                  this.calls = response.result;
                  this.call_labels = Object.keys(response.result.college_call_received);
                  this.call_received = Object.values(response.result.college_call_received);
                  this.call_dream = Object.values(response.result.dream_college);
                  this.call_converted =Object.values(response.result.college_call_converted);
                  
               }
            });
         },
         
         fetchInterview(){
            const $ = window.$;
            const date = $("#interview-range").daterangepicker().val();
         
            $.ajax({
               url: "{{ route('api.admin.interview') }}",
               method: 'POST',
               data: {date},
            }).
            done(response => {
               if(response.success){
                  this.interview =response.result;
                  // this.interview_percent =Object.values(response.result.interview_percent);
                  
               }
            });
         }, 
         fetchProfileReview(){
            const $ = window.$;
            const date = $("#profile-review-range").daterangepicker().val();
         
            $.ajax({
               url: "{{ route('api.admin.profile-review') }}",
               method: 'POST',
               data: {date},
            }).
            done(response => {
               if(response.success){
                  this.profile_review =response.result;
                  // this.interview_percent =Object.values(response.result.interview_percent);
                  
               }
            });
         }, 
         fetchSopSubmit(){
            const $ = window.$;
            const date = $("#sop-submit-range").daterangepicker().val();
         
            $.ajax({
               url: "{{ route('api.admin.sop-submit') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               this.total_sop_submit =response;
            });
         },
         fetchSopReview(){
            const $ = window.$;
            const date = $("#sop-review-range").daterangepicker().val();
         
            $.ajax({
               url: "{{ route('api.admin.dashboard-sop-review') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               this.total_sop_review =response;
            });
         },
         fetchCallGet(){
            const $ = window.$;
            const date = $("#call-get-range").daterangepicker().val();
         
            $.ajax({
               url: "{{ route('api.admin.call-get') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               this.total_call_get =response;
            });
         },
         fetchSop(){
            const $ = window.$;
            const date = $("#sop-range").daterangepicker().val();
            const college = $("#sop-college").val();

         
            $.ajax({
               url: "{{ route('api.admin.sop') }}",
               method: 'POST',
               data: {date,college},
            }).done(response => {
               if(response.success){
                  this.sops = response.result;
                  this.sop_labels = Object.keys(response.result.college_sop_reviews);
                  this.sop_uploads = Object.values(response.result.college_sop_upload);
                  this.sop_reviews =Object.values(response.result.college_sop_reviews);
               }
            });
         },    
         fetchScore(){
            const $ = window.$;
            const date = $("#score-range").daterangepicker().val();
            const exam = $("#exam_type").val();
            const from = $("#score_from").val();
            const to = $("#score_to").val();
            var type=$("#score_type").val();
            $.ajax({
               url: "{{ route('api.admin.score') }}",
               method: 'POST',
               data: {date,exam,type,from,to},
               beforeSend: function() {
                  $("#score-btn").html("<img src='{{asset('assets/images/loading.gif')}}' style='height: 25px;'>");
               },
            }).done(response => {
               if(response.success){
                  this.scores = response.result;
                  let exam = Object.keys(response.result);
                  this.score_exam =exam[0];
   
                  let data = Object.values(response.result);
                  this.score_data=Object.values(data[0]);
   
                  this.score_label=Object.keys(data[0]);
                  
               }
               $("#score-btn").html("Go");
            });
         },

         fetchStudentGrowth(){
            const $ = window.$;
            const date = $("#student-year").val();
         
            $.ajax({
               url: "{{ route('api.admin.student-growth') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               if(response.success){
                  // this.student_growth = response.result;
                  this.student_catking_growth = response.result.catking;
                  this.student_non_catking_growth = response.result.non_catking;
                  this.student_growth = response.result.total;
               }
            });
         },
         fetchProfileGrowth(){
            const $ = window.$;
            const date = $("#profile-year").val();
         
            $.ajax({
               url: "{{ route('api.admin.profile-growth') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               if(response.success){
                  this.profile_growth = response.result;
                  
               }
            });
         },
         fetchStudentDegree(){
            const $ = window.$;
            const date = $("#degree-range").daterangepicker().val();
       
            $.ajax({
               url: "{{ route('api.admin.student-degree') }}",
               method: 'POST',
               data: {date},
               beforeSend: function() {
                  $("#degree-btn").html("<img src='{{asset('assets/images/loading.gif')}}' style='height: 25px;'>");
               },
            }).done(response => {
               if(response.success){
                  this.student_degree = response.result;
               }
               $("#degree-btn").html('Go');
            });
         },
         fetchTargetData(){
            const $ = window.$;
            const target_no = $("#target_no").val();
       
            $.ajax({
               url: "{{ route('api.admin.target') }}",
               method: 'POST',
               data: {target_no},
            }).done(response => {
               if(response.success){
                  this.target_data = response.result.target;
                  this.actual_data =response.result.actual;
                  $("#target_no").val('');
               }
            });
         },
         fetchCatkingGrowth(){
            const $ = window.$;
            const date = $("#catking-growth-year").val();
         
            $.ajax({
               url: "{{ route('api.admin.catking-growth') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               if(response.success){
                  this.catking_growth = response.result.catking;
                  this.non_catking_growth = response.result.non_catking;
                  this.total_growth = response.result.total;
                  
               }
            });
         },
         fetchScore2(){
            const $ = window.$;
            const date = $("#score-range2").daterangepicker().val();
            const exam = $("#exam_type2").val();
         
            $.ajax({
               url: "{{ route('api.admin.score2') }}",
               method: 'POST',
               data: {date,exam},
            }).done(response => {
               if(response.success){
                  this.scores2 = response.result;
                  let exam = Object.keys(response.result);
                  this.score_exam2 =exam[0];
   
                  let data = Object.values(response.result);
                  this.score_data2=Object.values(data[0]);
   
                  this.score_label2=Object.keys(data[0]);
                  
               }
            });
         },
         fetchSopPerformance(){
            const $ = window.$;         
            $.ajax({
               url: "{{ route('api.admin.sop-performance') }}",
               method: 'POST',
               data: {},
            }).done(response => {
               if(response.success){
                  this.sop_performance = response.result;
               }
            });
         }, 
         fetchCallPerformance(){
            const $ = window.$;         
            $.ajax({
               url: "{{ route('api.admin.call-performance') }}",
               method: 'POST',
               data: {},
            }).done(response => {
               if(response.success){
                  this.call_performance = response.result;
               }
            });
         },
         fetchTopState(){
            const $ = window.$;
            const date = $("#top-state-range").daterangepicker().val();
            
         
            $.ajax({
               url: "{{ route('api.admin.top-state') }}",
               method: 'POST',
               data: {date},
            }).done(response => {
               if(response.success){
                  $("#top_state").html(response.result);               
               }
            });
         }
       }
   })
   
</script>
@if(Session::has('success'))
<script>
   successMessage("{{ Session::get('success') }}")
</script>
@endif
@endsection