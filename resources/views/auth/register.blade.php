@extends('layouts.auth')
@section('title','Register - CATKing')
@section('body')
<body class="bg-login auth-bg">
	<!--wrapper-->
	<div class="wrapper">
		<div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
					<div class="col mx-auto">
						<div class="my-4 text-center">
							<img src="{{asset('assets/images/logo.jpg')}}" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign Up</h3>
										<p>Already have an account? <a href="{{route('login')}}" class="bg-primary-3 px-2 py-1 radius-5 shadow-sm text-body ms-2">Sign in here</a>
										</p>
									</div>
									
									<div class="form-body">
										<form class="row g-3" method="POST" action="{{route('signup')}}">
                                            @csrf
											<div class="col-sm-6">
												<label for="fullname" class="form-label">Full Name</label>
												<input type="text" class="form-control" name="name" id="fullname" placeholder="Jhon Doe" required value={{old('name')}}>
												@if($errors->has('name'))
													<div class="error">{{ $errors->first('name') }}</div>
												@endif
											</div>
											<div class="col-sm-6">
												<label for="email" class="form-label">Email Address</label>
												<input type="email" class="form-control" id="email" name="email" placeholder="example@user.com" required value={{old('email')}} >
												@if($errors->has('email'))
													<div class="error">{{ $errors->first('email') }}</div>
												@endif
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" required class="form-control border-end-0" name="password" id="inputChoosePassword"  placeholder="Enter Password" value={{old('password')}}> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>												
												</div>
												@if($errors->has('password'))
														<div class="error">{{ $errors->first('password') }}</div>
													@endif
											</div>
                                            <div class="col-12">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" name="mobile_number" id="phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="+91987654321" class="form-control" required value={{old('mobile_number')}} >
												@if($errors->has('mobile_number'))
													<div class="error">{{ $errors->first('mobile_number') }}</div>
												@endif
                                            </div>
											<div class="col-12">
												<label for="is_student" class="form-label">Are You CATKing Student ?</label>
												<select class="form-select" id="is_student" name="is_catking_student" aria-label="Default select example" required>
													<option value="no" {{old('is_catking_student')=='no'?'selected=selected':''}}} >No</option>
                                                    <option value="yes" {{old('is_catking_studentis_catking_student')=='yes'?'selected=selected':''}}}>Yes</option>
												</select>
												@if($errors->has('is_catking_student'))
													<div class="error">{{ $errors->first('is_catking_student') }}</div>
												@endif
											</div>
											<div class="col-12">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="terms" required>
													<label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to <a href="#"> Terms & Conditions</a></label>
													@if($errors->has('terms'))
														<div class="error">{{ $errors->first('terms') }}</div>
													@endif
												</div>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary shadow"><i class='bx bx-user'></i>Sign up</button>
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