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
      <form class="form-horizontal form-label-left row" action="{{route('cat-predictor-process')}}" method="post">
        @csrf
        <input type="hidden" value="{{$user->id}}" name="user_id" id="user_id">
        <div class="col-lg-6">
         <h4>Personal Info</h4>
         <hr>
         <div class="col-12">
            <div class="mb-3">
               <label for="name" class="form-label">Full Name<span style="color:red;">*</span></label>
               <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" required>
            </div>
         </div>
         <div class="col-12">
            <div class="mb-3">
               <label for="email" class="form-label">Email Address<span style="color:red;">*</span></label>
               <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" readonly required>
            </div>
         </div>
         <div class="col-12">
            <div class="mb-3">
               <label for="phone" class="form-label">Phone<span style="color:red;">*</span></label>
               <input type="phone" name="mobile_number" id="phone" class="form-control" value="{{$user->mobile_number}}" readonly required>
            </div>
         </div>
         <div class="col-12">
            <div class="mb-3">
               <label for="w-phone" class="form-label">WhatsApp Phone</label>
               <input type="phone" name="whatsapp_number" id="w-phone" class="form-control" value="{{$user->whatsapp_number}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
         </div>
         <div class="col-12">
            <div class="mb-3">
               <label for="dob" class="form-label">Date of Birth<span style="color:red;">*</span></label>
               <input type="date" name="dob" id="dob" class="form-control" value="{{$user->dob}}" required>
            </div>
         </div>
         <div class="col-12">
            <div class="mb-3">
               <label for="address" class="form-label">City</label>
               <select name="city" id="city" class="form-select">
                  <option value="">-Select-</option>
                  {{$cities = App\Models\City::all()}}
                  @foreach ($cities as $city)
                     <option value="{{$city->id}}" {{$user->city == $city->id ? "selected=selected" :""}}>{{$city->name}}</option>
                  @endforeach
               </select>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <!-- <div class="item form-group">
            <label class=" col-md-3 col-sm-3 col-xs-12" for="photo">Photo <span style="color:red;">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="photo" class="form-control col-md-7 col-xs-12"   name="photo" placeholder="" type="file" required />                                        </div>
            </div> -->
            @php
                $slot =$varc=$dilr=$quants=$score="";
            @endphp
         @foreach ($sc_cat_data as $sc_cat_key => $sc_cat)
            @php
               $slot = @collect($sc_cat)->where('key', 'slot')->first()->{'value'};
               $varc = @collect($sc_cat)->where('key', 'varc')->first()->{'value'};
               $dilr = @collect($sc_cat)->where('key', 'dilr')->first()->{'value'};
               $quants = @collect($sc_cat)->where('key', 'varc')->first()->{'value'};
               $score = @collect($sc_cat)->where('key', 'score')->first()->{'value'};
            @endphp
         @endforeach
         <h4>Exam Slot<span style="color:red;">*</span></h4>
         <hr>
         <div class="item form-group mb-3">
            <label class=" col-12" for="manager">Select Your Slot<span style="color:red;">*</span></label>
            <div class="col-12">
               <select class="form-control col-md-7 col-xs-12" required="" name="sc_cat[slot]">
                  <option value="">Slot I - Current Selected Slot</option>
                  <option value="slot1" {{($slot == 'slot1') ? 'selected' :''}}>Slot I</option>
                  <option value="slot2" {{($slot == 'slot2') ? 'selected' :''}}>Slot II</option>
                  <option value="slot3" {{($slot == 'slot3') ? 'selected' :''}}>Slot III</option>
               </select>
            </div>
         </div>
         
         <h4>Sectional Scores</h4>
         <hr>
         <div class="item form-group mb-3">
            <label class=" col-12" for="manager">VARC<span style="color:red;">*</span></label>
            <div class="col-12">
               <input id="cat_varc" class="form-control col-md-7 col-xs-12" name="sc_cat[varc]" placeholder="" type="text" required="" value="{{$varc}}" >
            </div>
         </div>
         <div class="item form-group mb-3">
            <label class=" col-12" for="manager">DILR<span style="color:red;">*</span></label>
            <div class="col-12">
               <input id="cat_dilr" class="form-control col-md-7 col-xs-12" name="sc_cat[dilr]" placeholder="" type="text" required="" value="{{$dilr}}" >
            </div>
         </div>
         <div class="item form-group mb-3">
            <label class=" col-12" for="manager">Quants<span style="color:red;">*</span></label>
            <div class="col-12">
               <input id="cat_quants" class="form-control col-md-7 col-xs-12" name="sc_cat[quants]" placeholder="" type="text" required="" value="{{$quants}}" >
            </div>
         </div>
         
         <div class="item form-group mb-3">
            <label class=" col-12" for="manager">CAT Score<span style="color:red;">*</span></label>
            <div class="col-12">
               <input id="cat" class="form-control col-md-7 col-xs-12" name="sc_cat[score]" placeholder="" type="text" required="" value="{{$score}}" >
            </div>
         </div>
      </div>
         <div class="ln_solid"></div>
         <div class="form-group mb-3">
            <div class="col-md-6 col-md-offset-3">
               <button id="send" type="submit" class="btn btn-primary">Save</button>
            </div>
         </div>
      </form>
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