<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>
    @lang('quickadmin.quickadmin_title')
</title>

<meta http-equiv="X-UA-Compatible"
      content="IE=edge">
<meta content="width=device-width, initial-scale=1.0"
      name="viewport"/>
<meta http-equiv="Content-type"
      content="text/html; charset=utf-8">
 <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/2de52d4ecb.js" crossorigin="anonymous"></script>
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<link href="{{ url('adminlte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link rel="stylesheet"
      href="{{ url('quickadmin/css') }}/select2.min.css"/>
<link href="{{ url('adminlte/css/AdminLTE.min.css') }}" rel="stylesheet">
<link href="{{ url('adminlte/css/custom.css') }}" rel="stylesheet">
<link href="{{ url('adminlte/css/skins/skin-blue.min.css') }}" rel="stylesheet">
<link rel="stylesheet"
      href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet"
      href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
<link rel="stylesheet"
      href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css"/>
<link rel="stylesheet"
      href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"/>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css"/>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css"/>
	<style>
		body.mainlogin {
			background-image: url(/imgs/home-bg.jpg);
			background-size: cover;
			background-repeat: no-repeat;
			background-position: -38%;
			height: 100vh;
			overflow-y: hidden;
		}
		.transpy{
			
			background-color: rgba(255, 255, 255, 0.46) !important;
		}
		.chakra{
			background-color: #2555c26e !important;
		}
		.form-section {
			display: flex;
			justify-content: center;
		}
	</style>
</head>
<body class="page-header-fixed mainlogin">
<img src="/imgs/main-logo.png" alt="" width="130">
	<div style="margin-top: 10%;"></div>
	<div class="container-fluid">
		<div class="row form-section">
				<div class="col-md-6">
					<div class="panel panel-default transpy">
						<div style="background-color:#1976d2; color:white; font-size:18px" class="panel-heading chakra">
							{{ ucfirst(config('app.name')) }} admin @lang('quickadmin.qa_login')
						</div>
						<div class="panel-body">
							
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<strong>@lang('quickadmin.qa_whoops')</strong> @lang('quickadmin.qa_there_were_problems_with_input'):
									<br><br>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<form class="form-horizontal"
								role="form"
								method="POST"
								action="{{ url('login') }}">
								<input type="hidden"
									name="_token"
									value="{{ csrf_token() }}">

								<div class="form-group">
									<label class="col-md-4 control-label">@lang('quickadmin.qa_email')</label>

									<div class="col-md-6">
										<input type="email"
											class="form-control"
											name="email"
											value="{{ old('email') }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">@lang('quickadmin.qa_password')</label>

									<div class="col-md-6">
										<input type="password"
											class="form-control"
											name="password">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<a href="{{ route('auth.password.reset') }}">@lang('quickadmin.qa_forgot_password')</a>
									</div>
								</div>


								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<label>
											<input type="checkbox"
												name="remember"> @lang('quickadmin.qa_remember_me')
										</label>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit"
												class="btn btn-primary"
												style="margin-right: 15px;">
											@lang('quickadmin.qa_login')
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>