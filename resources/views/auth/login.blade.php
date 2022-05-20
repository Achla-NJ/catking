@extends('layouts.auth')
@section('title','Login - CATKing')
@section('body')
<body class="bg-login auth-bg">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<img src="{{asset('assets/images/logo.jpg')}}" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign in</h3>
										<p>Don't have an account yet? <a href="{{route('regiter-view')}}" class="bg-primary-3 px-2 py-1 radius-5 shadow-sm text-body">Sign up here</a>
										</p>
									</div>
									@if(Session::has('error-msg'))
										<div class="alert alert-danger">
										{{ Session::get('error-msg')}}
										</div>
									@endif
									@if(Session::has('success-msg'))
										<div class="alert alert-success">
										{{ Session::get('success-msg')}}
										</div>
									@endif
									<div class="form-body">
										<form class="row g-3" method="POST" action="{{route('signin')}}">
											@csrf
											<div class="col-12">
												<label for="email" class="form-label">Email Address</label>
												<input type="email" class="form-control" id="email" name="email"placeholder="Email Address" value={{old('email')}}>
												@if($errors->has('email'))
													<div class="error">{{ $errors->first('email') }}</div>
												@endif
											</div>
											<div class="col-12">
												<label for="password" class="form-label">Enter Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="password" name="password"  placeholder="Enter Password" value={{old('password')}}> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
												@if($errors->has('password'))
														<div class="error">{{ $errors->first('password') }}</div>
													@endif
											</div>
											<div class="col-md-6">	
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="remember_me" >
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
													
											</div>
											<div class="col-md-6 text-end">	<a href="{{route('password-forgot')}}" class="text-danger">Forgot Password ?</a>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>
@endsection