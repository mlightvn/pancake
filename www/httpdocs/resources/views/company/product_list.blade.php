@include('_include.company_header'
	, [
		'title'			=> "Product list",
		'id'			=> 'list'
	]
)

<ol class="bl">
	<li><a href="/company/">会社</a></li>
	<li><em>&gt;</em></li>
	<li><em>Product list</em></li>
</ol>

<h1 class="headline"><span>Product list</span></h1>
	{!! Form::model($product, ['class'=>'searchBox', 'method'=>'GET','role'=>'search']) !!}
		{!! Form::text('name', null, ["style"=>"width:180px;", "placeholder"=>"商品名"]) !!}
		{!! Form::select('status', [''=>'▼選択してください', 'Active'=>'Active', 'Disabled'=>'Disabled', 'Stop'=>'Stop']) !!} <input type="submit" value=" 検索 ">
	{!! Form::close() !!}

<p>[<a href="/company/product/add">新規作成</a>]</p>

<dl class="searchUtil">
	<dt><strong>{{ count($productlist) }}</strong>件の検索結果</dt>
	<dd>{{ $product->fromRecord }}件～{{ $product->toRecord }}件表示</dd>
</dl>

<div style="padding:10px;margin-bottom:5px;text-align:right;">

{[foreach from=$detail_status_count key=label item=count]}
{[a _detail_status=$label]}{[$label]} ({[$count]}){[/a]} 
{[/foreach]}

<br>


</div>
<table class="sheet">
<thead>	
	<tr>
		<th>状態</th>
		<th>商品名</th>
		<th>価格</th>
		<th style="text-align:center;">表示</th>
		<th style="text-align:center;">複製</th>
	</tr>
</thead>
@if ((isset($productlist)) && ( count($productlist) > 0))
	@foreach ($productlist as $product)
	<tr class="{{ ($product->status == "Active") ? " redBg" : "" }}">
		<td>{{ $product->status }}</td>
		<td>{!! Html::link('/company/product/' . $product->id . '/edit', $product->name) !!}</td>
		<td nowrap="nowrap"><b>￥{{ $product->price }}</b><br><del>￥{{ $product->market_price }}</del></td>
		<td class="center"><a href="#">表示</a></td>
		<td class="center"><img src="/common/image/icon/icon_copy.gif" height="15" alt="複製"></td>
	</tr>
	@endforeach
@endif
</table>


@if ((!isset($productlist)) || ( count($productlist) == 0))
	データが存在していない。<br>
@else
	<a href="/company/detail_csv_download?company_id={[$product->company_id]}" class="excel">現在の掲載情報をCSVダウンロード</a><br>
	{!! $productlist->render() !!}
@endif


@include('_include.company_footer')
