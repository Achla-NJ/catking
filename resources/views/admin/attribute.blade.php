@extends('layout')
@section('title','Attributes')
@section('css_plugin')
   <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
@endsection
@section('page_css')
   <link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
@endsection
@section('breadcrumb')
   <div class="page-breadcrumb d-flex align-items-center mb-3" style="justify-content: space-between;">
      <div class="d-flex">
         <div class="breadcrumb-title pe-3">Home</div><div class="ps-3">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0 p-0">
                  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Attributes</li>
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
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                        Add Attributes for Evaluation
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills nav-fill nav-primary" role="tablist" id="profile_tab">
               <li class="nav-item" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#profile_besic" role="tab" aria-selected="true">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Personal Interview</div>
                     </div>
                  </a>
               </li>

               <li class="nav-item" role="presentation">
                  <a class="nav-link " data-bs-toggle="tab" href="#profile_stats" role="tab" aria-selected="false">
                     <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bx bx-copy-alt font-18 me-1'></i>
                        </div>
                        <div class="tab-title">Profile</div>
                     </div>
                  </a>
               </li>
            </ul>
            
            <div class="px-2 py-3 shadow-sm tab-content">
               <div class="tab-pane fade show active" id="profile_besic" role="tabpanel">
                  <div class="col-lg-11 mx-auto">
                    <form action="{{route('admin.store-attributes')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="interview">
                        @php
                            $count=0;
                        @endphp
                        @foreach ($interviews as $interview)
                        @php
                            if(empty($interview)){
                                $interview_data = '';
                            }  else{
                                $interview_data = $interview->attribute; 
                            } 
                        @endphp
                        @php $count++;@endphp
                            <div class="row mb-3" id="perticular_{{$count}}">
                                <div class="col-md-4">
                                    <input type="text" required class="form-control" value="{{$interview_data}}" name="attribute[]" />
                                </div>
                                <div class="col-md-2 ">
                                    @if ($count ==1)
                                    {{-- <button type="button" class="btn btn-primary btn-sm" onclick="AddInterview()">Add more</button> --}}
                                    @else
                                    <button type="button" class="btn btn-danger btn-sm" onclick="remove('#perticular_{{$count}}')"><i class="bx bx-trash"></i></button>
                                    @endif
                                    
                                </div>
                            </div>
                        @endforeach
                        <div id="interview_append"></div>
                        <div class="row">
                            <div class="col-md-6  mt-3">
                                <button type="button" class="btn btn-dark " onclick="AddInterview()">Add more</button>
                                <button type="submit" class="btn btn-primary" >Save</button>
                            </div>
                        </div>
                    </form>
                    
                  </div>
               </div>

               <div class="tab-pane fade " id="profile_stats" role="tabpanel">
                <div class="col-lg-11 mx-auto">
                    <form action="{{route('admin.store-attributes')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="profile">
                        @php
                            $count=0;
                        @endphp
                        @foreach ($profiles as $profile)
                        @php
                            if(empty($profile)){
                                $profile_data = '';
                            }  else{
                                $profile_data = $profile->attribute; 
                            } 
                        @endphp
                        @php $count++;@endphp
                            <div class="row mb-3" id="perticular_{{$count}}">
                                <div class="col-md-4">
                                    <input type="text" required class="form-control" value="{{$profile_data}}" name="attribute[]" />
                                </div>
                                <div class="col-md-2 ">
                                    @if ($count ==1)
                                    {{-- <button type="button" class="btn btn-primary btn-sm" onclick="AddProfile()">Add more</button> --}}
                                    @else
                                    <button type="button" class="btn btn-danger btn-sm" onclick="remove('#perticular_{{$count}}')"><i class="bx bx-trash"></i></button>
                                    @endif
                                    
                                </div>
                            </div>
                        @endforeach
                        <div id="profile_append"></div>
                        <div class="row">
                            <div class="col-md-6  mt-3">
                                <button type="button" class="btn btn-dark " onclick="AddProfile()">Add more</button>
                                <button type="submit" class="btn btn-primary" >Save</button>
                            
                            </div>
                        </div>
                    </form>
                  </div>
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
<script>
    let counter ;

    function AddInterview(){
        counter =Math.floor(Math.random() * 100) +15;
        var html = `
                <div class="row mb-3" id="perticular_${counter}">
                    <div class="col-md-4">
                        <input type="text" required class="form-control" name="attribute[]" />
                    </div>
                    <div class="col-md-2 ">
                        <button type="button" class="btn btn-danger btn-sm" onclick="remove('#perticular_${counter}')"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
        `;
        $("#interview_append").append(html);
    }

    function AddProfile(){
        counter =Math.floor(Math.random() * 100) +15;
        var html = `
                <div class="row mb-3" id="perticular_${counter}">
                    <div class="col-md-4">
                        <input type="text" required class="form-control" name="attribute[]" />
                    </div>
                    <div class="col-md-2 ">
                        <button type="button" class="btn btn-danger btn-sm" onclick="remove('#perticular_${counter}')"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
        `;
        $("#profile_append").append(html);
    }
    function remove(id){
        $(id).remove();
    }
</script>
@if(Session::has('success'))
<script>
	successMessage("{{ Session::get('success') }}")
</script>
@endif
@endsection