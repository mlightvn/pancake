@include('_include.user_header',
	[
		'id'		=> 'login',
		'title'		=> 'ユーザーログイン'
	]
)

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="/">Home</a></li>
				<li class="active">Login</li>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-heading">
				<div class="panel-title text-center">
					<h1 class="title">Member login</h1>
					<hr class="colorline">
				</div>
			</div>
			<div id="login-dp" class="login-page">
				Login via
				<div class="social-buttons">
					<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
					<a href="#" class="btn btn-gplus"><i class="fa fa-google-plus"></i> Google Plus</a>
				</div>
				or
				<form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
					@include('_include.error_message')

					{!! csrf_field() !!}
					<div class="form-group">
						<label class="sr-only" for="email">Email address</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
					</div>
					<div class="form-group">
						<label class="sr-only" for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
						<div class="pwstrength_viewport_progress"></div>
						<div class="help-block text-right"><a href="/member/recover_password">Forgot password ?</a></div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Sign in</button>
					</div>
					<div class="checkbox">
						<label>
						<input type="checkbox"> keep me logged-in
						</label>
					</div>
				</form>
			</div>
		</div>
		<div class="bottom text-center">
			New here ? <a href="/member/signup"><b>Join Us</b></a>
		</div>
	</div>

</div>

@include('_include.user_footer')
