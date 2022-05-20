@php
$broadcast_message_title = \App\Models\Setting::val('broadcast_message_title');
$broadcast_message_description = \App\Models\Setting::val('broadcast_message_description');
@endphp


<!doctype html>
<html lang="en" class="color-sidebar">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('assets/images/cat-icon.png')}}" type="image/png" />
	<!--plugins-->
	@yield('css_plugin')
	<link rel="stylesheet" href="{{asset('assets/plugins/notifications/css/lobibox.min.css')}}" />
	<!-- loader-->
	<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/semi-dark.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/css/header-colors.css')}}" />
	<!-- edited css -->
	<link rel="stylesheet" href="{{asset('assets/css/edit.css')}}">
	<!-- Page css -->
	@yield('page_css')
	
	<title>@yield('title')</title>
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header bg-body">
				<div>
					<img src="{{asset('assets/images/cat-icon.png')}}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">
						<img src="{{asset('assets/images/cat-text.png')}}" alt="CatKing">	
					</h4>
				</div>
				<div class="toggle-icon ms-auto text-body"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				@if (Auth::user()->role =='admin' || Auth::user()->role =='teacher')
					<li class="menu-label">Admin Section</li>
					<li> 
						<a href="{{route('admin.dashboard')}}">
							<div class="parent-icon"><i class="bx bx-home"></i>
							</div>
							<div class="menu-title">Dashboard</div>
						</a>
					</li>
					<li> 
						<a href="{{route('admin.view')}}">
							<div class="parent-icon"><i class="bx bx-user-pin"></i>
							</div>
							<div class="menu-title">Users</div>
						</a>
					</li>
					@if (Auth::user()->role =='admin' )
					<li> 
						<a href="{{route('admin.export')}}">
							<div class="parent-icon"><i class='bx bx-cog font-18 me-1'></i>
							</div>
							<div class="menu-title">User Export Data</div>
						</a>
					</li>
					<li> 
						<a href="{{route('admin.sop-export')}}">
							<div class="parent-icon"><i class='bx bx-cog font-18 me-1'></i>
							</div>
							<div class="menu-title">Export SOP Data</div>
						</a>
					</li>
					
					<li> 
						<a href="{{route('admin.college')}}">
							<div class="parent-icon"><i class='bx bx-customize font-18 me-1'></i>
							</div>
							<div class="menu-title">Colleges</div>
						</a>
					</li>
					<li> 
						<a href="{{route('admin.exam')}}">
							<div class="parent-icon"><i class='bx bx-book-reader font-18 me-1'></i>
							</div>
							<div class="menu-title">Exams</div>
						</a>
					</li>
					<li> 
						<a href="{{route('admin.pages')}}">
							<div class="parent-icon"><i class='bx bx-copy-alt font-18 me-1'></i>
							</div>
							<div class="menu-title">Pages</div>
						</a>
					</li>
					@endif
					<li>
						<a href="javascript:;" class="has-arrow">
							<div class="parent-icon"><i class='bx bx-message-rounded-check font-18 me-1'></i>
							</div>
							<div class="menu-title">Review</div>
						</a>
						<ul>
							<li> <a href="{{route('admin.attributes')}}"><i class="bx bx-right-arrow-alt"></i>Add Attributes</a>
							</li>
							<li> <a href="{{route('admin.personal-interviews')}}"><i class="bx bx-right-arrow-alt"></i>Personal Interviews Review</a>
							</li>
							<li> <a href="{{route('admin.profile-review')}}"><i class="bx bx-right-arrow-alt"></i>Profile Review</a>
							</li>
						</ul>
					</li>
					@if (Auth::user()->role =='admin' )
					<li> 
						<a href="{{route('admin.broadcast-message')}}">
							<div class="parent-icon"><i class='bx bx-cog font-18 me-1'></i>
							</div>
							<div class="menu-title">Broadcast Message</div>
						</a>
					</li>
					@endif
				@elseif (Auth::user()->role =='student')
					<li class="menu-label">Profile</li>
		
					{{-- <li> <a href="{{route('profile.view')}}">View Profile</a>
					</li> --}}
					<li> 
						<a href="{{route('profile.account')}}">
							<div class="parent-icon"><i class='bx bx-user-pin font-18 me-1'></i>
							</div>
							<div class="menu-title">Account</div>
						</a>
					</li>
					{{-- <li> <a href="{{route('profile.review')}}">Profile Review</a>
					</li> --}}

					<li> 
						<a href="{{route('profile.exams')}}">
							<div class="parent-icon"><i class='bx bx-copy-alt font-18 me-1'></i>
							</div>
							<div class="menu-title">Exams Scores</div>
						</a>
					</li>
					<li>
						<a href="{{route('profile.sops')}}">
							<div class="parent-icon"><i class='bx bx-customize font-18 me-1'></i>
							</div>
							<div class="menu-title">SOPs/Forms</div>
						</a>
					</li>
					<li> 
						<a href="{{route('profile.receivedcall')}}">
							<div class="parent-icon"><i class='bx bx-book-reader font-18 me-1'></i>
							</div>
							<div class="menu-title">Interviews</div>
						</a>
					</li>
					<li class="menu-label">PI Feedback & Dockets</li>
					<li>
						<a href="{{route('pi')}}">
							<div class="parent-icon"><i class='bx bx-star'></i>
							</div>
							<div class="menu-title">Personal Interviews</div>
						</a>
					</li>
					<li>
						<a href="{{route('profile')}}">
							<div class="parent-icon"><i class='bx bx-star'></i>
							</div>
							<div class="menu-title">Profile Reviews</div>
						</a>
					</li>
					<li>
						@php $wat_page= @\App\Models\CustomPage::find(1) @endphp
						<a href="{{route('view-page',$wat_page->slug)}}">
							<div class="parent-icon"><i class='lni lni-layers'></i>
							</div>
							<div class="menu-title">WATPI & CDPI Dockets</div>
						</a>
					</li>
				@endif

				@if (Auth::user()->role =='student' || Auth::user()->role =='admin')
					<li class="menu-label">Score Calculator</li>
					<li>
						<a href="javascript:;" class="has-arrow">
							<div class="parent-icon"><i class='bx bx-copy-alt font-18 me-1'></i>
							</div>
							<div class="menu-title">Score Calculator</div>
						</a>
						<ul>
							<li> <a href="{{route('cat-result')}}"><i class="bx bx-right-arrow-alt"></i>CAT Result
								 </a>
							</li>
							<li> <a href="{{route('xat-result')}}"><i class="bx bx-right-arrow-alt"></i>XAT Result
								 </a>
							</li>
							<li> <a href="{{route('iift-result')}}"><i class="bx bx-right-arrow-alt"></i>IIFT Result
								 </a>
							</li>
							<li> <a href="{{route('cat-predictor')}}"><i class="bx bx-right-arrow-alt"></i>CAT Percentile Predictor without Response Sheet </a>
							</li>
							{{-- <li> <a href="{{route('cat-score')}}"><i class="bx bx-right-arrow-alt"></i>CAT CAT Score Calculator </a>
							</li> --}}
						</ul>
					</li>
					<li class="menu-label">Useful Links</li>
					@php $pages= @\App\Models\CustomPage::all() @endphp
						@foreach ($pages as $page)
						@if($page->id !='1')
						<li>
							<a href="{{route('view-page',$page->slug)}}">
								<div class="parent-icon"><i class='bx bx-customize'></i>
								</div>
								<div class="menu-title">{{$page->link_text}}</div>
							</a>
						</li>
						@endif
						@endforeach
					</li>
					<li class="menu-label">Support</li>
					<li>
						<a href="mailto:support@catking.in">
							<div class="parent-icon"><i class='bx bx-mail-send'></i>
							</div>
							<div class="menu-title">Mail</div>
						</a>
					</li>
					<li>
						<a href="tel:+918999118999">
							<div class="parent-icon"><i class='bx bx-phone-call'></i>
							</div>
							<div class="menu-title">Phone</div>
						</a>
					</li>
					<li>
						<a href="https://catking.in/" target="blank">
							<div class="parent-icon"><i class='bx bx-link-external'></i>
							</div>
							<div class="menu-title">Webiste</div>
						</a>
					</li>
					<li>
						<a href="learn.catking.in" target="blank">
							<div class="parent-icon"><i class="bx bx-home-circle"></i>
							</div>
							<div class="menu-title">Student Dashboard</div>
						</a>
					</li>
					{{-- <li>
						<a href="#">
							<div class="parent-icon"><i class='bx bx-award'></i>
							</div>
							<div class="menu-title">CAT 2022 Course</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="parent-icon"><i class='bx bx-line-chart'></i>
							</div>
							<div class="menu-title">Profile Booster Course</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="parent-icon"><i class='bx bx-bookmark-plus'></i>
							</div>
							<div class="menu-title">Non-CAT MBA Entrance Course</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="parent-icon"><i class='bx bx-book-bookmark'></i>
							</div>
							<div class="menu-title">GD/WAT PI Course</div>
						</a>
					</li>
					<li>
						<a href="javascript:;" class="has-arrow">
							<div class="parent-icon"><i class='bx bx-customize'></i>
							</div>
							<div class="menu-title">College Cut-Offs</div>
						</a>
						<ul class="mm-collapse">
							@php $pages= @\App\Models\CustomPage::all() @endphp
								@foreach ($pages as $page)
								<li>
									<a href="{{route('admin.view-page',$page->id)}}"><i class="bx bx-right-arrow-alt"></i>{{$page->link_text}}</a>
								</li>
								@endforeach
							</li>
						</ul>
					</li> --}}
				@endif
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="user-box dropdown ms-auto">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<div class="border-end d-flex flex-column profile-info pe-3 me-2">
								<span class="font-bold">Last Updated</span>
								<span style="color:#a9a8a8;font-size:13px;">{{date('d F, Y',strtotime(Auth::user()->updated_at))}}</span>
							</div>
							<div class="user-info ps-3 me-3">
								<p class="user-name mb-0">{{Auth::user()->name}}</p>
							</div>
							<img src="{{ Auth::user()->avatar }}" class="user-img" alt="user avatar">                    
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="{{route('profile.account')}}"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							@if (Auth::user()->role =='admin')
								<li><a class="dropdown-item" href="{{route('admin.change-password')}}"><i class="bx bx-user"></i><span>Change Password</span></a></li>
							@else
								<li><a class="dropdown-item" href="{{route('profile.change-password')}}"><i class="bx bx-user"></i><span>Change Password</span></a></li>
							@endif
							
							
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="{{route('signout')}}"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
					
				</nav>
			</div>
		</header>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				@yield('breadcrumb')
				<!--end breadcrumb-->
				@if(!empty($broadcast_message_title) && !empty($broadcast_message_description))
					<div class="row">
						<div class="col">
							<div class="alert border-0 border-start border-5 border-info alert-dismissible fade show border-primary-1">
								<div >
									{{ $broadcast_message_title }}-Check this out for Admin announcements
									<button class="btn btn-sm btn-outline-dark ms-2" data-bs-toggle="modal" data-bs-target="#adminmsg"><i class="bx bx-message-rounded-detail me-2"></i>View</button>
								</div>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						</div>
					</div>
				@endif
                @yield('main_content')			
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer" style="padding: 20px 7px;">
			<div style="position: absolute;	right: 65px; bottom:20px;">
				<img src="{{asset('assets/images/kpmgok.png')}}" style="max-height:35px;"/>
			</div>
			<p class="mb-0">Copyright © 2022. All right reserved.
				<span style="font-size:25px;" class="mx-2"><a href="https://www.youtube.com/c/RahulCatking" class="text-body"><i class="lni lni-youtube"></i></a></span>
				<span style="font-size:20px;" class="mx-2"><a href="https://www.instagram.com/catkingeducare/?hl=en" class="text-body"><i class="lni lni-instagram"></i></a></span>
			</p>
		</footer>
		<!-- Admin Message Modal -->
		<div class="modal fade" id="adminmsg" tabindex="-1" aria-labelledby="adminmsg" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="adminmsg">{{ $broadcast_message_title }}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					{!! $broadcast_message_description !!}
				</div>
			</div>
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->	
	<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	
	@yield('js_plugin')
	<script src="{{asset('assets/plugins/notifications/js/lobibox.min.js')}}"></script>
	<script src="{{asset('assets/plugins/notifications/js/notifications.min.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('assets/js/app.js')}}"></script>
	@yield('script')
</body>

</html>