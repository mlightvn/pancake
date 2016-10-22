@include('_include.admin_header'
	, [
		'title'			=> "Product list",
		'id'			=> 'list'
	]
)

<ol class="bl">
	<li><a href="/admin/">Admin</a></li>
	<li><em>&gt;</em></li>
	<li><em>Product list</em></li>
</ol>

<h1 class="headline"><span>Product list</span></h1>
	{!! Form::model($search_result['form_input'], ['class'=>'searchBox', 'method'=>'GET','role'=>'search']) !!}
	{{--
		{!! Form::select('company_id', null) !!}
	--}}
		{!! Form::text('keyword', null, ["style"=>"width:180px;", "placeholder"=>"Keyword..."]) !!}
		{!! Form::select('status', \Config::get('constants.FORM_SEARCH_STATUS')) !!} <input type="submit" value=" 検索 ">
	{!! Form::close() !!}

<p>[<a href="/admin/product/add{{ ((isset($search_result['form_input']['company_id'])) ? ('?company_id=' . $search_result['form_input']['company_id']) : "" ) }}">新規作成</a>]</p>

<dl class="searchUtil">
	<dt><strong>{{ $search_result['list']->total() }}</strong>件の検索結果</dt>
	<dd>{{ $search_result['pagination']['fromRecord'] }}件～{{ $search_result['pagination']['toRecord'] }}件表示</dd>
</dl>

@if (isset($company->id))
	<div style="padding:10px;margin-bottom:5px;background-color:#CCC;">
	現在の{{ $company->name }}のステータスは{{ $company->status }}です。
	</div>
@endif

<table class="sheet">
<thead>
	<tr>
		<th>状態</th>
		<th>商品名</th>
		<th>価格</th>
		<th style="text-align:center;" nowrap="nowrap">表示</th>
		{{--
		<th style="text-align:center;" nowrap="nowrap">複製</th>
		--}}
	</tr>
</thead>
	@if ((isset($search_result['list'])) && ( $search_result['list']->total() > 0))
		@foreach ($search_result['list'] as $record)
	<tr>
		<td nowrap="nowrap"><span class="{{ (($record->status == 'Active') ? 'active' : 'inactive') }}">{{ $record->status }}</span></td>
		<td>{!! Html::link('/admin/product/' . $record->id . '/edit', $record->name) !!}</td>
		<td nowrap="nowrap" class="right"><b>￥{{ number_format($record->price) }}</b><br><del>￥{{ number_format($record->market_price) }}</del></td>
		<td class="center"><a href="/san-pham/{{ $record->id }}">表示</a></td>
		{{--
		<td class="center"><img src="/common/image/icon/icon_copy.gif" height="15" alt="複製"></td>
		--}}
	</tr>
	@endforeach
@endif
</table>


@if ((!isset($search_result['list'])) || ( $search_result['list']->total() == 0))
	データが存在していない。<br>
@else
	<a href="/admin/product/downloadCsv" class="excel">CSVダウンロード</a><br>
	{!! $search_result['list']->render() !!}
@endif

@include('_include.admin_footer')
