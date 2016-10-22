<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<head profile="http://purl.org/net/uriprofile/">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="imagetoolbar" content="no">
<meta name="Description" content="">
<meta name="Keywords" content="">
<meta name="Author" content="Nguyễn Ngọc Nam" lang="ja" xml:lang="ja">
<meta name="Copyright" content="COPYRIGHT(C)">

<meta name="robots" content="noindex,nofollow,nosnippet,noimageindex,noarchive" />
<meta name="googlebot" content="noindex,nofollow,nosnippet,noimageindex,noarchive" />
<meta name="google" content="nositelinkssearchbox" />
<meta name="google" content="notranslate" />

<title>{{(isset($title)) ? ($title . " | ") : ""}}{{ env("APP_NAME") }}管理画面</title>

<link rel="index contents" href="/" title="ホーム">

{{--
*********************************
<<START>>CSS
*********************************
--}}

{{--
<link rel="stylesheet" type="text/css" media="all" href="/css/font-awesome.min.css" charset="utf-8">
--}}

<!-- Bootstrap Core CSS -->
<link rel="stylesheet" type="text/css" media="all" href="/css/bootstrap.min.css" charset="utf-8">
<!-- Menu CSS -->
<link href="/common/admin_new/css/metisMenu.min.css" rel="stylesheet">
<!-- Menu CSS -->
<link rel="stylesheet" type="text/css" media="all" href="/common/admin_new/css/morris.css" charset="utf-8">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" media="all" href="/common/css/styles.css" charset="utf-8">
<link rel="stylesheet" type="text/css" media="all" href="/common/admin_new/css/style.css" charset="utf-8">

@if (isset($css))
<link rel="stylesheet" type="text/css" media="all" href="/common/admin_new/css/{{$css}}.css" charset="utf-8">
@endif
{{--
*********************************
<<END>>CSS
*********************************
--}}

{{--
*********************************
<<START>>Javascript
*********************************
--}}
<script src="/common/js/jquery.min.js"></script>
<script src="/common/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="/common/admin_new/js/metisMenu.min.js"></script>

<!--Nice scroll JavaScript -->
<script src="/common/admin_new/js/jquery.nicescroll.js"></script>

<!--Morris JavaScript -->
<script src="/common/admin_new/js/raphael-min.js"></script>
<script src="/common/admin_new/js/morris.js"></script>
<!--Wave Effects -->
<script src="/common/admin_new/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="/common/admin_new/js/myadmin.js"></script>
<script src="/common/admin_new/js/dashboard1.js"></script>
<script src="/common/admin_new/js/jquery.sparkline.min.js"></script>
<script src="/common/admin_new/js/jquery.charts-sparkline.js"></script>

@if (isset($map))
<script src="//maps.googleapis.com/maps/api/js"></script>
{{--
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCtjRQJwGxVD9uY_pyxKuvG7ZEl47FOLsE&callback=initMap"></script>
--}}
<script src="/common/js/googlemap.js"></script>
<script src="/js/getAddrFromZip.js"></script>
@endif

@if (isset($text_editor))
<script src="/rofilde-ckeditor/laravel-ckeditor/ckeditor.js"></script>
<script src="/rofilde-ckeditor/laravel-ckeditor/adapters/jquery.js"></script>
@endif

@if (isset($js))
<script src="/common/admin_new/js/{{$js}}.js"></script>
@endif

{{--
<link rel="shortcut icon" type="image/x-icon" href="/image/favicon.ico">
--}}

{{--
*********************************
<<END>>Javascript
*********************************
--}}


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>

</head>
<body>

<!-- Preloader -->
<div class="preloader" style="display: none;">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
    <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="glyphicon-menu-hamburger"></i></a>
      <div class="top-left-part"><a class="logo" href="/admin"><img src="/common/image/logo_green.png" width="16px">&nbsp;<span class="hidden-xs">{{ env('APP_NAME') }}</span></a></div>
      <ul class="nav navbar-top-links navbar-left hidden-xs">
        <li><a href="javascript:void(0);" class="open-close hidden-xs waves-effect waves-light"><i class="glyphicon glyphicon-circle-arrow-left glyphicon-menu-hamburger"></i></a></li>
        <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0);"><i class="glyphicon glyphicon-shopping-cart"></i> <span class="badge badge-xs badge-danger">1</span></a>
          <ul class="dropdown-menu mailbox">
            <li>
              <div class="drop-title">You have 1 new order</div>
            </li>
            <li>
              <div class="message-center"> <a href="javascript:void(0);">
                <div class="user-img"> <img src="/image/member/1/logo.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                <div class="mail-contnet">
                  <h5>Tố Như</h5>
                  <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                </a>
              </div>
            </li>
            <li> <a class="text-center" href="javascript:void(0);"> <strong>See all orders</strong> <i class="glyphicon glyphicon-chevron-right"></i> </a></li>
          </ul>
          <!-- /.dropdown-messages -->
        </li>
        <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0);"><i class="glyphicon glyphicon-envelope"></i> <span class="badge badge-xs badge-warning">5</span></a>
          <ul class="dropdown-menu mailbox">
            <li>
              <div class="drop-title">You have 5 new messages</div>
            </li>
            <li>
              <div class="message-center"> <a href="javascript:void(0);">
                <div class="user-img"> <img src="/image/member/1/logo.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                <div class="mail-contnet">
                  <h5>Tố Như</h5>
                  <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                </a> <a href="javascript:void(0);">
                <div class="user-img"> <img src="/image/member/3/logo.png" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                <div class="mail-contnet">
                  <h5>Thiên Thần</h5>
                  <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                </a> <a href="javascript:void(0);">
                <div class="user-img"> <img src="{{ env('IMAGE_NO_FEMALE') }}" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                <div class="mail-contnet">
                  <h5>Hoàng Hậu</h5>
                  <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                </a> <a href="javascript:void(0);">
                <div class="user-img"> <img src="/image/member/1/logo.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                <div class="mail-contnet">
                  <h5>Tố Như</h5>
                  <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                </a> </div>
            </li>
            <li> <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="glyphicon glyphicon-chevron-right"></i> </a></li>
          </ul>
          <!-- /.dropdown-messages -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0);"><i class="glyphicon glyphicon-comment"></i> <span class="badge badge-xs badge-danger">5</span></a>
          <ul class="dropdown-menu dropdown-tasks">
            <li> <a href="javascript:void(0);">
              <div>
                <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                </div>
              </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="javascript:void(0);">
              <div>
                <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>
                </div>
              </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="javascript:void(0);">
              <div>
                <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>
                </div>
              </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="javascript:void(0);">
              <div>
                <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>
                </div>
              </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a class="text-center" href="javascript:void(0);"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a> </li>
          </ul>
          <!-- /.dropdown-tasks -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0);"><i class="glyphicon glyphicon-bell"></i> <span class="badge badge-xs badge-info">5</span></a>
          <ul class="dropdown-menu dropdown-alerts">
            <li> <a href="javascript:void(0);">
              <div> <i class="ti-comments fa-fw"></i> New Comment <span class="pull-right text-muted small">4 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="javascript:void(0);">
              <div> <i class="ti-twitter fa-fw"></i> 3 New Followers <span class="pull-right text-muted small">12 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="javascript:void(0);">
              <div> <i class="ti-email fa-fw"></i> Message Sent <span class="pull-right text-muted small">4 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="javascript:void(0);">
              <div> <i class="ti-pencil-alt fa-fw"></i> New Task <span class="pull-right text-muted small">4 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="javascript:void(0);">
              <div> <i class="ti-upload fa-fw"></i> Server Rebooted <span class="pull-right text-muted small">4 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a class="text-center" href="javascript:void(0);"> <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i> </a> </li>
          </ul>
          <!-- /.dropdown-alerts -->
        </li>
      </ul>
      <ul class="nav navbar-top-links navbar-right pull-right active">
        <li class="in">
          <form role="search" class="app-search hidden-xs">
            <input type="text" placeholder="Search..." class="form-control">
            <a href="http://themedesigner.in/demo/myadmin/myadmin/index.html" class="active"><i class="glyphicon glyphicon-search"></i></a>
          </form>
        </li>
        <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> @if(!empty($data['member']['logo']))<img src="{{ $data['member']['logo'] }}" alt="user-img" width="36" class="img-circle">@endif<b class="hidden-xs">{{ $data['member']['firstname'] }}</b> </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="javascript:void(0);"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
            <li><a href="javascript:void(0);"><i class="ti-wallet"></i> My Balance</a></li>
            <li><a href="javascript:void(0);"><i class="glyphicon glyphicon-envelope"></i> Inbox</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="javascript:void(0);"><i class="glyphicon glyphicon-wrench"></i> Account Setting</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/admin/logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
          </ul>
          <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
      </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
  </nav>
		@include('_include.admin.admin_leftmenu')

  <!-- Page Content -->
  <div id="page-wrapper" style="min-height: 860px;">
    <div class="container-fluid">
