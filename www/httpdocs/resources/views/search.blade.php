@include('_include.user_w3.user_header',
	[
		'id'		=> 'search',
		'keyword'	=> ((isset($product_form) && isset($product_form->keyword)) ? $product_form->keyword : ""),

		'fb_title'			=> env('APP_TITLE'),
		'fb_description'	=> env('APP_DESCRIPTION'),
		'fb_img_url'		=> '/common/image/logo_rgreen.png',
	]
)

<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col">
			<a href="/"><i class="fa fa-home"></i> Homepage</a>
			&gt;
			@if ($product_form->company_slug)
			<a href="/site/{{ $product_form->company_slug }}/san-pham">{{ $product_form->company_name }}</a>
			&gt;
			@endif
			@if (isset($product_form->category))
			<a href="/search">Search</a>
			&gt;
			{{ $product_form->category->name }}
			@else
			<a>Search</a>
			@endif
		</div>
	</div>
</div>

<br>

<div class="w3-container w3-row">
	<div class="w3-col">
		<ul class="w3-navbar w3-bottombar w3-border-green">
			<li{!! (isset($product_form->category_slug) ? '' : ' class="w3-green"' ) !!}><a href="/search" class="w3-text-black">All</a></li>
			@foreach ($category_list as $category)
			<li{!! ((isset($product_form->category_slug) && ($product_form->category_slug == $category->slug)) ? ' class="w3-green"' : '' ) !!}><a href="/category/{{ $category->slug }}" class="{!! ((isset($product_form->category_slug) && ($product_form->category_slug == $category->slug)) ? 'w3-text-white' : 'w3-text-black' ) !!}">{{ $category->name }}</a></li>
			@endforeach
		</ul>
	</div>
</div>

<div class="w3-container w3-row">
	<div class="w3-col">
		<ul>
			@foreach ($product_list->sortBy as $label => $sortBy)
			<li><a href="{{ $sortBy }}">{{ $label }}</a></li>
			@endforeach
		</ul>
	</div>
</div>

<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col s12 m12 l12">
			<h3>
			@if ($product_form->company_slug)
			Products of {{ $product_form->company_name }}
			@else
			Search result
			@endif
			{{ $product_form->fromRecord }} ~ {{ $product_form->toRecord }} / {{ ((isset($product_list)) ? $product_list->total() : "0") }}
			</h3>
		</div>
	</div>
	<div class="w3-row-padding">
		@if ((!isset($product_list)) || ( count($product_list) == 0))
		<div class="w3-col s12 m12 l12">
			Product does not exist.
		</div>
		@else

		@foreach ($product_list as $product)
		<div class="w3-col s12 m4 l3 w3-white">
			<a href="/san-pham/{{ $product->id }}" class="w3-text-black"><div class="thumbnail w3-hover-shadow">
				<img class="lazy" style="position: absolute; width:50px;" data-original="/common/image/Down_Price_{{ $product->down_percent }}.png" alt="{{ $product->down_percent }}">
				<img class="lazy" data-original="{{ (($product->thumbnail) ? $product->thumbnail : env('IMAGE_NO_IMAGE')) }}" alt="{{ $product->name }}">
				<div class="caption">
					<h4>{{ $product->name }}</h4>
				</div>
				<div class="rate">
					<p><span class="w3-text-green w3-large"><b>{{ number_format($product->price) }}</b></span>@if (isset($product->market_price)) @if (isset($product->market_price) && ($product->market_price > 0))/ <del>{{ number_format($product->market_price) }}</del>@endif @endif {{ env('CURRENCY_SIGN') }}</p>
				</div>
			</div></a>
		</div>
		@endforeach
		@endif
	</div>
	<br>
	@include('_include.user_pagination', ['list'=>$product_list])
</div>


@include('_include.user_w3.user_footer')
