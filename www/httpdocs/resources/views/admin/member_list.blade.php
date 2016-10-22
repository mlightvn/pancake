@include('_include.admin_header'
	, [
		'title'			=> "メンバー一覧",
		'id'			=> 'list'
	]
)

<ol class="bl">
	<li><a href="/admin/">管理画面</a></li>
	<li><em>&gt;</em></li>
	<li><em>メンバー一覧</em></li>
</ol>

<h1 class="headline"><span>メンバー一覧</span></h1>
	{!! Form::model($search_result['form_input'], ['class'=>'searchBox', 'method'=>'GET','role'=>'search']) !!}
		{!! Form::text('keyword', null, ["style"=>"width:180px;", "placeholder"=>"キーワード"]) !!}
		{!! Form::select('status', \Config::get('constants.FORM_SEARCH_STATUS')) !!} <input type="submit" value=" 検索 ">
	{!! Form::close() !!}

<dl class="searchUtil">
	<dt><strong>{{ $search_result['list']->total() }}</strong>件の検索結果</dt>
	<dd>{{ $search_result['pagination']['fromRecord'] }}件～{{ $search_result['pagination']['toRecord'] }}件表示</dd>
</dl>

<table class="sheet">
<thead>
	<tr>
		<th>ID</th>
		<th>情報</th>
		<th>性別</th>
		<th>誕生日</th>
		<th>状態</th>
	</tr>
</thead>
@if ((isset($search_result['list'])) && ( $search_result['list']->total() > 0))
	@foreach ($search_result['list'] as $member)
	<tr>
		<td>{{ $member->id }}</td>
		<td>{!! Html::link('/admin/member/' . $member->id . '/edit', $member->firstname . " ". $member->lastname) !!}<br>{!! Html::mailto($member->email) !!} / Phone: <span class="red">{{ $member->phone }}</span></td>
		<td>{{ $member->gender }}</td>
		<td>{{ $member->birthday }}</td>
		<td><span class="{{ (($member->status == 'Active') ? 'active' : 'inactive') }}">{{ $member->status }}</span></td>
	</tr>
	@endforeach
@endif
</table>


@if ((!isset($search_result['list'])) || ( $search_result['list']->total() == 0))
	データが存在していない。<br>
@else
	<a href="/admin/member/downloadCsv" class="excel">CSVダウンロード</a><br>
	{!! $search_result['list']->render() !!}
@endif


@include('_include.admin_footer')
