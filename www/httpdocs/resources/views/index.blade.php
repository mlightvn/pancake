@include('_include.user_w3.user_header',
	[
		'id'				=> 'home',

		'fb_title'			=> env('APP_TITLE'),
		'fb_description'	=> env('APP_DESCRIPTION'),
		'fb_img_url'		=> env('APP_URL') . env('FB_IMG_PATH'),
	]
)

	<!-- Page Content -->
	@if (empty($data['is_mobile']))
	<div class="w3-container">
		<div class="w3-row">
			<div class="w3-col s12 m4 l3">
				<ul class="w3-ul w3-hoverable">
					<a href="/search"><li>All</li></a>
					@foreach ($data['category_list'] as $category)
					<a href="/category/{{ ($category->slug) ? $category->slug : $category->id }}"><li>{{ $category->name }}</li></a>
					@endforeach
				</ul>
				<br>
				<img src="/common/image/Baby-Bear.gif" alt="Baby-Bear">
			</div>

			<div class="w3-col s12 m8 l9">
				@include('_include.user_slide')
			</div>
		</div>
	</div>
	<!-- /.container -->
	@endif

	<br>
	@include('_include.user_companies_thumbnail_slide')
	<br>

	@if (!empty($data['is_mobile']))
	<br>
	<div class="w3-container">
		<div class="w3-row">
			<div class="w3-col s12 m12 l12">
				<header class="w3-navbar w3-leftbar w3-border-green">
					<h2><a class="w3-text-black">Khuyến mãi</a></h2>
				</header>
			</div>
		</div>

		<div class="w3-row-padding">
			<div class="w3-col s12 m5 l5">
				<a href="http://ho.lazada.vn/SHINLV" target="_blank">
					<div class="thumbnail w3-hover-shadow">
					<p class="w3-small w3-text-green">※Click vào link thì bạn sẽ tới trang của Lazada.</p>
					<img src="/image/promotion/lazada/20161011.women_day.png" alt="Lazada: Đặc quyền phái đẹp - Sẵn sàng tỏa sáng" width="100%">
					</div>
				</a>
			</div>
			<div class="w3-col s12 m7 l7">
			@if(date("Ymd") <= "20161023")
				<a href="http://zanado.com/20-10-ton-vinh-phai-dep-viet-2016.html?aff=rakuhin" target="_blank">
					<div class="thumbnail w3-hover-shadow">
					<p class="w3-small w3-text-green">※Click vào link thì bạn sẽ tới trang của Zanado.</p>
					<img src="http://a4vn.com/media/landing/20161015/banner_full.jpg" alt="Zanado: Shopping thả ga – Nhận quà vô giá" width="100%">
					</div>
				</a>
			@else
				<a href="http://www.nguyenkim.com/khuyen-mai-chuong-trinh-le-hoi-nhat-ban.html?position=banner-scroll-le-hoi-nhat-ban" target="_blank">
					<div class="thumbnail w3-hover-shadow">
					<p class="w3-small w3-text-green">※Click vào link thì bạn sẽ tới trang của Nguyễn Kim.</p>
					<img src="https://static.nguyenkimmall.com/images/companies/_1/Design/banner/img-thang-nhat-ban-1.png" alt="Nguyễn Kim: KHUYẾN MÃI CHƯƠNG TRÌNH LỄ HỘI NHẬT BẢN" width="100%">
					</div>
				</a>
			@endif
				<br><br>
			</div>
		</div>
	</div>
	<br>
	@endif

	<div class="w3-container">
		@foreach ($data['category_list'] as $category)
		@if (count($category->product_list) > 0)
		<br>
		<div class="w3-row">
			<div class="w3-col s12 m12 l12">
				<header class="w3-navbar w3-leftbar w3-border-green">
					<h2><a href="/category/{{ $category->slug }}" class="w3-text-black">{{ $category->name }}</a></h2>
				</header>
				<a href="/category/{{ $category->slug }}?sort_by=gia_tang">Giá tăng</a>&nbsp;
				<a href="/category/{{ $category->slug }}?sort_by=gia_giam">Giá giảm</a>&nbsp;
				<a href="/category/{{ $category->slug }}?sort_by=moi_nhat">Hàng mới</a>&nbsp;
			</div>
		</div>

		<div class="w3-row-padding">
			@foreach ($category->product_list as $product)
			<div class="w3-col s12 m4 l3 w3-white">
				<a href="/san-pham/{{ $product->id }}" class="w3-text-black"><div class="thumbnail w3-hover-shadow">
				<img class="lazy" style="position: absolute; width:50px;" data-original="/common/image/Down_Price_{{ $product->down_percent }}.png" alt="{{ $product->down_percent }}">
					<img class="lazy" data-original="{{ (($product->thumbnail) ? $product->thumbnail : '/common/image/common/no_image.png') }}" alt="{{ $product->name }}">
					<div class="caption">
						<h4>{{ $product->name }}</h4>
					</div>
					<div class="rate">
						<p><span class="w3-text-green w3-large"><b>{{ number_format($product->price) }}</b></span>@if (($product->market_price !== NULL) && ($product->market_price > 0)) / <del>{{ number_format($product->market_price) }}</del>@endif {{ env('CURRENCY_SIGN') }}</p>
					</div>
				</div></a>
			</div>
			@endforeach
		</div>

		<div class="w3-row">
			<div class="w3-col s12 m12 l12">
				<div class="w3-display-container">
					<div class="w3-display-topright">
						<a class="w3-btn w3-green" href="/category/{{ $category->slug }}">▶ Xem thêm</a>
					</div>
				</div>
			</div>
		</div>
		<br>
		@endif
		@endforeach

	</div>
	<!-- /.container -->
@include('_include.user_w3.user_footer')
