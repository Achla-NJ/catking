@extends('layouts.auth')
@section('title','Forgot Password - CATKing')
@section('body')
<body class="bg-login auth-bg">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<form  method="POST" action="{{route('password-reset-otp')}}">
						@csrf
					<div class="p-4 rounded  border">
						<div class="text-center">
							<img src="assets/images/icons/forgot-2.png" width="120" alt="" />
						</div>
						<h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
						<p class="text-muted">Enter your registered email ID to reset the password</p>
						<div class="my-4">
							<label class="form-label">Email id</label>
							<input type="text" class="form-control form-control-lg" placeholder="example@user.com" name="email"/> 
							@if($errors->has('email'))
								<div class="error">{{ $errors->first('email') }}</div>
							@endif
						</div>
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary btn-lg">Send</button> <a href="{{route('login')}}" class="btn btn-light btn-lg"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>
@endsection