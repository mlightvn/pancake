<style type="text/css">
#login-dp{
    min-width: 350px;
    padding: 14px 14px 0;
    overflow:hidden;
    background-color:rgba(255,255,255,.8);
}
#login-dp .help-block{
    font-size:12px
}
#login-dp .bottom{
    background-color:rgba(255,255,255,.8);
    border-top:1px solid #ddd;
    clear:both;
    padding:14px;
}
#login-dp .social-buttons{
    margin:12px 0
}
#login-dp .social-buttons a{
    width: 49%;
}
#login-dp .form-group {
    margin-bottom: 10px;
}
.btn-fb{
    color: #fff;
    background-color:#3b5998;
}
.btn-fb:hover{
    color: #fff;
    background-color:#496ebc
}
.btn-tw{
    color: #fff;
    background-color:#55acee;
}
.btn-tw:hover{
    color: #fff;
    background-color:#59b5fa;
}

.btn-gplus{
    color: #fff;
    background-color:rgb(221, 75, 57);
}
.btn-gplus:hover{
    color: #fff;
    background-color:rgb(255, 75, 57);
}

@media(max-width:768px){
    #login-dp{
        background-color: inherit;
        color: #fff;
    }
    #login-dp .bottom{
        background-color: inherit;
        border-top:0 none;
    }
}

</style>

<ul class="nav navbar-nav navbar-right">
  @if (Auth::guard('member')->check())
  <li class="dropdown"><a href="/member" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> {{ Auth::guard('member')->user()->firstname }} <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="/member"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> Profile</a>
      <li><a href="/member/edit"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> Profile edit</a>
      </li>
      <li><a href="/member/logout"><i class="glyphicon glyphicon-log-out" aria-hidden="true"></i> Logout</a>
      </li>
    </ul>
  </li>
  <li><a href="/member/cart"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
  @else
  <!-- <li><p class="navbar-text">Already have an account?</p></li> -->
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> <b>Login</b> <span class="caret"></span></a>
    <ul id="login-dp" class="dropdown-menu">
      <li>
         <div class="row">
            <div class="col-md-12">
              Login via
              <div class="social-buttons">
                <a href="/member/login/redirect" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
                <a href="#" class="btn btn-gplus"><i class="fa fa-google-plus"></i> Google Plus</a>
              </div>
                or
              <form class="form" role="form" method="post" action="/member/login" accept-charset="UTF-8" id="login-nav">
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
                  <label><input type="checkbox"> keep me logged-in</label>
                </div>
              </form>
            </div>
            <div class="bottom text-center">
              New here ? <a href="/member/signup"><b>Join Us</b></a>
            </div>
         </div>
      </li>
    </ul>
  </li>
  @endif
</ul>
