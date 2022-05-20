@extends('layout')
@section('title','Cat Result')

@section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}"   rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}"   rel="stylesheet" />
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}"   rel="stylesheet" />
@endsection

@section('page_css')

@endsection

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3"   style="justify-content: space-between;">
   <div class="d-flex">
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
               <li class="breadcrumb-item active" aria-current="page">Export Data</li>
            </ol>
         </nav>
      </div>
   </div>

</div>
@endsection

@section('main_content')
<div class="row profile">
   <div class="col">
      <div class="card">
         <div class="card-body position-relative">
            <div class="row">
               <div class="col-11 mx-auto border-2 border-dark d-inline-block h4 mb-4 p-2" style="background: #6b7a99;color: #fff;">
                  Get your CAT Scores, Percentile &amp; Expected Top BSchool Cut-Offs from your Response Sheet link
               </div>
            </div>
            <div class="row">
               <div class="col-lg-11 mx-auto">
                  <p><strong>Steps to get Response Sheet URL:</strong>
                     <br>
                     <br>1. Login to CAT 2021 official website
                     <a href="https://iimcat.ac.in" terget="_blank">https://iimcat.ac.in</a>
                     <br>2. Click on "Candidate Response"
                     <br>3. Copy Link Address<span style="color:red;">*</span>
                     <br>
                  </p>
                  <form method="post" class="" action="{{route('user-cat-result')}}" id="result">
                     @csrf
                     <div class="mb-3 row">
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="url" id="url">
                        </div>
                        <div class="col-md-2">
                           <button type="button" class="btn btn-primary btn-sm" onclick="getresult()">Get Your Score</button>
                        </div>

                     </div>
                  </form>
               </div>
            </div>

         </div>
      </div>
      <div id="refresh_div">
      @if ($result) 
         <div class="card">
            <div class="row m-3">
               <div class="col-md-12 col-sm-12">
                  @foreach ($result->details as $key => $value)
                  <div class="row">
                     <div class="col-md-3 col-sm-6"><div class="h6">{{$key}}:- </div ></div>
                     <div class="col-md-4 col-sm-6" ><div class="h6"><div >{{$value}}</div > </div ></div>
                  </div>
                  @endforeach
                  
                  <div class="row">
                     <div class="col-md-3"><div class="h6">Exam Sheet URL:- </div ></div>
                     <div class="col-md-4"><div class="h6"><div ><a href="{{$url}}"
                        target="_blank" rel="nofollow">Open</a></div > </div ></div>
                  </div>
               </div>
            </div>
         </div>
      
      <div class="card">
         <div class="row my-3">
            @foreach ($result->sections_marks as $s)
               <div class="col-md-4">
                     <div class='bg-primary-2 p-1 text-center'>
                         <h4>Section: {{$s->name}}</h4>
                     </div>
                     <div class='row p-2 m-2'>
                         <div class='col-md-6'>Total Questions</div>
                         <div class='col-md-6'><span>{{$s->total_questions}}</span></div>
                     </div>
                     <div class='row p-2 m-2'>
                         <div class='col-md-6'>Attempt Questions</div>
                         <div class='col-md-6'><span>{{$s->attempt_questions}}</span></div>
                     </div>
                     <div class='row p-2 m-2'>
                         <div class='col-md-6'>Correct Answers</div>
                         <div class='col-md-6'><span>{{$s->correct_answers}}</span></div>
                     </div>
                     <div class='row p-2 m-2'>
                         <div class='col-md-6'>Wrong Answers</div>
                         <div class='col-md-6'><span>{{$s->wrong_answers}}</span></div>
                     </div>
                     <div class='row p-2 m-2'>
                         <div class='col-md-6'>Obtain Marks</div>
                         <div class='col-md-6'><span>{{$s->obtain_marks}} / {{$s->total_marks}}</span></div>
                     </div>
                 </div>
               @endforeach
         </div>
         
      </div>

      <div class="card">
         <div class="row ">
            <div class="col-md-12 text-center my-3">
               <div class="h4 mb-3">Total Marks Obtained</div>
               <div class='marks'><span class="font-50">{{$result->obtain_marks}} </span><span class="font-22">/{{$result->total_marks}}</span></div>
               <div class="h4">You would get {{$result->percentile}}</div>
            </div>
         </div>
      </div>
   </div>
      @endif
      @include('components.partial_college_list')
   </div>
</div>
@endsection

@section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
@endsection

@section('script')
<script>
   function getresult(){
      var result = document.getElementById('result');
      var url = result.action;
      var fd = new FormData(result);
    $.ajax({
        type: "post",
        url,
        data: fd,
        contentType: false,
        processData: false,
        dataType: "json",
        cache:"false",
       
        success:function(response){ 
         console.log(response);
           if(response.success){
              location.reload();
           }else{
            failMessage(response.error)
           }                                             
        }                                              
    });
 }
</script>
@if(Session::has('success'))
<script>
   successMessage("{{ Session::get('success') }}")
</script>

@endif
@endsection