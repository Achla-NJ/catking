@extends('layout')
@section('title','Profile')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('page_css')
    <link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
@endsection

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Profile</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">   @if (Auth::user()->role=="student")
                    <a href="{{route('profile.view')}}"><i class="bx bx-home-alt"></i></a>
                 @else
                    <a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                 @endif
                </li>
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
        </nav>
    </div>

</div>
@endsection
@section('main_content')
{{-- @foreach ($user as $item) --}}

<div class="row profile">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="col-12 text-end mb-2">
                    <a href="{{route('profile.account')}}" class="btn btn-dark btn-sm shadow-sm">
                        <i class="bx bx-edit m-0"></i> Edit Profile
                    </a>
                </div>
                <ul class="nav nav-pills nav-fill nav-primary" role="tablist">
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
                        <a class="nav-link" data-bs-toggle="tab" href="#profile_stats" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-copy-alt font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Education</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile_work" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-buildings font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Work Experience</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" href="#profile_curricular" role="tab" aria-selected="false">
                           <div class="d-flex align-items-center">
                              <div class="tab-icon"><i class='bx bx-book-reader font-18 me-1'></i>
                              </div>
                              <div class="tab-title">Co-curricular & Extra-curricular</div>
                           </div>
                        </a>
                     </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile_exams" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-book-reader font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Exams Scores</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile_sop" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-envelope font-18 me-1'></i>
                                </div>
                                <div class="tab-title">SOPs & Forms</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="dream_link" data-bs-toggle="tab" href="#profile_dreamcolleges" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-customize font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Dream colleges & Call Details</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="px-2 pt-4 pb-3 shadow-sm tab-content">
                    <div class="tab-pane fade show active" id="profile_besic" role="tabpanel">

                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-12">
                                    <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">Personal Information</div>
                                </div>
                                <div class="col-lg-auto text-center">
                                    <div class="position-relative">
                                        @empty($user->avatar)
                                            <img src="{{asset('assets/images/avatars/user.png ')}}" alt="" id="previewImg" class="radius-15 border border-4 border-top-0 avatar-img">
                                        @else
                                            <img src="{{route('user-files', $user->avatar)}}"  id="previewImg"  alt="" class="radius-15 border border-4 border-top-0 avatar-img">
                                        @endempty
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card shadow-none">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Full Name</label>
                                                        <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" disabled>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="email" class="form-label">Email Address</label>
                                                         <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" disabled readonly>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="phone" class="form-label">Phone</label>
                                                        <input type="phone" name="mobile_number" id="phone" class="form-control" value="{{$user->mobile_number}}" disabled readonly>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                         <label for="w-phone" class="form-label">WhatsApp Phone</label>
                                                         <input type="phone" name="whatsapp_number" id="w-phone" class="form-control" value="{{$user->whatsapp_number}}" disabled>
                                                     </div>
                                                 </div>


                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">CATKing Student</label>
                                                        <input type="text" name="is_catking_student" id="is_catking_student" class="form-control" value="{{$user->is_catking_student}}" disabled>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Date of Birth</label>
                                                        <input type="date" name="dob" id="dob" class="form-control" value="{{$user->dob}}" disabled>
                                                    </div>
                                                 </div>
                                                 <div class="col-12">
                                                     <div class="mb-3">
                                                         <label for="address" class="form-label">Address</label>
                                                         <input type="text" name="address" id="address" class="form-control" value="{{$user->address}}">
                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile_stats" role="tabpanel">

                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-6">
                                   <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                                      Educational Details
                                   </div>
                                </div>
                                <div class="col-6">
                                   <div class="row mb-3">
                                      <div class="col-6">
                                         @php
                                            $gap ='no'; $month="";
                                         @endphp
                                         <label for="" class="form-label">Do you have a gap year during/after graduation?</label>
                                         @foreach ($education_gap as $edu_gap)
                                            @php
                                               $gap = @collect($edu_gap)->where('key', 'gap')->first()->{'value'};
                                               $month = @collect($edu_gap)->where('key', 'month')->first()->{'value'};
                                            @endphp
                                         @endforeach
                                         <select name="education_gap[1][gap]" id="education_gap" disabled onchange="educationGap('#no_of_month')" data-set="cat" class="form-select">
                                            <option value="no" {{($gap == 'no') ? "selected":""}}>No</option>
                                            <option value="yes" {{($gap == 'yes') ? "selected":""}} >Yes</option>
                                         </select>
                                      </div>
                                      <div class="col-6 {{($gap == 'no')? "d-none":""}}" id="no_of_month" >
                                         <label for="" class="form-label">Number of Months</label>
                                         <input type="number" disabled name="education_gap[1][month]" class="form-control" value="{{$month}}">
                                      </div>
                                   </div>
                                </div>
                                @foreach ($education_data as $edu_key => $deducation)
                                @php
                                   $board = @collect($deducation)->where('key', 'board')->first()->{'value'};
                                   $school = @collect($deducation)->where('key', 'school')->first()->{'value'};
                                   $class_name = @collect($deducation)->where('key', 'class_name')->first()->{'value'};
                                   $class_type = @collect($deducation)->where('key','class_type')->first()->{'value'};
                                   $marks = @collect($deducation)->where('key','marks')->first()->{'value'};
                                   $cgpa = @collect($deducation)->where('key','cgpa')->first()->{'value'};
                                   $passing_year = @collect($deducation)->where('key','passing_year')->first()->{'value'};
                                   $board_name=@collect($deducation)->where('key','board_name')->first()->{'value'};
                                   $start_date=@collect($deducation)->where('key','start_date')->first()->{'value'};
                                @endphp
                                  <div class="col-12 education_div "  id="edu_row_{{$edu_key}}">
                                   <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                      <div class="col-12 col-md mb-4 d-flex">
                                         <div class="col me-2 bg-primary-4 font-20 h5  p-2  mb-0">{{App\Models\User::STUDY_CLASSES[$class_type]}}</div>
                                      </div>

                                      <div class="col-12">
                                         <div class="row">
                                            <div class="col ">
                                               <div class="mb-3">

                                                  <label for="" class="form-label">Board</label>
                                                  <select class="form-control"  disabled name="educations[{{$edu_key}}][board]" id="class" onchange="addOtherInput('#other_input_{{$edu_key}}',{{$edu_key}},this)">
                                                     <option value="">-Select-</option>
                                                     @foreach ($education_board_type[$class_type] as $board_key =>$board_type)
                                                     <option value="{{$board_key}}" {{$board == $board_key ? "selected=selected" : ""}}>{{$board_type}}</option>
                                                     @endforeach
                                                  </select>
                                               </div>
                                            </div>
                                            @if ($class_type == 'other')
                                               <div class="col-md-4">
                                                  <div class="mb-3">
                                                     <label for="" class="form-label">Start Year</label>
                                                     <input type="date" name="educations[{{$edu_key}}][start_date]" id="start_date" class="form-control" disabled  value={{$start_date}}>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="mb-3">
                                                     <label for="" class="form-label">End Year</label>
                                                     <input type="date" name="educations[{{$edu_key}}][passing_year]" id="completion_date" class="form-control" disabled  value={{$passing_year}}>
                                                  </div>
                                               </div>
                                            @else
                                            <div class="col">
                                               <div class="mb-3">
                                                  <label for="" class="form-label">School</label>
                                                  <input type="text" name="educations[{{$edu_key}}][school]" id="school" class="form-control" disabled  value="{{$school}}">
                                               </div>
                                            </div>
                                            <div class="col">
                                               <div class="mb-3">
                                                  <label for="" class="form-label">Marks(%)</label>
                                                  <input type="text" name="educations[{{$edu_key}}][marks]" id="marks" class="form-control" value="{{$marks}}"  disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                               </div>
                                            </div>
                                           <div class="col">
                                               <div class="mb-3">
                                                  <label for="" class="form-label">CGPA</label>
                                                  <input type="text" name="educations[{{$edu_key}}][cgpa]" id="cpga" class="form-control" value="{{$cgpa}}"  disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                               </div>
                                            </div>
                                            <div class="col">
                                               <div class="mb-3">
                                                  <label for="" class="form-label">Passing Year</label>
                                                  <input type="number" min="1900" max="2022" step="1" name="educations[{{$edu_key}}][passing_year]" id="completion_date" class="form-control" value="{{$passing_year}}"  disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                                               </div>
                                            </div>
                                         @endif
                                         </div>
                                         <div class="row" id="other_input_{{$edu_key}}">
                                            @if ($board == 'other')
                                               <div class="mb-3">
                                                  <label for="" class="form-label">Other</label>
                                                  <input type="text" name="educations[{{$edu_key}}][board_name]" id="class" disabled  class="form-control" value={{$board_name}}>
                                               </div>
                                            @endif
                                         </div>
                                      </div>
                                   </div>
                                </div>
                                @endforeach

                             </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Other Details</div>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" disabled style="min-height: 100px;">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id laboriosam rem voluptate adipisci cumque! Cumque ex ipsum fuga neque harum, praesentium cupiditate magnam exercitationem tenetur at libero, temporibus similique incidunt ullam. Nostrum alias a adipisci voluptatem iusto. Sed cupiditate repellendus asperiores quas voluptate vitae praesentium sunt magni esse enim nobis distinctio similique labore tempore porro expedita excepturi aut assumenda voluptatem, ea reprehenderit. Aperiam eveniet voluptatem qui, excepturi rerum accusantium facere similique doloribus autem adipisci tenetur harum beatae nobis odio dicta, exercitationem modi fugiat natus? Eius, inventore ea qui facere voluptatum eum earum cupiditate suscipit maxime delectus reprehenderit laborum molestiae atque modi magnam id recusandae sit perferendis a. Distinctio, deleniti earum enim rem facilis explicabo consequatur ea blanditiis debitis cum atque! Necessitatibus, repellat excepturi? Iusto, cumque consectetur? Ullam modi nihil voluptate ea ab necessitatibus facilis odit voluptatem nam, fugiat veritatis dolore quidem quasi repellendus sequi harum excepturi, quam quia sint voluptates?
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile_work" role="tabpanel">

                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-12">
                                    <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                                        Work experience & Internship
                                    </div>
                                </div>
                                <div class="col-12">
                                    @foreach ($work_data as $work_key => $dwork)
                                    @php
                                        $work_for = @collect($dwork)->where('key', 'work_for')->first()->{'value'};
                                        $company_name = @collect($dwork)->where('key', 'company_name')->first()->{'value'};
                                        $designation = @collect($dwork)->where('key', 'designation')->first()->{'value'};
                                        $start_date = @collect($dwork)->where('key','start_date')->first()->{'value'};
                                        $end_date = @collect($dwork)->where('key','end_date')->first()->{'value'};
                                        $responsibilities = @collect($dwork)->where('key','responsibilities')->first()->{'value'};
                                        $working_presently = @collect($dwork)->where('key','working_presently')->first()->{'value'};
                                    @endphp
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">{{$company_name}}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="h6 ">Started On</div>
                                            <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{$start_date}}</p>
                                        </div>
                                        @if ($working_presently == 'on')
                                            <div class="col-md-4">
                                                <div class="h6 ">Working Presently</div>
                                                <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">Working</p>
                                            </div>
                                        @else
                                            <div class="col-md-4">
                                                <div class="h6 ">Ended On</div>
                                                <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{$end_date}}</p>
                                            </div>
                                        @endif


                                        <div class="col-md-4">
                                            <div class="h6 ">Worked For</div>
                                            <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{str_replace('_',' ',$work_for)}}</p>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="h6 ">Role</div>
                                            <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{$designation}}</p>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="h6 ">Responsibilities</div>
                                            <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{$responsibilities}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Other Details</div>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" disabled style="min-height: 100px;">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id laboriosam rem voluptate adipisci cumque! Cumque ex ipsum fuga neque harum, praesentium cupiditate magnam exercitationem tenetur at libero, temporibus similique incidunt ullam. Nostrum alias a adipisci voluptatem iusto. Sed cupiditate repellendus asperiores quas voluptate vitae praesentium sunt magni esse enim nobis distinctio similique labore tempore porro expedita excepturi aut assumenda voluptatem, ea reprehenderit. Aperiam eveniet voluptatem qui, excepturi rerum accusantium facere similique doloribus autem adipisci tenetur harum beatae nobis odio dicta, exercitationem modi fugiat natus? Eius, inventore ea qui facere voluptatum eum earum cupiditate suscipit maxime delectus reprehenderit laborum molestiae atque modi magnam id recusandae sit perferendis a. Distinctio, deleniti earum enim rem facilis explicabo consequatur ea blanditiis debitis cum atque! Necessitatibus, repellat excepturi? Iusto, cumque consectetur? Ullam modi nihil voluptate ea ab necessitatibus facilis odit voluptatem nam, fugiat veritatis dolore quidem quasi repellendus sequi harum excepturi, quam quia sint voluptates?
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="profile_curricular" role="tabpanel">
                        <div class="col-12">
                           <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 pe-5">
                              Co-curricular & Extra-curricular
                           </div>
                        </div>
                        <div class="col-lg-10 mx-auto">
                           <div class="row">
                             <form id="curricular-form">
                                 @csrf

                                 @foreach ($curricular_data as $crel => $curricular_rows)
                                 @php
                                       $count=0;
                                 @endphp
                                    <div class="col-12">
                                       <div class="row align-items-center g-2 ">
                                          <div class="col-12 d-flex col-md mb-4" >
                                             <div class="col me-2 bg-primary-4 font-20 h5  p-2  mb-0" >{{@App\Models\UserMeta::CURRICULAR[$crel]}}</div>
                                            </div>
                                       </div>
                                        @forelse ($curricular_rows?:[] as $cur)
                                            <div class="row mb-3 curricular_co_div" id="co_div_{{$count}}">
                                                <div class="col-md-12">
                                                    <input type="text"  name="curricular[{{$crel}}][]" value="{{$cur->value}}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            @php
                                                $count++;
                                            @endphp
                                        @empty
                                            <div class="row mb-3 curricular_co_div">
                                                <div class="col-md-12">
                                                    <input type="text"  name="curricular[{{$crel}}][]" value="" class="form-control" readonly>
                                                </div>
                                            </div>
                                        @endforelse
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
                    <div class="tab-pane fade" id="profile_exams" role="tabpanel">

                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-12">
                                    <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                                        Exams Details
                                    </div>
                                </div>
                                <div class="col-12">
                                    @foreach ($exam_data as $exam_key => $exam)
                                    @php
                                        $exam_type = @collect($exam)->where('key', 'exam_type')->first()->{'value'};
                                        $took_exam = @collect($exam)->where('key', 'took_exam')->first()->{'value'};
                                        $class_name = @collect($exam)->where('key', 'class_name')->first()->{'value'};
                                        $score = @collect($exam)->where('key','score')->first()->{'value'};
                                        $percentile = @collect($exam)->where('key','percentile')->first()->{'value'};
                                        $score_card = @collect($exam)->where('key','score_card')->first()->{'value'};

                                        if ($exam_type == 'other'){
                                            $exm_name = ucfirst($exam_type);
                                        }else{
                                            $exm_name =strtoupper($exam_type);
                                        }

                                        if($took_exam == 'yes' || $exam_type == 'other'){
                                            $display = '';
                                        }else{
                                            $display="d-none";
                                        }
                                    @endphp
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">{{$exm_name}} Details</div>
                                        </div>
                                        <div class="col-md-3 ">
                                            @if ($exam_type == 'other')
                                             <label for="" class="form-label">Exam Name</label>
                                          @else
                                          <label for="" class="form-label">Took {{$exm_name}}</label>
                                          @endif
                                          <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{ucfirst($took_exam)}}</p>
                                        </div>
                                        <div class="col-md-3 {{$display}}">
                                            <div class="h6 ">Score</div>
                                            <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{$score}}</p>
                                        </div>
                                        <div class="col-md-3 {{$display}}">
                                            <div class="h6 ">Percentile (if available)</div>
                                            <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{$percentile}}</p>
                                        </div>
                                        <div class="col-md-3 {{$display}}">
                                            <div class="h6 ">Score Card</div>
                                            <a href="{{asset('storage/uploads/user-files/'.$score_card)}}" target="_blank" class="btn btn-dark btn-sm mb-0 shadow">
                                                <i class="animated bx bx-bar-chart-square"></i>
                                                View
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile_sop" role="tabpanel">

                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-12">
                                    <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                                        SOP/Forms Details
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-md-3 col-lg-4 col-xl-4 col-xxl-3 text-center mb-3">
                                            <div class="bg-body border-5 border-bottom border-primary-1 px-2 py-3 shadow-sm radius-5">
                                                <div class="h6 mb-0 py-2">Lorem, ipsum dolor College</div>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="#" class="btn btn-dark btn-sm mt-2">View SOP</a>
                                                    <a role="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sopReview">View Review</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-4 col-xl-4 col-xxl-3 text-center mb-3">
                                            <div class="bg-body border-5 border-bottom border-primary-1 px-2 py-3 shadow-sm radius-5">
                                                <div class="h6 mb-0 py-2">Lorem, ipsum dolor College</div>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="#" class="btn btn-dark btn-sm mt-2">View SOP</a>
                                                    <a role="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sopReview">View Review</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-4 col-xl-4 col-xxl-3 text-center mb-3">
                                            <div class="bg-body border-5 border-bottom border-primary-1 px-2 py-3 shadow-sm radius-5">
                                                <div class="h6 mb-0 py-2">Lorem, ipsum dolor College</div>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="#" class="btn btn-dark btn-sm mt-2">View SOP</a>
                                                    <a role="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sopReview">View Review</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-4 col-xl-4 col-xxl-3 text-center mb-3">
                                            <div class="bg-body border-5 border-bottom border-primary-1 px-2 py-3 shadow-sm radius-5">
                                                <div class="h6 mb-0 py-2">Lorem, ipsum dolor College</div>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="#" class="btn btn-dark btn-sm mt-2">View SOP</a>
                                                    <a role="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sopReview">View Review</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-4 col-xl-4 col-xxl-3 text-center mb-3">
                                            <div class="bg-body border-5 border-bottom border-primary-1 px-2 py-3 shadow-sm radius-5">
                                                <div class="h6 mb-0 py-2">Lorem, ipsum dolor College</div>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="#" class="btn btn-dark btn-sm mt-2">View SOP</a>
                                                    <a role="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sopReview">View Review</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-4 col-xl-4 col-xxl-3 text-center mb-3">
                                            <div class="bg-body border-5 border-bottom border-primary-1 px-2 py-3 shadow-sm radius-5">
                                                <div class="h6 mb-0 py-2">Lorem, ipsum dolor College</div>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="#" class="btn btn-dark btn-sm mt-2">View SOP</a>
                                                    <a role="button" class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#sopReview">View Review</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="sopReview" tabindex="-1" aria-labelledby="sopReview" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">SOP Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border mx-0">
                                                    <div class="col-12 mt-0">
                                                        <div class="bg-primary-1 font-20 h5 mb-4 p-2 text-center text-white" id="sopCollege">SP Jain</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Reviewed By</label>
                                                        <div class="bg-body border h6 input-border px-2 py-2" id="sopReviewBy">
                                                            Jhon Doe
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Review Date</label>
                                                        <div class="bg-body border h6 input-border px-2 py-2" id="sopDate">
                                                            24 January 2021
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="" class="form-label">Review</label>
                                                        <div class="bg-body border input-border px-2 py-2" id="sopReviewContent" >
                                                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officia quasi error tempore temporibus, neque eveniet doloremque ad minima harum dolores molestias debitis? Neque fuga voluptatum nobis, quae nostrum ab dolorem temporibus quasi ullam dignissimos nemo amet repellat exercitationem corrupti maxime, molestias quo ratione! Dolor rem consequatur, magni quis delectus corporis saepe cumque, nostrum pariatur iusto fugiat fuga libero distinctio dolore sint sed quisquam quasi expedita ducimus, eos error. Harum, rem expedita. Consequuntur dolorum, rem voluptate quasi corporis sed, corrupti architecto voluptatem eaque, qui reiciendis sapiente quo illum vero dolorem recusandae. Quo beatae culpa nobis eum. Voluptates id minima voluptate dolorum!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile_dreamcolleges" role="tabpanel">

                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-12">
                                    <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                                        Colleges
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Dream colleges</div>
                                        </div>
                                        <div class="col-12 ">
                                            <select name="dream_colleges" id="dreamCo" class="multiple-select form-control"  multiple="multiple" disabled>
                                                @foreach ($dream_college_data as $college_name)
                                                    <option value="{{$college_name}}" selected>{{$college_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Calls Received</div>
                                        </div>
                                        <div class="col-12">
                                            <select name="received_calls" id="cals_get" class="multiple-select form-control"  multiple="multiple" disabled>
                                                @foreach ($received_call_data as $college_name)
                                                    <option value="{{$college_name}}" selected>{{$college_name}}</option>
                                                @endforeach
                                            </select>
                                            {{-- <div class="row row-cols-2 row-cols-lg-3 justify-content-evenly">
                                                <div class="col mb-2">
                                                    <div class="stat-badge">
                                                        <div class="stat-title">
                                                            abc Colleges
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="stat-badge">
                                                        <div class="stat-title">
                                                            abc Colleges
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="stat-badge">
                                                        <div class="stat-title">
                                                            abc Colleges
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="stat-badge">
                                                        <div class="stat-title">
                                                            abc Colleges
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="stat-badge">
                                                        <div class="stat-title">
                                                            abc Colleges
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Interview Dates</div>
                                        </div>
                                        @foreach ($interview_date_data as $interview_key => $interview)
                                            @php
                                                $college = @collect($interview)->where('key', 'college')->first()->{'value'};
                                                $interview_date = @collect($interview)->where('key', 'interview_date')->first()->{'value'};
                                                $interview_date= date('d F Y',strtotime($interview_date));
                                            @endphp
                                        <div class="col-md-3 mb-3">
                                            <div class="h6 ">{{ucfirst($college)}}</div>
                                            <p class="border border-1 py-2 px-3 shadow-sm mb-0 input-border bg-body">{{$interview_date}}</p>
                                        </div>
                                        @endforeach

                                    </div>
                                    <div class="row align-items-center bg-light mb-3 py-3 shadow-sm border">
                                        <div class="col-12">
                                            <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Converted Calls</div>
                                        </div>
                                        @foreach ($converted_call_data as $converted_key => $converted_call)
                                        @php
                                           $college = @collect($converted_call)->where('key', 'college')->first()->{'value'};
                                           $call_file = @collect($converted_call)->where('key', 'call_file')->first()->{'value'};
                                        @endphp
                                        <div class="col-md-3 col-lg-4 col-xl-4 col-xxl-3 text-center mb-3">
                                            <div class="bg-body border-5 border-bottom border-primary-1 px-2 py-3 shadow-sm radius-5">
                                                <div class="h6 mb-0 py-2">{{$college}}</div>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="{{asset('storage/uploads/user-files/'.$call_file)}}" target="blank" class="btn btn-warning btn-sm mt-2">View</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endforeach --}}
@endsection

@section('js_plugin')
    <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endsection
@section('script')
<script>
    $('a#dream_link').click(()=>{
            setTimeout(() => {
                $('.multiple-select').select2();
            }, 500);
        });
</script>
@endsection
