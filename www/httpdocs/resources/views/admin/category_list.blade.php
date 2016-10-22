@include('_include.admin_header'
	, [
		'title'			=> "Category list",
		'id'			=> 'list'
	]
)

<ol class="bl">
	<li><a href="/admin/">Admin</a></li>
	<li><em>&gt;</em></li>
	<li><em>Category list</em></li>
</ol>

<h1 class="headline"><span>Category list</span></h1>
	{!! Form::model($search_result['form_input'], ['class'=>'searchBox', 'method'=>'GET','role'=>'search']) !!}
		{!! Form::text('name', null, ["style"=>"width:180px;", "placeholder"=>"カテゴリー"]) !!}
		{!! Form::select('status', [''=>'▼状態を選択してください', 'Active'=>'Active', 'Inactive'=>'Inactive']) !!} <input type="submit" value=" 検索 ">
	{!! Form::close() !!}

<p>[<a href="/admin/category/add">新規作成</a>]</p>

<dl class="searchUtil">
	<dt><strong>{{ $search_result['list']->total() }}</strong>件の検索結果</dt>
	<dd>{{ $search_result['pagination']['fromRecord'] }}件～{{ $search_result['pagination']['toRecord'] }}件表示</dd>
</dl>

<br>

<table class="sheet">
<thead>
	<tr>
		<th>順番</th>
		<th>ID</th>
		<th>親ID</th>
		<th>レベル</th>
		<th>カテゴリーURL</th>
		<th>カテゴリー</th>
		<th>状態</th>
	</tr>
</thead>
@if ((isset($search_result['list'])) && ( $search_result['list']->total() > 0))
	@foreach ($search_result['list'] as $record)
	<tr>
		<td>{{ $record->position }}</td>
		<td>{{ $record->id }}</td>
		<td>{{ $record->parent_id }} : {{ ($record->id == $record->parent_id) ? '-' : $record->parent_name }}</td>
		<td>{{ $record->level }}</td>
		<td>{{ $record->slug }}</td>
		<td>{!! Html::link('/admin/category/' . $record->id . '/edit', $record->name) !!}</td>
		<td><span class="{{ (($record->status == 'Active') ? 'active' : 'inactive') }}">{{ $record->status }}</span></td>
	</tr>
	@endforeach
@endif
</table>

@if ((!isset($search_result['list'])) || ( $search_result['list']->total() == 0))
	データが存在していない。<br>
@else
	<a href="/admin/category/downloadCsv" class="excel">CSVダウンロード</a><br>
	{!! $search_result['list']->render() !!}
@endif


@include('_include.admin_footer')
