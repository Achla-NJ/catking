@extends('layout')
@section('title','Change Password')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
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
                <li class="breadcrumb-item">
                    @if (Auth::user()->role=="student")
                    <a href="{{route('profile.view')}}"><i class="bx bx-home-alt"></i></a>
                 @else
                    <a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                 @endif
                </li>
                <li class="breadcrumb-item active" aria-current="page">Review</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('main_content')
    <div class="card"> 
        <div class="card-body">
            <div class="row ">
                
                
                    <div class="col-lg-10 mx-auto">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                                Change Password
                                </div>
                            </div>
                        </div>

                        
                    <form action="{{route('profile.update-password')}}" method="post">
                        @csrf
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                            <label class="form-label">Current Password</label>
                            <input type="text" class="form-control" required placeholder="Enter Current Password" name="old_password" value="{{old('old_password')}}"/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3 mt-3">
                            <label class="form-label">New Password</label>
                            <input type="text" class="form-control" required placeholder="Enter new password" name="new_password" value="{{old('new_password')}}"/>
                            @if($errors->has('new_password'))
                                <div class="error">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="text" class="form-control" required placeholder="Enter Confirm password" name="confirm_password" value="{{old('confirm_password')}}"/>
                        </div>
                        <div class="col-auto mb-3">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
@endsection

@section('js_plugin')
    <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
@endsection

@section('script')
@if(Session::has('success-msg'))
<script>
	successMessage("{{ Session::get('success-msg') }}")
</script>
@endif
@if(Session::has('error-msg'))
<script>
	failMessage("{{ Session::get('error-msg') }}")
</script>
@endif
@endsection