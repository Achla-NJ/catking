@extends('layout')
@section('title','Interviews')
@section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}"
   rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}"
   rel="stylesheet" />
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}"
   rel="stylesheet" />
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
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                           Colleges
                     </div>
                  </div>
               </div>
               <div class="row">
                  <form id="dream-college-form" action="{{route('profile.update-allcall')}}">
                     @csrf
                     <input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
                     <div class="col-12">
                        <div class="row align-items-center mb-2">
                           <div class="col-12">
                              <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">
                                 Calls Received</div>
                           </div>

                           <div class="col-12">
                              @php
                                 $user_college_ids = collect($user['received_call_colleges'] ?? [])->pluck('college_id')->toArray();
                              @endphp
                              <select name="received_call[]" id="calls_received" class="multiple-select form-control" multiple="multiple">
                                 @foreach ($colleges as $college)
                                    @continue(in_array($college->id, $user_college_ids))
                                    <option value="{{$college->id}}">{{$college->name}}</option>
                                 @endforeach
                                 @foreach ($user['received_call_colleges'] as $item)
                                    <option value="{{$item->college_id}}" selected>{{$item->college_name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="row align-items-center">
                           <div class="col-12">
                              <div class="bg-primary-4 font-20 h5 mb-4 p-2 ">Interview Dates</div>
                           </div>
                           <div class="col-12">
                              @foreach ($user['interview_dates'] as $interview_key => $interview)
                              @php
                                 $college = $interview->college->name;
                                 $interview_date = $interview->date;
                                 $clg_id=$interview->college_id;
                              @endphp
                              <div class="card bg-light dream_college_div" id="dream_college_row_{{$interview_key}}">
                                 <div class="card-body">
                                    <div class="row align-items-center">
                                       <div class="col-12 col-sm-auto order-sm-2">
                                          <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button" onclick="removeRow('#dream_college_row_{{$interview_key}}','{{$clg_id}}','{{$college}}')">
                                             <i class="bx bx-trash m-0"></i>
                                          </button>
                                       </div>
                                       <div class="col">
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="mb-3">
                                                   <label for="" class="form-label">College Name</label>
                                                   <p class="form-control">{{$college}}</p>
                                                   <input type="hidden" readonly value="{{$interview->college_id}}" name="interview[{{$interview_key}}][college]" class="form-control">
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="mb-3">
                                                   <label for=""
                                                      class="form-label">Select Date <span style="color:red;">*</label></label>
                                                   <input type="date" name="interview[{{$interview_key}}][interview_date]" value="{{$interview_date}}" class="form-control">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                              <div id="dreamcollege_append"></div>
                           </div>
                           @if (Auth::user()->role !='teacher' )
                           <div class="col-12"
                              onclick="openModel('#dreamcollege-modal')">
                              <button class="btn btn-dark btn-sm mb-3" type="button"><i class="bx bx-bookmark-plus"></i>Add More Dates</button>
                           </div>
                           @endif
                           <div class="modal fade" id="dreamcollege-modal" tabindex="-1" aria-labelledby="dreamcollege" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                 <div class="modal-content">
                                    <div class="modal-loader">
                                       <div class="spinner-grow" role="status">
                                          <span
                                             class="visually-hidden">Loading...</span>
                                       </div>
                                    </div>
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="edu-model"> Please Select</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <select name="" id="edu-dreamcollege-select" class="multiple-select form-control" multiple="multiple">
                                          {{-- {{ $college = App\Models\College::all() }}
                                          @foreach ($college as $item)
                                             
                                                <option value="{{$item->id}}"> {{$item->name}}</option>
                                                                                      @endforeach
                                          <option value="other">Other</option> --}}

                                          @php
                                             $user_college_ids = collect($user['interview_dates'] ?? [])->pluck('college_id')->toArray();
                                             $college = App\Models\College::where('created_by_user','no')->where('status','active')->get();
                                             @endphp
                                             @foreach ($college as $key => $item)
                                                @if(!in_array($item->id, $user_college_ids))
                                                   <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endif	
                                             @endforeach
                                       </select>
                                       <input type="hidden" value="{{route('profile.add-dreamcollege')}}" id="add-dream-college">
                                       @if (Auth::user()->role !='teacher' )
                                       <button class="btn-primary btn mt-3" onclick="(addDreamCollege)()" data-bs-dismiss="modal" aria-label="Close">Add</button>
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row align-items-center mb-2">
                           <div class="col-12">
                              <div class="bg-primary-4 font-20 h5 mb-4 p-2 "> Converted Calls</div>
                           </div>
                           <div class="col-12">
                              @foreach ($user['converted_call_colleges'] as $converted_key => $converted_call)
                                 @php
                                    $college = $converted_call->college->name;
                                    $call_file = $converted_call->file;
                                    $clg_id=$converted_call->college_id;
                                 @endphp
                              <div class="card bg-light converted_call_div" id="call_{{$converted_key}}">
                                 <div class="card-body">
                                    <div class="row align-items-center">
                                       <div
                                          class="col-12 col-sm-auto order-sm-2">
                                          <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button" onclick="removeRow('#call_{{$converted_key}}','{{$clg_id}}','{{$college}}')"><i class="bx bx-trash m-0"></i></button>
                                       </div>
                                       <div class="col">
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="mb-3">
                                                   <label for="" class="form-label">College Name</label>
                                                   <p class="form-control">{{$converted_call->college->name}}</p>
                                                   <input type="hidden" readonly value="{{$converted_call->college_id}}" class="form-control" name="converted_call[{{$converted_key}}][college]">
                                                </div>
                                             </div>
                                             <div class="col-md-5">
                                                <div class="mb-3">
                                                   <label for="" class="form-label">Add Document <span style="color:red;">*</label>
                                                   <input type="file" onchange="getCallfile(this,'#call_file_{{$converted_key}}')" class="form-control">
                                                   <input type="hidden" name="converted_call[{{$converted_key}}][call_file]" id="call_file_{{$converted_key}}" value="{{$call_file}}">

                                                </div>

                                             </div>
                                             @if(!empty($call_file))
                                                <div class="col-md-1 my-auto">
                                                   <a href="{{route('user-files', $call_file)}}" class="btn btn-warning btn-sm" target="_blank" >view</a>
                                                </div>
                                                @endif
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endforeach

                              <div id="call_append"></div>
                              <input type="hidden" value="{{route('profile.call')}}" id="profile-call">
                           </div>
                           @if (Auth::user()->role !='teacher' )
                           <div class="col-12" onclick="openModel('#call-modal')">
                              <button class="btn btn-dark btn-sm mb-3" type="button"><i class="bx bx-bookmark-plus"></i>Add More Calls</button>
                           </div>
                           @endif
                           <div class="modal fade" id="call-modal" tabindex="-1"
                              aria-labelledby="call" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                 <div class="modal-content">
                                    <div class="modal-loader">
                                       <div class="spinner-grow" role="status">
                                          <span class="visually-hidden">Loading...</span>
                                       </div>
                                    </div>
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="edu-model"> Please Select</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <select name="" id="edu-call-select" class="multiple-select form-control" multiple="multiple">
                                          {{-- {{ $college = App\Models\College::all() }}
                                             @foreach ($college as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                             @endforeach
                                          <option value="other">Other</option> --}}
                                          @php
                                             $user_college_ids = collect($user['converted_call_colleges'] ?? [])->pluck('college_id')->toArray();
                                             $college = App\Models\College::where('created_by_user','no')->where('status','active')->get();
                                             @endphp
                                             @foreach ($college as $key => $item)
                                                @if(!in_array($item->id, $user_college_ids))
                                                   <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endif	
                                             @endforeach
                                       </select>
                                       <input type="hidden" value="{{route('profile.add-call')}}" id="add-call">
                                       <button class="btn-primary btn mt-3" onclick="addCall()" data-bs-dismiss="modal" aria-label="Close">Add</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               @if (Auth::user()->role !='teacher' )
               <div class="row mt-3">
                  <div class="col-12 text-end">
                     <button id="dreamCollege" type="button"  onclick="saveDreamCollege()" tab-next="profile_stats"class="btn btn-primary"><i class="bx bx-cloud-upload"></i> Save</button>
                  </div>
               </div>
               @endif
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
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}">
</script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endsection
@section('script')
<script src="{{asset('assets/js/profile.js')}}"></script>
<script src="{{asset('assets/js/interview.js')}}"></script>
@endsection
