@include('_include.admin_header'
	, [
		'title'			=> "Shop list",
		'id'			=> 'list'
	]
)

<ol class="bl">
	<li><a href="/admin/">管理画面</a></li>
	<li><em>&gt;</em></li>
	<li><em>Shop list</em></li>
</ol>
<h1 class="headline"><span>Shop list</span></h1>
	{!! Form::model($search_result['form_input'], ['class'=>'searchBox', 'method'=>'GET','role'=>'search']) !!}
		{!! Form::text('name', null, ["style"=>"width:180px;", "placeholder"=>"会社名"]) !!}
		{!! Form::select('status', \Config::get('constants.FORM_SEARCH_STATUS')) !!} <input type="submit" value=" 検索 ">
	{!! Form::close() !!}

<p>[<a href="/admin/company/add">新規作成</a>]</p>
<dl class="searchUtil">
	<dt><strong>{{ $search_result['list']->total() }}</strong>件の検索結果</dt>
	<dd>{{ $search_result['pagination']['fromRecord'] }}件～{{ $search_result['pagination']['toRecord'] }}件表示</dd>
</dl>
<table class="sheet">
	<thead>
		<tr>
			<th>状態</th>
			<th>ID</th>
			<th>会社名</th>
			<th>案件一覧</th>
			<th>ログイン</th>
			<th>編集</th>
		</tr>
	</thead>
	<tbody>
		@if ((isset($search_result['list'])) && ( $search_result['list']->total() > 0))
			@foreach ($search_result['list'] as $record)
			<tr>
				<td nowrap="nowrap"><span class="{{ (($record->status == 'Active') ? 'active' : 'inactive') }}">{{$record->status}}</span>
				</td>
				<td nowrap="nowrap">{{$record->id}}</td>
				<td>
					<a href="/admin/product?company={{$record->id}}"><strong>{{$record->name}}</strong> ( {{-- $record->active_detail --}}/{{-- $record->detail->count() --}} )</a>
					[ <a href="/admin/request_analyze?id={{$record->id}}">効果測定 </a> ]<br />
					{{$record->president}} / <a href="mailto:{{$record->login_mail}}">{{$record->login_mail}}</a>
					@if ($record->contact_tel) <strong class="red">{{ $record->contact_tel }}</strong>@endif
				</td>
				<td nowrap="nowrap">
				<a href="/admin/product?company={{$record->id}}">案件一覧</a> </td>
				<td nowrap="nowrap"><a href="/admin/auto_login?id={{$record->id}}&login_pass_hash={{-- $record->login_pass_hash --}}" class="blank">ログイン</a></td>
				<td nowrap="nowrap"><a href="/admin/company/{{ $record->id }}/edit">編集</a> </td>
			</tr>
			@endforeach
		@endif
	</tbody>
</table>

@if ((!isset($search_result['list'])) || ( $search_result['list']->total() == 0))
	データが存在していない。<br>
@else
	<a href="/admin/company/downloadCsv" class="excel">CSVダウンロード</a><br>
	{!! $search_result['list']->render() !!}
@endif


@include('_include.admin_footer')