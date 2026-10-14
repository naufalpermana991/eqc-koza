<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="author" content="KST Developer Team">
	<link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/images/') }}/logo-icon.png" />

	<title>Login Form</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{ URL::asset('assets/vendors/core/core.css') }}">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{ URL::asset('assets/fonts/feather-font/css/iconfont.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
	<!-- endinject -->

	<!-- Layout styles -->  
	<link rel="stylesheet" href="{{ URL::asset('assets/css/demo1/style.css') }}">
	<!-- End layout styles -->
</head>
<body>
	<div class="main-wrapper">
		<div class="page-wrapper full-page" style="background-color: #f4f9f9 !important;">
			<div class="page-content d-flex align-items-center justify-content-center">

				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-3 col-xl-3 mx-auto">
						<div class="card">
							<div class="row">
								<div class="col-md-12 text-center">
									<a href="#" class="noble-ui-logo d-block">
										<img style="width: 150px;margin:20px;" src="{{ URL::asset('assets/images/') }}/logo-app.png" alt="">
									</a>
									<h3><b>Welcome to E-QC System</b></h3>
									<br>
									<p>Please input details below</p>
								</div>
								<div class="col-md-12">
									<div class="auth-form-wrapper px-4 py-5">
										@include('components.alerts')
										<form class="forms-sample" method="POST" action="/auth/login">
											@csrf
											<div class="mb-3">
												<label for="username" class="form-label">Username</label>
												<div class="input-group mb-3">
													<span class="input-group-text" id="basic-addon1"><i data-feather="user"></i></span>
													<input type="text" class="form-control" id="username" aria-label="Username" aria-describedby="basic-addon1" placeholder="Username" name="username">
												</div>
											</div>
											<div class="mb-3">
												<label for="password" class="form-label">Password</label>
												<div class="input-group mb-3">
													<span class="input-group-text" id="basic-addon2"><i data-feather="lock"></i></span>
													<input type="password" class="form-control" id="password" aria-label="Password" aria-describedby="basic-addon2" placeholder="Password" name="password">
													<span class="input-group-text show-password" style="background-color: white !important;cursor: pointer;"><i id="eye-off" data-feather="eye-off"></i><i id="eye-on" style="display: none;" data-feather="eye"></i></span>
												</div>
											</div>
											<div class="mb-3">
												<input type="checkbox" name="rememberme" value="yes" id="rememberme"> <label for="rememberme">Remember me</label>
											</div>
											<div>
												<button type="submit" class="btn btn-sm btn-danger form-control">Login</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- core:js -->
	<script src="{{ URL::asset('assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->

	<!-- inject:js -->
	<script src="{{ URL::asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ URL::asset('assets/js/template.js') }}"></script>
	<!-- endinject -->

	<script type="text/javascript">
		$(function(){
			setTimeout(function(){
				$('#flashMessage').hide(300);
			}, 5000);
		});

		$(document).ready(function() {

			$(".show-password, .hide-password").on('click', function() {
				if ($(this).hasClass('show-password')) {
					$("#password").attr("type", "text");
					$(this).removeClass('show-password');
					$(this).addClass('hide-password');
					$('#eye-off').css('display','none');
					$('#eye-on').css('display','flex');
				} else {
					$("#password").attr("type", "password");
					$(this).removeClass('hide-password');
					$(this).addClass('show-password');
					$('#eye-off').css('display','flex');
					$('#eye-on').css('display','none');
				}
			});
		});
	</script>

</body>
</html>