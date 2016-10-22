@include('_include.user_w3.user_header',
	[
		'id'				=> 'product_detail',
		'title'				=> $model->name,
		'description'		=> $model->short_description,
		'img_url'			=> env('APP_URL') . $model->thumbnail,

		'fb_title'			=> $model->name,
		'fb_description'	=> $model->short_description,
		'fb_img_url'		=> env('APP_URL') . $model->thumbnail,
	]
)

<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col">
			<a href="/"><i class="fa fa-home"></i> Trang chủ</a>
			&gt;
			<a href="/search">Tìm kiếm</a>
			&gt;
			{{ $model->name }}
		</div>
	</div>
</div>

<br>

<div class="w3-container row">
	<div class="w3-col">
		<ul class="w3-navbar w3-bottombar w3-border-green">
			<li><a href="/search" class="w3-text-black">Tất cả</a></li>
			@foreach ($category_list as $category)
			<li
			@if ($category->id == $model->category_id )
			 class="w3-green"
			@endif
			><a href="/category/{{ $category->slug }}"
			@if ($category->id == $model->category_id )
			 class="w3-text-white"
			@endif
			 class="w3-text-black"
			 >{{ $category->name }}</a></li>
			@endforeach
		</ul>
	</div>
</div>

<div class="w3-container row">
	<div class="w3-col">
		<h1>{{ $model->name }}</h1>
		@include('_include.fb_like')
	</div>
</div>

<div class="w3-container row">
	<div class="w3-col s12 m4 l4">
		<img class="lazy" style="position: absolute;" data-original="/common/image/Down_Price_{{ $model->down_percent }}.png" alt="{{ $model->down_percent }}">
		<img class="lazy" data-original="{{ (($model->logo) ? $model->logo : env('IMAGE_NO_IMAGE')) }}" alt="{{ $model->name }}" width="100%">
	</div>
	<div class="w3-col s12 m8 l8">
		@if (isset($model->short_description))
		<div class="w3-container row">
			{!! nl2br($model->short_description) !!}
		</div>
		<div class="w3-container row">
		<hr>
		</div>
		@endif
		<div class="w3-container row">
			@if (isset($model->market_price))
			Giá gốc: <del>{{ number_format($model->market_price) }}</del> <sup>VND</sup><br>
			@endif
			<span class="w3-xlarge w3-text-green">{{ number_format($model->price) }}</span> <sup>VND</sup><br>
			<a href="cart/{{ $model->id }}" class="w3-btn w3-green"> <i class="fa fa-check-circle-o"></i> Mua</a> <span class="w3-small w3-text-red">⇚Chức năng chưa hoàn thiện</span>
			<br><br>
			@include('_include.fb_like')
		</div>
	</div>
</div>
<br>
<div class="w3-container row">
	<div class="w3-col">
		<ul class="w3-navbar w3-bottombar w3-border-green">
			<li class="w3-green"><a class="w3-text-white">Thông tin sản phẩm</a></li>
		</ul>
	</div>
</div>

<div class="w3-container row">
	<div class="w3-col s12 m12 l12">
		<div class="w3-section">
		<a href="/doi-tac/{{ $model->company_slug }}"><img class="lazy" data-original="{{ $model->company_thumbnail }}" alt="{{ $model->company_name }}"></a>
		<br><br>
		{!! nl2br($model->description) !!}
		</div>
	</div>
</div>

<br>
<div class="w3-container row">
	<div class="w3-col s12 m12 l12">
		<ul class="w3-navbar w3-bottombar w3-border-green">
			<li class="w3-green"><a class="w3-text-white">Bình luận</a></li>
		</ul>
	</div>

	<div class="w3-col s12 m12 l12">
		@include('_include.fb_comment')
	</div>
</div>

@include('_include.user_w3.user_footer')
