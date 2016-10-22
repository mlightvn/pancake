<script src="/common/js/jquery.lazyload.min.js"></script>
<script>
$(function() {
    $("img.lazy").lazyload({
	    effect : "fadeIn"
	});
});
</script>

</div> {{-- <<END>>container --}}

		<br><br>
		<div class="w3-container w3-border-top">
			<div class="w3-row">
				<div class="w3-col m4 l3">
					<h4>Giới thiệu</h4>
					<ul>
						<li><a href="/lien-lac">Liên lạc</a></li>
					</ul>
				</div>
				<div class="w3-col m4 l3">
					<h4>Đối tác</h4>
					<ul>
						<li><a target="_blank" href="//www.abc.vn">ABC</a></li>
						<li><a target="_blank" href="//def.com">DEF</a></li>
						<li><a target="_blank" href="//www.gffgf.vn">gffgf.vn</a></li>
					</ul>
				</div>
				<div class="w3-col m4 l3">
					<div class="fb-page" data-href="https://www.facebook.com/japanese.job/?fref=ts" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-hide-cover="true"><blockquote cite="https://www.facebook.com/japanese.job/?fref=ts" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/japanese.job/?fref=ts">ベトナムでの日本語関係の仕事の募集</a></blockquote></div>

				</div>

				<div class="w3-col m4 l3">
					<h4>Payment acception</h4>
					<ul>
						<li><img src="#" alt="Paypal"></li>
						<li><img src="#" alt="Visa"></li>
						<li><img src="#" alt="MasterCard"></li>
					</ul>
				</div>
			</div>
		</div>

		<footer class="w3-center w3-green">
		<br>
			<form class="form-inline">
				Đăng ký nhận tin:
				<input type="email" class="form-control" size="50" placeholder="Email Address">
				<button class="w3-text-black">Đăng ký</button>
			</form>
			<p>Copyright © 2016 {{ env('APP_NAME') }} All right reserved.</p>
		</footer>

	</body>
</html>