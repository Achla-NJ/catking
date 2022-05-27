@extends('layout')
@section('title','Exams Scores')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('page_css')

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
                <li class="breadcrumb-item active" aria-current="page">Exam Scores</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('main_content')
<div class="row profile">
   <div class="col">
      <div class="card">
         <div class="card-body position-relative">
            <div class="col-lg-10 mx-auto">
               <div class="row">
                  <div class="col-12">
                     <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2">
                        Exams Details
                     </div>
                  </div>
               </div>
               
               <div class="row">
                  <form   id="exam-form"  action="{{route('profile.update-exam')}}" enctype="multipart/form-data">
                     <input type="hidden" id="score_card_url"  value="{{route('profile.scorecard')}}">
                     @csrf
                     <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                     @foreach ($user['exams'] ?? [] as $exam_key => $exam)
                        @php
                           $exam_type = $exam->type;
                           $took_exam = $exam->took_exam;
                           $name = $exam->name;
                           $class_name = $exam->class_name;
                           $score = $exam->score;
                           $percentile = $exam->percentile;
                           $score_card = $exam->score_card_file;
                        @endphp
                         <div class="col-12 exam_div" id="exam_row_{{$exam_key}}">
                           <div class="row align-items-center g-2">
                              <div class="col-12 d-flex col-md mb-4" >
                                 @php
                                   $exm_name = $exam_type == 'other'?'Other Exams': strtoupper($exam_type);
                                 @endphp
                                 <div class="col me-2 bg-primary-4 font-20 h5  p-2  mb-0" >{{$exm_name}} Result</div>
                                   
                                    <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button"onclick="removeExam('#exam_row_{{$exam_key}}','{{ucfirst($exam_type)}}','{{$exam_type}}')"><i class="bx bx-trash m-0"></i></button>
                                   
                              </div>
                              <div class="col-12" >
                                 <div class="row gx-2">
                                    <div class="col-md-2 disp">
                                       <div class="mb-3">
                                          @if ($exam_type == 'other')
                                             <label for="" class="form-label">Exam Name</label>
                                             <input type="hidden" value="other" name="exam[{{$exam_key}}][exam_type]">
                                             <input type="text"  name="exam[{{$exam_key}}][name]" value="{{$name}}" data-set="{{$exam_type}}" class="form-control"  >
                                          @else
                                          <label for="" class="form-label">Took {{$exm_name}}</label>
                                          <input type="hidden" value="{{$exam_type}}" name="exam[{{$exam_key}}][exam_type]">
                                          <select name="exam[{{$exam_key}}][took_exam]" id="exam_opt_{{$exam_key}}" data-set="cat_{{$exam_key}}" class="form-select">
                                          <option value="no" {{$took_exam == 'no'?"selected=selected":""}}>No</option>
                                          <option value="yes" {{$took_exam == 'yes'?"selected=selected":""}}>Yes</option>
                                          </select>
                                          @endif
                                       </div>
                                    </div>

                                    @php
                                       if($took_exam == 'yes' || $exam_type == 'other'){
                                          $display = '';
                                       }else{
                                          $display="d-none";
                                       }
                                    @endphp
                                    <div class="col-md-2 cat_{{$exam_key}} {{$display}} disp">
                                       <div class="mb-3">
                                          <label for="" class="form-label">Scores</label>
                                          <input type="text" name="exam[{{$exam_key}}][score]" id="score" class="form-control"value="{{$score}}">
                                       </div>
                                    </div>
                                    <div class="col-md-2 col-lg-auto cat_{{$exam_key}} {{$display}} disp">
                                       <div class="mb-3">
                                          <label for="" class="form-label">Percentile (if available)</label>
                                          <input type="text" name="exam[{{$exam_key}}][percentile]" id="percentile" class="form-control percentile" value="{{$percentile}}">
                                       </div>
                                    </div>
                                    <div class="col-md-3  col-lg cat_{{$exam_key}} {{$display}} disp">
                                       <div class="mb-3">
                                          <label for="" class="form-label">Score Card</label>
                                          <input type="file"  id="score_card_file" class="form-control" onchange="getScorefile(this,'#card_file_{{$exam_key}}')">
                                          <input type="hidden" id="card_file_{{$exam_key}}" name="exam[{{$exam_key}}][score_card]" value="{{$score_card}}">
                                       </div>
                                    </div>
                                       @if(!empty($score_card))
                                       <div class="col-md-2 col-lg-auto cat_{{$exam_key}} {{$display}} my-auto">
                                          <a href="{{route('user-files', $score_card)}}" class="btn btn-warning btn-sm" target="_blank" >View</a>
                                       </div>
                                       @endif


                                 </div>
                              </div>
                           </div>
                        </div>
                        <script>
                           $('#exam_opt_{{$exam_key}}').on('change',function(){
                               let colSet = $(this).attr('data-set');
                               let col = $(`.disp.${colSet}`);
                               let inputs = $(`.disp.${colSet} .form-control`);
                               col.hasClass('d-none') ? col.removeClass('d-none') : col.addClass('d-none').find('.form-control').val('');
                            });
                           </script>
                        @endforeach
                        <div id="exam_append"></div>
                  </form>
                  @if (Auth::user()->role !='teacher' )
                     <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                           <button class="btn btn-dark" onclick="openModel('#edu-scores')" ><i class="bx bx-add-to-queue"></i>Add More</button>
                           <button id="exams" type="button" onclick="saveExam()" tab-next="profile_sop" class="btn btn-primary"><i class="bx bx-cloud-upload"></i> Save</button>
                        </div>
                     </div>
                  @endif
                      <!-- Modal -->
                      <div class="modal fade" id="edu-scores" tabindex="-1" aria-labelledby="edu-scores" aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                               <div class="modal-loader">
                                  <div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span>
                                  </div>
                               </div>
                               <div class="modal-header">
                                  <h5 class="modal-title" id="edu-model">Please Select</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                               </div>
                               <div class="modal-body">
                                  <select name="" id="edu-exam-select" class="multiple-select form-control"  multiple="multiple">
                                     {{-- {{$exams = \App\Models\Exam::all() }}
                                     @foreach ($exams as $exam)
                                       <option value="{{$exam->slug}}">{{$exam->name}}</option>
                                     @endforeach --}}

                                     @php
                                       $user_exams_ids = collect($user['exams'] ?? [])->pluck('type')->toArray();
                                       $exams = \App\Models\Exam::where('status','active')->get();
                                       @endphp
                                       @foreach ($exams as $key => $item)
                                          @if(!in_array($item->name, $user_exams_ids))
                                             <option value="{{$item->name}}">{{$item->name}}</option>
                                          @endif	
                                       @endforeach

 
                                     <option value="other">Other</option>
                                  </select>
                                  <input type="hidden" value="{{route('profile.add-exam')}}" id="add-exam">
                                  <button class="btn-primary btn mt-3" onclick="addExam()"  data-bs-dismiss="modal" aria-label="Close">Add</button>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>

               <div class="form-loader">
                  <button class="btn btn-primary" type="button" disabled>
                     <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Please Wait...
                  </button>
                  <div class="bg-warning mt-4 p-1 text-capitalize">Don’t close window or refresh </div>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection

@section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endsection

@section('script')
<script src="{{asset('assets/js/exams.js')}}"></script>
@endsection
