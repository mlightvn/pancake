<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
    @include('_include.fb_meta')
		<title>{{(isset($title)) ? ($title . " | ") : ""}}{{ env("APP_NAME") }}</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="/css/slate.bootstrap.min.css">
    {{--
    <link rel="stylesheet" href="/css/bootstrap.min.css">
		--}}

    <link rel="stylesheet" href="/css/styles.css">

    <!-- jQuery library -->
    <script src="/common/js/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="/common/js/bootstrap.min.js"></script>

    @if (!(Auth::guard('member')->check()))
    <script src="/js/facebook.js"></script>
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (isset($w3))
    <link rel="stylesheet" href="/css/w3/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- <link rel="stylesheet" href="/css/w3/font-awesome.min.css"> -->

    <!-- Website Font style -->
    <link rel="stylesheet" href="/css/w3/font-awesome.min.css">
    @endif

    @if (isset($id))
      @if ($id == "login")
      <link rel="stylesheet" href="/css/login.css">
      <script src="/js/password.check.js"></script>
      @endif

      @if ($id == "signup")
      <link rel="stylesheet" href="/css/signup.css">
      <script src="/js/password.check.js"></script>
      @endif

      @if (isset($css))
      <link rel="stylesheet" href="/css/{{ $css }}.css">
      @endif

      @if (isset($js))
      <script src="/js/{{ $js }}.js"></script>
      @endif
    @endif
	</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="/"><span class="logo">{{ env("APP_NAME") }}</span></a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        {{--
        <li>@include('_include.user_paypal_donate')</li>
        --}}
        <li{!! ((isset($id) && ($id == 'contact')) ? ' class="active"' : '') !!}><a href="/contact"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
        <li{!! ((isset($id) && ($id == 'about')) ? ' class="active"' : '') !!}><a href="/about"><span class="glyphicon glyphicon-user"></span> About us</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          @include('_include.user_dropdown')
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search" action="/search">
        <div class="form-group">
          <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Keyword..." value="{{ (isset($keyword) ? $keyword : "") }}">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
      </form>
      @include('_include.user_login')
    </div>
  </div>
</nav>
