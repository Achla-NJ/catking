@extends('layout')
@section('title','WATPI & CDPI')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
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
                <li class="breadcrumb-item active" aria-current="page">WATPI & CDPI Dockets</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('main_content')
    
@endsection

@section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
@endsection

@section('script')
<script>

</script>
@endsection