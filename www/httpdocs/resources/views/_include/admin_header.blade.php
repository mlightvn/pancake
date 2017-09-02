<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<head profile="http://purl.org/net/uriprofile/">
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="imagetoolbar" content="no">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta name="Description" content="">
<meta name="Keywords" content="">
<meta name="Author" content="Nguyễn Ngọc Nam" lang="vi" xml:lang="vi">
<meta name="Copyright" content="COPYRIGHT(C)">
<title>{{(isset($title)) ? ($title . " | ") : ""}}{{ env("APP_NAME") }}管理画面</title>
<link rel="stylesheet" type="text/css" media="all" href="/common/admin/css/common.css" charset="utf-8">
<link rel="stylesheet" type="text/css" media="all" href="/common/admin/css/screen.css" charset="utf-8">

<link rel="stylesheet" href="/w3/w3.css">
<link rel="stylesheet" href="/css/bootstrap.min.css">


@if (isset($is_upload))
<script src="/common/js/upload.js"></script>
@endif


{{-- https://laravel.com/docs/5.0/templates --}}
@if (isset($css))
<link rel="stylesheet" type="text/css" media="all" href="/common/admin/css/{{$css}}.css" charset="utf-8">
@endif

@if (isset($js))
<script src="/common/admin/js/{{$js}}.js"></script>
@endif

<link rel="index contents" href="/" title="ホーム">

{{--
<link rel="shortcut icon" type="image/x-icon" href="/image/favicon.ico">
--}}

@if (isset($map))

<script src="/js/jquery-1.10.2.js"></script>
{{--
<script src="//maps.googleapis.com/maps/api/js"></script>
--}}
<script src="/common/js/googlemap.js"></script>
<script src="/js/getAddrFromZip.js"></script>

@endif

@if (isset($text_editor))
<script src="/rofilde-ckeditor/laravel-ckeditor/ckeditor.js"></script>
<script src="/rofilde-ckeditor/laravel-ckeditor/adapters/jquery.js"></script>
@endif

</head>
<body>
<div id="container">
<div id="header">
	<a href="/admin/" title="ロゴ" id="logo"><img src="/common/image/logo_green.png" alt="{{ env('APP_NAME') }}"></a>
	<ul id="headNavigation">
		<li id="headHome"><a href="/admin/">管理画面</a></li>
		<li id="headUserHome"><a href="/" target="_blank">ユーザー画面</a></li>
	</ul>
</div>
<hr class="separate">
<div id="contents">
	<div id="main">