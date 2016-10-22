@include('_include.admin.admin_header'
	, [
		'title' 		=> NULL,
		'id' 			=> NULL,
		'css' 			=> NULL,
		'js' 			=> NULL,
	]
)

      <!-- row -->
      <div class="row bg-title">
        <div class="col-lg-12">
          <h4 class="page-title">Welcome to {{ env('APP_NAME') }}</h4>
          <ol class="breadcrumb">
            <li class="active">Dashboard</li>
          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!--/ row -->

      <!-- row -->
      <div class="row">
        <div class="col-md-3 col-xs-12 col-sm-4">
          <div class="white-box">
            <h3>Active Shopping Carts</h3>
            <section>
              <header><i class="glyphicon glyphicon-time"></i> Currently Pending</header>

              <div class="list-group">
                <a href="/admin/cart/order" class="list-group-item">Orders <span class="badge">0</span></a>
                <a href="/admin/cart/return-exchange" class="list-group-item">Return/Exchanges <span class="badge">0</span></a>
                <a href="/admin/cart/abandoned-cart" class="list-group-item">Abandoned Carts <span class="badge">0</span></a>
                <a href="/admin/cart/out-of-stock-product" class="list-group-item">Out of Stock Products <span class="badge">0</span></a>
              </div>
            </section>
          </div>
        </div>


        <div class="col-md-3 col-xs-12 col-sm-4">
          <div class="white-box">
            <h3>To Do List</h3>
            <ul class="list-task list-group" data-role="tasklist">
              <li class="list-group-item" data-role="task">
                <div class="checkbox checkbox-info">
                  <input type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
                  <label for="inputSchedule"> <span>Schedule meeting</span> </label>
                </div>
              </li>
              <li class="list-group-item" data-role="task">
                <div class="checkbox checkbox-info">
                  <input type="checkbox" id="inputCall" name="inputCheckboxesCall">
                  <label for="inputCall"> <span>Call clients for follow-up</span> <span class="label label-danger">Today</span> </label>
                </div>
              </li>
              <li class="list-group-item" data-role="task">
                <div class="checkbox checkbox-info">
                  <input type="checkbox" id="inputBook" name="inputCheckboxesBook">
                  <label for="inputBook"> <span>Book flight for holiday</span> </label>
                </div>
              </li>
              <li class="list-group-item" data-role="task">
                <div class="checkbox checkbox-info">
                  <input type="checkbox" id="inputForward" name="inputCheckboxesForward">
                  <label for="inputForward"> <span>Forward important tasks</span> <span class="label label-warning">2 weeks</span> </label>
                </div>
              </li>
              <li class="list-group-item" data-role="task">
                <div class="checkbox checkbox-info">
                  <input type="checkbox" id="inputRecieve" name="inputCheckboxesRecieve">
                  <label for="inputRecieve"> <span>Recieve shipment</span> </label>
                </div>
              </li>
              <li class="list-group-item" data-role="task">
                <div class="checkbox checkbox-info">
                  <input type="checkbox" id="inputForward2" name="inputCheckboxesd">
                  <label for="inputForward2"> <span>Important tasks</span> <span class="label label-success">2 weeks</span> </label>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-3 col-xs-12 col-sm-4">
          <div class="white-box">
            <h3>You have 5 new messages</h3>
            <div class="message-center"> <a href="#">
              <div class="user-img"> <img src="/image/member/1/logo.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
              <div class="mail-contnet">
                <h5>Tester1</h5>
                <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
              </a> <a href="#">
              <div class="user-img"> <img src="/image/member/3/logo.png" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
              <div class="mail-contnet">
                <h5>Tester2</h5>
                <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
              </a> <a href="#">
              <div class="user-img"> <img src="{{ env('IMAGE_NO_FEMALE') }}" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
              <div class="mail-contnet">
                <h5>Tester3</h5>
                <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
              </a> <a href="#">
              <div class="user-img"> <img src="{{ env('IMAGE_NO_FEMALE') }}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
              <div class="mail-contnet">
                <h5>Tester4</h5>
                <span class="mail-desc">I love to do acting and dancing</span> <span class="time">9:08 AM</span> </div>
              </a> <a href="#" class="b-none">
              <div class="user-img"> <img src="/image/member/1/logo.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
              <div class="mail-contnet">
                <h5>Tester5</h5>
                <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
              </a> </div>
          </div>
        </div>
        <div class="col-md-3 col-xs-12 col-sm-4">
          <div class="white-box">
            <h3>Chat</h3>
            <div class="chat-box">
              <ul class="chat-list nicescroll" style="overflow: hidden;" tabindex="5005">
                <li>
                  <div class="chat-image"> <img alt="Female" src="/image/member/3/logo.png"> </div>
                  <div class="chat-body">
                    <div class="chat-text">
                      <h4>Tester6</h4>
                      <p> Hi, All! </p>
                      <b>10.00 am</b> </div>
                  </div>
                </li>
                <li class="odd">
                  <div class="chat-image"> <img alt="Female" src="{{ env('IMAGE_NO_FEMALE') }}"> </div>
                  <div class="chat-body">
                    <div class="chat-text">
                      <h4>Tester7</h4>
                      <p> Hi, How are you Tester6? ur next concert? </p>
                      <b>10.03 am</b> </div>
                  </div>
                </li>
                <li>
                  <div class="chat-image"> <img alt="Female" src="{{ env('IMAGE_NO_FEMALE') }}"> </div>
                  <div class="chat-body">
                    <div class="chat-text">
                      <h4>Tester8</h4>
                      <p> Hi, Tester6 and Tester7, </p>
                      <b>10.05 am</b> </div>
                  </div>
                </li>
              </ul>
              <div class="row">
                <div class="col-sm-12">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Say something">
                    <span class="input-group-btn">
                    <button class="btn btn-success" type="button">Send</button>
                    </span> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->

      <!-- row -->
      <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
          <div class="white-box">
            <h3><i class="glyphicon glyphicon-stats"></i> PRODUCTS AND SALES</h3>

<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#"><i class="glyphicon glyphicon-fire"></i> Recent orders</a></li>
  <li role="presentation"><a href="#">Best sellers</a></li>
  <li role="presentation"><a href="#">Most viewed</a></li>
  <li role="presentation"><a href="#">Top searches</a></li>
</ul>


<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">LAST 10 ORDERS</div>
  <!-- Table -->
  <table class="table">
    <thead>
      <tr>
        <td>Customer Name</td>
        <td>Products</td>
        <td>TotalTax excl.</td>
        <td>Date</td>
        <td>Status</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><a href="#">Ngọc Nam</a></td>
        <td>1</td>
        <td>354,000</td>
        <td>30/06/2016</td>
        <td>Awaiting check payment</td>
        <td><a class="btn btn-default" role="button"><i class="glyphicon glyphicon-search"></i></a></td>
      </tr>
    </tbody>
  </table>
</div>

          </div>


        </div>
      </div>
      <!-- /.row -->

@include('_include.admin.admin_footer')