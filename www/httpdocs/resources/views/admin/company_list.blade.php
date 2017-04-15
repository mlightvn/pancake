@include('_include.admin_header'
	, [
		'title'			=> "Shop list",
		'id'			=> 'list'
	]
)
<div class="container-fluid">
	<div class="row">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/admin/"><span class="glyphicon glyphicon-king"></span> 管理画面</a></li>
			<li class="breadcrumb-item"><a href="/admin/company">Shop list</a></li>
			<li class="breadcrumb-item"><a href="/admin/company/add">Add new</a></li>
		</ol>
	</div>
</div>

<h1><span>Shop list</span></h1>
{!! Form::model($search_result['form_input'], ['class'=>'form-inline', 'method'=>'GET','role'=>'search']) !!}
	<div class="form-group">
		{!! Form::text('name', null, ["placeholder"=>"会社名", "class"=>"form-control"]) !!}
		{!! Form::select('status', \Config::get('constants.FORM_SEARCH_STATUS'), NULL, ["class"=>"form-control"]) !!}
		<input type="submit" value=" 検索 " class="btn btn-success">
	</div>
{!! Form::close() !!}
<br>
<p><a href="/admin/company/add" class="btn btn-success">新規作成</a></p>
<dl class="searchUtil">
	<dt><strong>{{ $search_result['list']->total() }}</strong>件の検索結果</dt>
	<dd>{{ $search_result['pagination']['fromRecord'] }}件～{{ $search_result['pagination']['toRecord'] }}件表示</dd>
</dl>
<table class="table table-bordered table-hover">
	<thead class="w3-dark-grey">
		<tr>
			<th>状態</th>
			<th>ID</th>
			<th>会社名</th>
			<th>Function</th>
		</tr>
	</thead>
	<tbody>
		@if ((isset($search_result['list'])) && ( $search_result['list']->total() > 0))
			@foreach ($search_result['list'] as $record)
			<tr class="{{ (($record->status == 'Active') ? '' : 'w3-light-grey') }}">
				<td nowrap="nowrap">{{$record->status}}</td>
				<td nowrap="nowrap">{{$record->id}}</td>
				<td>
					<span class="glyphicon glyphicon-edit"></span><a href="/admin/company/{{$record->id}}/edit"><strong>{{$record->name}}</strong></a>
					<br />
					{{$record->president}} / <a href="mailto:{{$record->login_mail}}">{{$record->login_mail}}</a>
					<br>
					@if ($record->contact_tel) <strong class="red">{{ $record->contact_tel }}</strong>@endif
				</td>
				<td>
					<a href="/admin/product?company={{$record->id}}"><span class="glyphicon glyphicon-list"></span></a> | <a class="blank"><span class="glyphicon glyphicon-log-in"></span></a> | <a href="/admin/company/{{ $record->id }}/edit"><span class="glyphicon glyphicon-edit"></span></a>
				</td>
			</tr>
			@endforeach
		@endif
	</tbody>
</table>

@if ((!isset($search_result['list'])) || ( $search_result['list']->total() == 0))
	データが存在していない。<br>
@else
	<a href="/admin/company/downloadCsv" class="btn btn-success">CSVダウンロード</a><br>
	{!! $search_result['list']->render() !!}
@endif


@include('_include.admin_footer')