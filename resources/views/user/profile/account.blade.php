@extends('layout')
@section('title','Profile')
@section('css_plugin')
   <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page_css')
   <link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
   <style>
      .select2-container--default .select2-selection--multiple {
         border: 1px solid #aaa !important;
      }
   </style>
@endsection
@section('breadcrumb')
   <div class="page-breadcrumb d-flex align-items-center mb-3" style="justify-content: space-between;">
      <div class="d-flex">
         <div class="breadcrumb-title pe-3">Profile</div><div class="ps-3">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0 p-0">
                  <li class="breadcrumb-item">
                     @if (Auth::user()->role=="student")
                        <a href="{{route('profile.view')}}"><i class="bx bx-home-alt"></i></a>
                     @else
                        <a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                     @endif
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            @if (Auth::user()->role !='teacher' )
            <div class="row text-end mb-2">
               <div class="col-lg-12">
               <button type="button" class="btn btn-dark btn-sm shadow-sm" onclick="editForm(this)">
                  <i class="bx bx-edit m-0"></i> Edit Profile
               </button></div>
            </div>
            @endif
          
            <ul class="nav nav-pills nav-primary {{(Auth::user()->role == 'student') ? 'nav-fill' : ''}}" role="tablist" id="profile_tab">
               <li class="nav-item" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#profile_besic" role="tab" aria-selected="true">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Personal Info</div>
                     </div>
                  </a>
               </li>

               <li class="nav-item" role="presentation">
                  <a class="nav-link " data-bs-toggle="tab" href="#profile_stats" role="tab" aria-selected="false">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-copy-alt font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Education</div>
                     </div>
                  </a>
               </li>

               <li class="nav-item" role="presentation">
                  <a class="nav-link " data-bs-toggle="tab" href="#profile_work" role="tab" aria-selected="false">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-buildings font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Work experience & Internship</div>
                     </div>
                  </a>
               </li>

               <li class="nav-item" role="presentation">
                  <a class="nav-link " data-bs-toggle="tab" href="#profile_curricular" role="tab" aria-selected="false">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-book-reader font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Co-Curricular & Extra Curricular</div>
                     </div>
                  </a>
               </li>

               <li class="nav-item" role="presentation">
                  <a class="nav-link " id="dream_link" data-bs-toggle="tab" href="#profile_dreamcolleges" role="tab" aria-selected="false">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-customize font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Dream colleges</div>
                     </div>
                  </a>
               </li>
               @if (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher')
               <style>
                  #profile_tab li{flex: 1 0 25%;margin-top: 5px;}
               </style>
               <li class="nav-item" role="presentation">
                  <a class="nav-link " id="dream_link"  href="{{route('admin.exams',$user_id)}}" target="_blank">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-customize font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Exams Scores</div>
                     </div>
                  </a>
               </li>

               <li class="nav-item" role="presentation">
                  <a class="nav-link " id="dream_link"  href="{{route('admin.sops',$user_id)}}" target="_blank">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-customize font-18 me-1'></i>
                        </div>
                        <div class="tab-title">SOP/Form Details</div>
                     </div>
                  </a>
               </li>

               <li class="nav-item" role="presentation">
                  <a class="nav-link " id="dream_link"  href="{{route('admin.receivedcall',$user_id)}}" target="_blank">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-customize font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Interviews</div>
                     </div>
                  </a>
               </li>
               @endif
            </ul>

            <div class="px-2 py-3 shadow-sm tab-content">
               <div class="tab-pane fade show active" id="profile_besic" role="tabpanel">
                  <div class="col-lg-10 mx-auto">
                     <div class="col-12">
                        <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">Personal Information</div>
                     </div>
                     <div class="row">
                        <div class="col-lg-auto text-center">
                           <div class="position-relative">
                              <label for="avatar" class="avatar-update">
                              <i class="bx bx-camera"></i>
                              </label>

                              <form action="{{route('profile.update-profile')}}" method="post" enctype="multipart/form-data" class="d-none" id="avatar-form">
                                 <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                                 @csrf
                                 <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                                 <input type="file" class="d-none" name="avatar" id="avatar" onchange="avatarSave()">
                              </form>
                              <div class="avatar-loader">
                                 <div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span>
                                 </div>
                              </div>
                              @empty($user->avatar)
                                 <img src="{{asset('assets/images/avatars/user.png ')}}" alt="" id="previewImg" class="radius-15 border border-4 border-top-0 avatar-img">
                              @else
                                 {{-- <img src="{{route('user-files', $user->avatar)}}"  id="previewImg"  alt="" class="radius-15 border border-4 border-top-0 avatar-img"> --}}
                                 <img src="{{$user->avatar}}"  id="previewImg"  alt="" class="radius-15 border border-4 border-top-0 avatar-img">
                              @endempty
                           </div>
                        </div>
                        <div class="col">
                           <form class="row" id="first-step" action="{{route('profile.update-personalinfo')}}">
                              @csrf
                              <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="apperaring_for" class="form-label">Appearing For</label>
                                    <select name="apperaring_for" id="apperaring_for" class="form-control">
                                       <option value="">-Select-</option>
                                       <option value="CAT 2021" {{Auth::user()->apperaring_for == "CAT 2021" ?'selected':''}}>CAT 2021</option>
                                       <option value="CAT 2022" {{Auth::user()->apperaring_for == "CAT 2022" ?'selected':''}}>CAT 2022</option>
                                       <option value="CAT 2023" {{Auth::user()->apperaring_for == "CAT 2023" ?'selected':''}}>CAT 2023</option>
                                       <option value="CAT 2024" {{Auth::user()->apperaring_for == "CAT 2024" ?'selected':''}}>CAT 2024</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" readonly>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="phone" name="mobile_number" id="phone" class="form-control" value="{{$user->mobile_number}}" readonly>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="w-phone" class="form-label">WhatsApp Phone</label>
                                    <input type="phone" name="whatsapp_number" id="w-phone" class="form-control" value="{{$user->whatsapp_number}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="student" class="form-label">CATKing Student</label>
                                    <select name="is_catking_student" id="student" class="form-select">
                                       <option value="yes" {{$user->is_catking_student == 'yes' ? "selected=selected" :""}}>Yes - Classroom student</option>
                                       <option value="mocks" {{$user->is_catking_student == 'mocks' ? "selected=selected" :""}}>Yes - Mocks student</option>
                                       <option value="gdpi" {{$user->is_catking_student == 'gdpi' ? "selected=selected" :""}}>Yes - GDPI student</option>
                                       <option value="no" {{$user->is_catking_student == 'no' ? "selected=selected" :""}}>No</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" id="dob" class="form-control" value="{{$user->dob}}">
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="mb-3">
                                    <label for="address" class="form-label">City</label>
                                    <input type="text" name="city" id="city" class="form-control" value="{{$user->city}}">
                                    {{-- <select name="city" id="city" class="form-select">
                                       <option value="">-Select-</option>
                                       {{$cities = App\Models\City::all()}}
                                       @foreach ($cities as $city)
                                          <option value="{{$city->id}}" {{$user->city == $city->id ? "selected=selected" :""}}>{{$city->name}}</option>
                                       @endforeach
                                    </select> --}}
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="mb-3">
                                    <label for="address" class="form-label">State</label>
                                    <select name="state" id="state" class="form-select">
                                       <option value="">-Select-</option>
                                       {{$states = App\Models\State::all()}}
                                       @foreach ($states as $state)
                                          <option value="{{$state->id}}" {{$user->state == $state->id ? "selected=selected" :""}}>{{$state->name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{$user->address}}">
                                 </div>
                              </div>
                              <div class="col-12 text-end"  >
                                 <button type="button" onclick=savePersonalInfo() tab-next="profile_stats" class="btn btn-primary" id="first"><i class="bx bx-cloud-upload"></i> Save & Next</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="tab-pane fade " id="profile_stats" role="tabpanel">
                  <div class="col-lg-10 mx-auto">
                     <form id="second-step" action="{{route('profile.update-education')}}">
                        <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                        @csrf
                        <div class="row">
                           <div class="col-12">
                              <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                                 Educational Details
                              </div>
                           </div>

                           {{-- @dd($education_data) --}}

                           @foreach ($user['education'] as $edu_key => $education)
                           @php
                              $board_type = $education->board_type;
                              $school = $education->school;
                              $class_name = $education->class_name;
                              $class_type = $education->class_type;
                              $marks = $education->marks;
                              $cgpa = $education->cgpa;
                              $passing_year = $education->passing_year;
                              $board_name=$education->board_name;
                              $summary=$education->summary;
                              $start_date = $education->start_date;
                              $end_date = $education->end_date;
                              $gap=$education->gap;
                              $month = $education->month;

                              if($class_type == "matric" || $class_type == "secondary"){
                                    $board_name_label = 'Board';
                                    $other_board_name_label = "Board Name";
                                    $school_name_label = 'School';
                              }
                              elseif($class_type == "graduation" || $class_type == "post_graduation"){
                                    $board_name_label = 'Degree';
                                    $other_board_name_label = "Degree name";
                                    $school_name_label = "College";
                              }
                              elseif($class_type == "diploma" || $class_type == "other"){
                                    $board_name_label = 'Course';
                                    $other_board_name_label = "Degree name";
                                    $school_name_label = "Institute";
                              }
                           @endphp 
                           {{-- @dump($class_type) --}}
                           {{-- @continue --}}

                           <div class="col-12 education_div"  id="edu_row_{{$edu_key}}">
                              <input type="hidden" value="{{$class_type}}" name="educations[{{$edu_key}}][class_type]">
                              <input type="hidden" value="{{App\Models\User::STUDY_CLASSES[$class_type]}}" name="educations[{{$edu_key}}][class_name]">
                              <div class="row align-items-center ">
                                 <div class="col-12 col-md mb-3 mt-4 d-flex">
                                    <div class="col me-2 bg-primary-4 font-20 h5  p-2  mb-0">{{App\Models\User::STUDY_CLASSES[$class_type]}}</div>
                                    @if($class_type != 'matric' && $class_type != 'secondary' && $class_type != 'graduation')
                                       <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button" onclick="remove_row('#edu_row_{{$edu_key}}')"><i class="bx bx-trash m-0"></i></button>
                                    @endif
                                 </div>
                                 <div class="col-12">
                                    <div class="row">
                                       <div class="col">
                                          <div class="mb-3">
                                             <input type="hidden" id="other-input" value="{{route('profile.add-otherinput')}}">
                                             <label class="form-label">{{$board_name_label}}</label>
                                             @if (in_array($class_type, ['matric', 'secondary', 'graduation', 'post_graduation', 'other']))
                                                <select class="form-control" name="educations[{{$edu_key}}][board_type]" id="class" onchange="addOtherInput('#other_input_{{$edu_key}}', {{$edu_key}}, this, '{{ $other_board_name_label }}')">
                                                   <option value="">-Select-</option>
                                                   @foreach ($education_board_type[$class_type] as $board_key =>$b_type)
                                                      <option value="{{$board_key}}" {{$board_type == $board_key ? "selected=selected" : ""}}>{{$b_type}}</option>
                                                   @endforeach
                                                </select>
                                                <div id="other_input_{{$edu_key}}" @if ($board_type == 'other') class="mt-2" @endif>
                                                   @if ($board_type == 'other')
                                                      <div class="mb-3 mt-2">
                                                         <label class="form-label">{{ $other_board_name_label }}</label>
                                                         <input type="text" name="educations[{{$edu_key}}][board_name]" id="board_name" class="form-control" value="{{$board_name}}">
                                                      </div>
                                                   @endif
                                                </div>
                                             @else
                                                <input type="text" name="educations[{{$edu_key}}][board_name]" id="board_name" class="form-control" value="{{$board_name}}">
                                             @endif
                                          </div>
                                       </div>
                                       @if ($class_type == 'other')
                                          <div class="col-md-4">
                                             <div class="mb-3">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" name="educations[{{$edu_key}}][start_date]" id="start_date" class="form-control" value="{{$start_date}}">
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="mb-3">
                                                <label class="form-label">End Date</label>
                                                <input type="date" name="educations[{{$edu_key}}][end_date]" id="completion_date" class="form-control" value="{{$end_date}}">
                                             </div>
                                          </div>
                                       @else
                                          <div class="col">
                                             <div class="mb-3">
                                                <label class="form-label">{{$school_name_label}}</label>
                                                <input type="text" name="educations[{{$edu_key}}][school]" id="school" class="form-control" value="{{$school}}">
                                             </div>
                                          </div>
                                          <div class="col">
                                             <div class="mb-3">
                                                <label class="form-label">Marks(%)</label>
                                                <input type="text" name="educations[{{$edu_key}}][marks]" id="marks" class="form-control marks" value="{{$marks}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                             </div>
                                          </div>
                                          <div class="col">
                                             <div class="mb-3">
                                                <label class="form-label">CGPA</label>
                                                <input type="text" name="educations[{{$edu_key}}][cgpa]" id="cpga" class="form-control" value="{{$cgpa}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                             </div>
                                          </div>
                                          <div class="col">
                                             <div class="mb-3">
                                                <label class="form-label">Passing Year</label>
                                                <input type="number" min="1900" max="2022" step="1" name="educations[{{$edu_key}}][passing_year]" id="completion_date" class="form-control" value="{{$passing_year}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                                             </div>
                                          </div>
                                       @endif
                                    </div>
                                    @if($class_type == 'other')
                                    <div class="row">
                                      <div class="mb-3">
                                         <label class="form-label">Summary</label>
                                         <input type="text" name="educations[{{$edu_key}}][summary]" id="class" class="form-control" value="{{$summary}}">
                                      </div>
                                    </div>
                                    @endif
                                 </div>
                              </div>
                              @if($class_type == 'graduation')
                                 <div class="col-8">
                                    <div class="row mb-3">
                                       <div class="col-6">
                                          <label class="form-label">Do you have a gap year during/after graduation?</label>
                                          <select name="gap" id="educations" onchange="educationGap('#no_of_month')" data-set="cat" class="form-select">
                                             <option value="no" {{($gap == 'no') ? "selected":""}}>No</option>
                                             <option value="yes" {{($gap == 'yes') ? "selected":""}} >Yes</option>
                                          </select>
                                       </div>
                                       <div class="col-4 {{($gap == 'yes')? "":"d-none"}}" id="no_of_month" >
                                          <label class="form-label">Number of Months</label>
                                          <input type="number" name="month" class="form-control" value="{{$month}}">
                                       </div>
                                    </div>
                                 </div>
                              @endif
                           </div>
                           @endforeach

                           <input type="hidden" value="{{$edu_key}}" id="education_relation">
                           <div id="edu_append"></div>
                        </div>
                        <div class="row">
                           <div class="col-12 d-flex justify-content-between">
                              <button type="button" class="btn btn-dark" onclick="openModel('#edu-model')"><i class="bx bx-add-to-queue"></i>Add More</button>
                              <button id="edu" type="button" onclick="saveEducation()" tab-next="profile_work" class="btn btn-primary"><i class="bx bx-cloud-upload"></i> Save & Next</button>
                           </div>
                        </div>
                     </form>
                     <!-- Modal -->
                     <div class="modal fade" id="edu-model" tabindex="-1" aria-labelledby="edu-model" aria-hidden="true">
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
                                 <input type="hidden" value="{{route('profile.add-education')}}" id="add-education">
                                    <select name="" id="edu-select" class="multiple-select form-control"  multiple="multiple">
                                       <option value="post_graduation">Post Graduation</option>
                                       <option value="diploma">Diploma</option>
                                       <option value="other">Other Certifications</option>
                                    </select>
                                    <button class="btn-primary btn mt-3" type="button" onclick="addEducation()" data-bs-dismiss="modal" aria-label="Close">Add</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="tab-pane fade " id="profile_work" role="tabpanel">
                  <div class="col-lg-10 mx-auto">
                     <div class="row">
                        <div class="col-12">
                           <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                              Work experience & Internship
                           </div>
                        </div>
                        <div class="col-12">
                           <form class="row" id="third-step" action="{{route('profile.update-workexaperience')}}">
                              <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                              @csrf
                              @foreach ($user['work'] as $work_key => $dwork)
                                 @php
                                    $company_name = $dwork->company_name;
                                    $role = $dwork->role;
                                    $join_date = $dwork->join_date;
                                    $leave_date = $dwork->leave_date;
                                    $work_type = $dwork->work_type;
                                    $responsibilities = $dwork->responsibilities;
                                    $working_presently = $dwork->working_presently;
                                    $summary = $dwork->summary;
                                 @endphp

                              <div class="card work_div" id="work_row_{{$work_key}}">
                                 <div class="card-body">
                                    @if ($work_key > 0)
                                    <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button" onclick="removeWork('#work_row_{{$work_key}}')"><i class="bx bx-trash m-0"></i></button>
                                    @endif
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="mb-3">
                                             <label class="form-label">Employment Type</label>
                                             <select name="works[{{$work_key}}][work_type]" id="" class="form-select">
                                                <option value="full_time" {{$work_type == 'full_time' ? "selected=selected":""}}>Full Time</option>
                                                <option value="part_time" {{$work_type == 'part_time' ? "selected=selected":""}}>Part Time</option>
                                                <option value="internship" {{$work_type == 'internship' ? "selected=selected":""}}>Internship</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="mb-3">
                                             <label class="form-label">Company Name</label>
                                             <input type="text" name="works[{{$work_key}}][company_name]" value="{{$company_name}}" id="company_name" class="form-control">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="mb-3">
                                             <label class="form-label">Designation</label>
                                             <input type="text" name="works[{{$work_key}}][role]" id="role" value="{{$role}}" class="form-control">
                                          </div>
                                          <div class="mb-3">
                                             <label for="responsibilities" class="form-label">Responsibilities</label>
                                             <input type="text" name="works[{{$work_key}}][responsibilities]" id="responsibilities" class="form-control" value="{{$responsibilities}}">
                                          </div>
                                       </div>
                                       @php
                                       if($working_presently == 'yes'){
                                          $checked= "checked";
                                          $display="d-none";
                                       }
                                       else{
                                          $checked= "";
                                          $display="";
                                       }
                                       @endphp
                                       <div class="col-md-6">
                                          <div class="mb-3">
                                             <label class="form-label">Start Date</label>
                                             <input type="date" name="works[{{$work_key}}][join_date]" id="" class="form-control" value="{{$join_date}}" >
                                          </div>
                                          <div class="mb-3">
                                             <label class="form-label">End Date</label>
                                             <div class="row align-items-center">
                                                <div class="col-12 col-md-auto">
                                                   <div class="form-check form-switch">
                                                      <input class="form-check-input" type="checkbox" role="switch" id="work_present{{$work_key}}" name="works[{{$work_key}}][working_presently]" value="yes" {{$checked}} onclick="leaveDate('#join_end_{{$work_key}}')">
                                                      <label class="form-check-label" for="work_present{{$work_key}}">Working Presently ?</label>
                                                   </div>
                                                </div>
                                                <div class="col-12 col-md">
                                                   <input type="date" name="works[{{$work_key}}][leave_date]" id="join_end_{{$work_key}}" class="form-control {{$display}}" value="{{$leave_date}}">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                              <div id="work_append"></div>
                           </form>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                           <input type="hidden" value="{{route('profile.add-work')}}" id="add-work">
                           <button type="button" class="btn btn-dark"  onclick="addWork()"><i class="bx bx-add-to-queue"></i>Add More</button>
                           <button id="work" tab-next="profile_curricular" class="btn btn-primary" type="button" onclick="saveWorkExperience()"><i class="bx bx-cloud-upload"></i> Save & Next</button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="profile_curricular" role="tabpanel">
                  <div class="col-lg-10 mx-auto">
                     <div class="row">
                        <div class="col-12">
                           <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2">
                              Co-Curricular & Extra Curricular
                           </div>
                        </div>
                     </div>
                  
                     <div class="row">
                       <form id="curricular-form" action="{{route('profile.update-curricular')}}">
                        <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                           @csrf

                           @foreach ($curricular_data as $crel => $curricular_rows)
                           @php
                                 $count=0;
                           @endphp
                              <div class="col-12">
                                 <div class="row align-items-center g-2 ">
                                    <div class="col-12 d-flex col-md mb-4" >
                                       <div class="col me-2 bg-primary-4 font-20 h5  p-2  mb-0" >{{@App\Models\UserMeta::CURRICULAR[$crel]}}</div>
                                          <input type="hidden" id="add-curricular" value="{{route('profile.add-curricular')}}">
                                          <button type="button" onclick="AddCurricular('{{$crel}}')" class="btn-primary btn">Add</button>
                                    </div>
                                 </div>
                                 @forelse ($curricular_rows?:[] as $cur)

                                    <div class="row mb-3 curricular_co_div" id="co_div_{{$count}}">
                                       <div class="col-md-11">
                                          <input type="text"  name="curricular[{{$crel}}][]" value="{{$cur->value}}" class="form-control">
                                       </div>
                                       @if ($count > 0)
                                          <div class="col-md-1">
                                             <button class=" btn btn-danger btn-sm" type="button"onclick="removeExam('#co_div_{{$count}}')"><i class="bx bx-trash m-0"></i></button>
                                          </div>
                                      @endif
                                    </div>
                                    @php
                                       $count++;
                                    @endphp
                                 @empty
                                    <div class="row mb-3 curricular_co_div">
                                       <div class="col-md-11">
                                          <input type="text"  name="curricular[{{$crel}}][]" value="" class="form-control">
                                       </div>
                                    </div>

                                 @endforelse
                                 <div class="curricular_append_{{$crel}}"></div>
                              </div>
                           @endforeach

                        </form>
                     </div>
                     <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                           <button id="work" tab-next="profile_curricular" class="btn btn-primary" type="button" onclick="saveCurricular()"><i class="bx bx-cloud-upload"></i> Save & Next</button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="profile_dreamcolleges" role="tabpanel">
                  <div class="col-lg-10 mx-auto">
                     <div class="row">
                        <div class="col-12">
                           <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2">
                              Dream Colleges
                           </div>
                        </div>
                     </div>
                 
                     <div class="row">
                        <form id="dream-college-form" action="{{route('profile.update-dreamcollege')}}">
                           <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                           @csrf
                           <div class="col-12">
                              <div class="row align-items-center mb-2">
                                 <div class="col-12">
                                    <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Dream colleges</div>
                                    <div class="form-check">
                                       <input class="form-check-input" type="checkbox" value="1" name="work_hard" id="work_hard" {{(Auth::user()->work_hard == 1) ? 'checked':''}} onchange="updateWorkHardStatus(this,'{{route('profile.update-work-hard')}}')">
                                       <label class="form-check-label" for="work_hard" >
                                          I will work very hard to convert my dream colleges
                                       </label>
                                     </div>
                                     
                                 </div><div class="col-12">
                                    @php
                                       $user_college_ids = collect($user['dream_colleges'] ?? [])->pluck('college_id')->toArray();
                                    @endphp
                                    <select name="dream_colleges[]" id="dreamCo" class="multiple-select form-control" multiple="multiple">
                                       @foreach ($colleges as $college)
                                          @continue(in_array($college->id, $user_college_ids))
                                          <option value="{{$college->id}}">{{$college->name}}</option>
                                       @endforeach
                                       @foreach ($user['dream_colleges'] as $item)
                                          <option value="{{$item->college_id}}" selected>{{$item->college_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="row mt-3">
                        <div class="col-12 text-end">
                           <button id="dreamCollege" type="button"  onclick="saveDreamCollege()" tab-next="profile_stats" class="btn btn-primary"><i class="bx bx-cloud-upload" ></i> Save & Finish</button>
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
   <script src="{{asset('assets/js/account.js')}}"></script>
   <script>
      function updateWorkHardStatus(elem,url){
          let sts;
          if(elem.checked){
             sts = 1;
          }else{
             sts = 0;
          }
          $.ajax({
             type: "get",
             url,
             data: {sts},
             
             success:function(response){
                   // successMessage(response.message);
             },
             error:function(response){
             }
          });
       }
  </script>
@endsection
