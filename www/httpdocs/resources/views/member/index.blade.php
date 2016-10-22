@include('_include.user_w3.user_header',
	[
		'id'		=> 'home'
	]
)


<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col m4 l3">
			<a href="/"><i class="fa fa-home"></i> Trang chủ</a>
			&gt;
			My Profile
		</div>
	</div>
</div>

<br>

<div class="w3-container row">
	<div class="w3-col m4 l6">
		<h2 class="w3-leftbar w3-border-green">My Profile</h2>
	</div>
</div>

<div class="w3-container row">
	<div class="w3-col m4 l6">

		<a class="w3-btn w3-green" href="/member/edit">Update</a>
		<a class="w3-btn w3-red" href="/member/leave">Leave</a>
	</div>
</div>

@include('_include.user_w3.user_footer')
