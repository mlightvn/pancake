@include('_include.user_w3.user_header',
	[
		'id'		=> 'site_list',

		'fb_title'			=> 'Thông tin đối tác',
		'fb_description'	=> 'Danh sách các đối tác của Rakuhin.com',
		'fb_img_url'		=> env('APP_URL') . env('FB_IMG_PATH'),
	]
)

	<div class="w3-container">
		<div class="w3-row">
			<div class="w3-col">
				<a href="/"><i class="fa fa-home"></i> Trang chủ</a>
				&gt;
				@if(count($data['company_list']) > 1)
					Danh sách đối tác
				@else
				<a href="/doi-tac">Danh sách đối tác</a>
				&gt;
					@if (count($data['company_list']) == 1)
					{{ $data['company_list'][0]->name }}
					@endif
				@endif
			</div>
		</div>
	</div>
	<br>

	<div class="w3-container w3-row">
		<div class="w3-col">
			<ul class="w3-navbar w3-bottombar w3-border-green">
				<li><a href="/search" class="w3-text-black">Tất cả</a></li>
				@if (isset($data['category_list']))
				@foreach ($data['category_list'] as $category)
				<li><a href="/category/{{ $category->slug }}" class="w3-text-black">{{ $category->name }}</a></li>
				@endforeach
				@endif
			</ul>
		</div>
	</div>

	<div class="w3-container">
		@if (isset($data['company_list']))
		@foreach ($data['company_list'] as $company)
		<br>
		<div class="w3-row w3-bottombar w3-border-green">
			<div class="w3-col s12 m12 l12">
				<div class="w3-row">
					<h2><a href="/doi-tac/{{ $company->slug }}">{{ $company->name }}</a></h2>
					<a href="/doi-tac/{{ $company->slug }}/san-pham">Danh sách sản phẩm</a>
					<p class="w3-leftbar w3-border-green"><h3>Giới thiệu</h3></p>
					<a href="/doi-tac/{{ $company->slug }}">
						<img src="{{ $company->logo }}" alt="{{ $company->name }}">
					</a>
					<br><br>
					{!! nl2br($company->description) !!}
					<br><br>
					<p class="w3-section w3-leftbar w3-border-green"><h3>Thông tin liên lạc</h3></p>
					<table class="w3-table w3-bordered w3-col l7">
						<tr>
							<td>Website</td>
							<td>
								<a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
							</td>
						</tr>
						<tr>
							<td>Điện thoại</td>
							<td> <a href="tel:{{ $company->contact_tel }}">{{ $company->contact_tel }}</a> / <a href="tel:{{ $company->contact_phone }}">{{ $company->contact_phone }}</a></td>
						</tr>
						<tr>
							<td>Tên tòa nhà</td>
							<td>{{ $company->building }}</td>
						</tr>
						<tr>
							<td>Địa chỉ</td>
							<td>{{ $company->address }}</td>
						</tr>
						<tr>
							<td>Quận</td>
							<td>{{ $company->district }}</td>
						</tr>
						<tr>
							<td>Thành phố</td>
							<td>{{ $company->city }}, Việt Nam</td>
						</tr>
					</table>
				</div>
				<br><br>
			</div>
		</div>
		@endforeach
		@else
		<br>
		Không có dữ liệu của đối tác.
		@endif

	</div>
	<!-- /.container -->
@include('_include.user_w3.user_footer')
