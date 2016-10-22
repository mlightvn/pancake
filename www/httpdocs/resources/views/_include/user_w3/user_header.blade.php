<!DOCTYPE html>
<html class="no-scroll js no-touch csstransforms csstransitions" id="ls-global">
<head>
<meta charset="utf-8">
<title>{{(!empty($title)) ? ($title . " | ") : ""}}{{ env("APP_NAME") }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ (!empty($description) ? strip_tags($description) : env('APP_DESCRIPTION')) }}">
<meta name="keywords" content="{{ (!empty($keyword) ? $keyword : env('APP_KEYWORDS')) }}">
<meta name="Author" content="Nguyễn Ngọc Nam" lang="vi" xml:lang="vi">
<meta name="Copyright" content="Copyright © 2016 {{ env('APP_NAME') }} All right reserved.">

@include('_include.fb_meta', [
	'title'					=> !empty($fb_title) ? $fb_title : "",
	'description'			=> !empty($fb_description) ? $fb_description : "",
	'img_url'				=> !empty($fb_img_url) ? $fb_img_url : "",
])

<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

{{--
*******************************************
<<START>>CSS Style Sheet
*******************************************
--}}
<!-- Styles -->
<link rel="stylesheet" href="/w3/w3.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/user_w3/styles.css">

<link rel="stylesheet" href="/css/bootstrap.min.css">

@if (!empty($id) && ($id == "home"))
<style>
.slideBar {display:none;}
</style>

	@if (!empty($data['company_list']) && (count($data['company_list']) > 5))
	<script type="text/javascript" src="/js/jssor.slider-21.1.5.mini.js"></script>
	@endif
@endif

{{--
*******************************************
<<END>>CSS Style Sheet
*******************************************
--}}

{{--
*******************************************
<<START>>Javascript
*******************************************
--}}
<script src="/common/js/jquery.min.js"></script>
<script src="/w3/w3codecolor.js"></script>

@if (!empty($id) && ($id == "home"))
<script src="/common/js/bootstrap.min.js"></script>
@endif

{{--
*******************************************
<<END>>Javascript
*******************************************
--}}

</head>

<body>
	@include('_include.google.tag_manager')
	@include('_include.fb_js_script')


<div class="w3-container w3-green">
	<div class="container w3-row">

		<div class="w3-col s12 m5 l4">
			<ul class="w3-navbar w3-green">
				<li><a href="/"><img src="/common/image/logo_white.png" alt="{{ env('APP_NAME') }}"></a></li>

				@if (env('APP_ENV') != 'production')
				<li class="w3-dropdown-hover">
					<a href="#">Dropdown test <i class="fa fa-caret-down"></i></a>
					<div class="w3-dropdown-content w3-white w3-card-4">
						<a href="http://www.google.com" _target="blank">Google</a>
					</div>
				</li>
				@endif
			</ul>
		</div>

		<div class="w3-col s0 m0 l2">
			&nbsp;
		</div>

		{{-- <<START>>Search form --}}
		<form role="search" action="/search">
			<div class="w3-col s12 m3 l3">
		        <input type="text" id="keyword" name="keyword" class="w3-input w3-text-black" placeholder="Tìm kiếm ..." value="{{ (!empty($keyword) ? $keyword : '') }}">
			</div>
			<div class="w3-col s12 m1 l1">
		        <button type="submit" class="w3-btn w3-blue"><span class="glyphicon glyphicon-search"></span> Tìm kiếm</button>
			</div>
		</form>
		{{-- <<END>>Search form --}}

		<div class="w3-col s12 m7 l2">
			@include('_include.user_w3.user_login')
		</div>

	</div>
</div>

<div class="container">
