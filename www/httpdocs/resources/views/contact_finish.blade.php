@include('_include.user_w3.user_header',
	[
		'id'		=> 'contact_finish',
	]
)

<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col">
			<a href="/"><i class="fa fa-home"></i> Trang chủ</a>
			&gt;
			Liên lạc hoàn tất
		</div>
	</div>
</div>
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="well">
				<strong>Well done!</strong><br>
				You successfully sent message to us.<br>
				Cám ơn bạn đã gửi tin nhắn cho chúng tôi.<br>
				<br>
				<a href="/lien-lac" class="alert-link">Quay về Liên lạc</a>
			</div>
		</div>
	</div>
</div>

@include('_include.user_w3.user_footer')
