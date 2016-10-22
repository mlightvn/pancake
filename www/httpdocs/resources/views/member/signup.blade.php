@include('_include.user_header',
	[
		'id'		=> 'signup',
		'title'		=> 'ユーザーの新規登録'
	]
)


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="/">Home</a></li>
				<li class="active">Signup</li>
			</ul>
		</div>
	</div>
</div>
<div class="container">
	<div class="row main">
		<div class="panel-heading">
			<div class="panel-title text-center">
				<h1 class="title">Member signup</h1>
				<hr class="colorline">
			</div>
		</div>
		<div class="main-login main-center">
			<form class="form-horizontal" method="post" action="signup">
				@include('_include.error_message')

				{!! csrf_field() !!}
				<h2><small>It's free and always be.</small></h2>
				<div class="form-group">
					<label for="name" class="cols-sm-2 control-label">Your Name</label>
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
							<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="email" class="cols-sm-2 control-label">Your Email</label>
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
							<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="cols-sm-2 control-label">Password</label>
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
							<input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password"/>
							<input type="password" class="form-control" name="password_confirmation" id="password_confirmation"  placeholder="Confirm your Password"/>
							<div class="pwstrength_viewport_progress"></div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="cols-sm-2 control-label">
						<span class="button-checkbox">
							<button type="button" class="btn" data-color="info" tabindex="7">I Agree</button>
							<input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="1">
						</span>
					</label>
					<div class="cols-sm-10">
						By clicking <strong class="label label-primary">Register</strong>, you agree to the <a href="/terms" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
					</div>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
				</div>
				<div class="login-register">
					<a href="/member/login">Login</a>
				 </div>
			</form>
		</div>
	</div>
</div>

@include('_include.user_footer')
