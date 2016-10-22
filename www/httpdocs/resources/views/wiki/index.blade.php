@include('_include.user_header',
	[
		'id'		=> 'wiki.home',
		'css'		=> 'w3/w3'
	]
)
<style>
/*
li:focus, 
li:hover
{
    color: white;
    background-color: green;
}

li > a:hover
{
    text-decoration: none;
    color: white;
}
*/
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="/">Home</a></li>
				<li class="active">Wiki</li>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-3">
				<h2 class="w3-light-grey">Laravel 5</h2>
				<ul>
					<li><a href="/wiki/laravel/index">Home</a></li>
					<li><a href="/wiki/laravel/routes">Routes</a></li>
					<li><a href="/wiki/laravel/controller">Controller</a></li>
					<li><a href="/wiki/laravel/model">Model</a></li>
					<li><a href="/wiki/laravel/authentication">Authentication</a></li>
				</ul>
				<br>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-9">
						<div class="page-header">
							<h3>Laravel Tutorial</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@include('_include.user_footer')
