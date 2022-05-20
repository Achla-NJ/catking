@extends('layouts.auth')
@section('title','Reset Password - CATKing')
@section('body')
<body class="auth-bg bg-login">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-reset-password d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card">
						<div class="row g-0">
							<div class="col-lg-5 border-end">
								<div class="card-body">
									<form class="p-5" action="{{route('new-password')}}" method="post">
										@csrf
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
										<div class="text-start">
											<img src="{{asset('assets/images/logo.jpg')}}" width="180" alt="">
										</div>
										<h4 class="mt-5 font-weight-bold">Genrate New Password</h4>
										<p class="text-muted">We received your reset password request. Please enter your new password!</p>
										<div class="mb-3 mt-5">
											<label class="form-label">OTP</label>
											<input type="text" class="form-control" placeholder="Enter OTP" name="otp"/>
											<input type="hidden" value="{{Session::get('email')}}" name="email">
										</div>
										<div class="mb-3 mt-3">
											<label class="form-label">New Password</label>
											<input type="text" class="form-control" placeholder="Enter new password" name="old_password"/>
											@if($errors->has('new_password'))
												<div class="error">{{ $errors->first('new_password') }}</div>
											@endif
										</div>
										<div class="mb-3">
											<label class="form-label">Confirm Password</label>
											<input type="text" class="form-control" placeholder="Confirm password" name="new_password"/>
											
										</div>
										<div class="d-grid gap-2">
											<button type="submit" class="btn btn-primary">Change Password</button>
                                             <a href="{{route('login')}}" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
										</div>
									</form>
								</div>
							</div>
							<div class="col-lg-7">
								<img src="{{asset('assets/images/login-images/forgot-password-frent-img.jpg')}}" class="card-img login-img h-100" alt="...">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>
@endsection