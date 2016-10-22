@include('_include.admin_header'
	, [
		'title'			=> "メンバーの" . $model->mode_label,
		'map'			=> '1',
		'zip_code'		=> $model->zip_code,
		'text_editor'	=> true,
	]
)

<ol class="bl">
	<li><a href="/admin">管理画面</a></li>
	<li><em>&gt;</em></li>
	<li><a href="/admin/member">メンバー一覧</a></li>
	<li><em>&gt;</em></li>
	<li><em>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</em></li>
</ol>
<h1 class="headline"><span>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</span></h1>

@if ($model->id)
<ul class="tab clearfix">
	<li><a href="/admin/member/{{ $model->id }}/edit" class="now">情報編集</a></li>
	<li><a href="/admin/member/{{ $model->id }}/image/edit">画像確認</a></li>
</ul>
@endif

{!! Form::model($model, ['class'=>'form-inline']) !!}
{!! Form::hidden('id') !!}

@include('_include.error_message')

<table class="sheet">
<col width="160px">
<thead>
	<tr>
		<th colspan="2">ログイン情報</th>
	</tr>
</thead>
	<tr>
		<th>ログインメール</th>
		<td>{{ $model->email }}</td>
	</tr>
	<tr>
		<th>パスワード</th>
		<td>{{ $model->password }}</td>
	</tr>
	<tr>
		<th>状態</th>
		<td>{!! Form::select('status', \Config::get('constants.STATUS')) !!}</td>
	</tr>
</table>

<table class="sheet">
<col width="160px">
	<thead>
		<tr>
			<th colspan="2">情報編集</th>
		</tr>
	</thead>
	<tr>
		<th>氏名</th>
		<td>{{ $model->firstname }} {{ $model->lastname }}</td>
	</tr>
	<tr>
		<th>携帯電話</th>
		<td>{{ $model->phone }}</td>
	</tr>
	<tr>
		<th>性別</th>
		<td>{{ $model->gender }}</td>
	</tr>
	<tr>
		<th>誕生日</th>
		<td>{{ $model->birthday }}</td>
	</tr>
	<tr>
		<th>Short description</th>
		<td>{{ $model->short_description }}</td>
	</tr>
	<tr>
		<th>概要</th>
		<td>{{ $model->description }}</td>
	</tr>
</table>

<table class="sheet">
<col width="160px">
	<thead>
		<tr>
			<th colspan="2">住所</th>
		</tr>
	</thead>

	<tr>
		<th>郵便番号</th>
		<td>{{ $model->zip_code }}</td>
	</tr>
	<tr>
		<th>都道府県</th>
		<td>{{ $model->prefecture }}</td>
	</tr>
	<tr>
		<th>City</th>
		<td>{{ $model->city }}</td>
	</tr>
	<tr>
		<th>住所</th>
		<td>{{ $model->address }}</td>
	</tr>
	<tr>
		<th>ビル名</th>
		<td>{{ $model->building }}</td>
	</tr>
	<tr>
		<th>地図</th>
		<td>
			<div id="map" style="width:100%;height:400px;"></div>
		</td>
	</tr>

</table>

<div class="submit">{!! Form::submit("登録する", ["name"=>"submit[done]", "class"=>"button"]) !!}</div>

{!! Form::close() !!}

@include('_include.admin_footer')