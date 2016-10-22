@include('_include.admin_header'
	, [
		'title'			=> "会社の" . $model->mode_label,
		'map'			=> '1',
		'zip_code'		=> $model->zip_code,
		'text_editor'	=> true,
	]
)

<ol class="bl">
	<li><a href="/admin/">管理画面</a></li>
	<li><em>&gt;</em></li>
	<li><a href="/admin/company/list">会社一覧</a></li>
	<li><em>&gt;</em></li>
	<li><em>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</em></li>
</ol>
<h1 class="headline"><span>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</span></h1>

@if ($model->id)
<ul class="tab clearfix">
	<li><a href="/admin/company/{{ $model->id }}/edit" class="now">情報編集</a></li>
	<li><a href="/admin/company/{{ $model->id }}/image/edit">画像編集</a></li>
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
		<th style="width:160px;">{!! Form::label('email', 'メール') !!}</th>
		<td>
		<span class="guide">メールアドレスを入力して下さい。エントリー通知先にメールアドレスが無い場合にはこちらに配信されます。</span>
		{!! Form::email('email', null, ["style"=>"width:300px;", 'placeholder'=>'email@example.com']) !!}
		<span class="example">email@example.com</span></td>
	</tr>

	<tr>
		<th>{!! Form::label('password', 'パスワード') !!}</th>
		<td>{!! Form::password('password', null, ["style"=>"width:300px;", 'placeholder'=>'Password']) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('status', '状態') !!}</th>
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
		<th style="width:160px;">{!! Form::label('name', '店名') !!}</th>
		<td>{!! Form::text('name', null, ["style"=>"width:300px;", 'placeholder'=>'店名']) !!}</td>
	</tr>
	<tr>
		<th style="width:160px;">{!! Form::label('slug', 'Slug') !!}</th>
		<td>{!! Form::text('slug', null, ["style"=>"width:300px;", 'placeholder'=>'company']) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('website', 'Website') !!}</th>
		<td>{!! Form::text('website', null, ["style"=>"width:300px;", 'placeholder'=>'Website']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('president', '連絡先') !!}</th>
		<td>{!! Form::text('president', null, ["style"=>"width:300px;", 'placeholder'=>'Contact person']) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('contact_tel', '電話番号') !!}</th>
		<td>
			{!! Form::text('contact_tel', null, ["style"=>"width:180px;"]) !!}
			<span class="example">{[#EXAMPLE_PHONE#]}</span>
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('contact_phone', '携帯番号') !!}</th>
		<td>
			{!! Form::text('contact_phone', null, ["style"=>"width:180px;"]) !!}
			<span class="example">{[#EXAMPLE_PHONE#]}</span>
		</td>
	</tr>

	<tr>
		<th>{!! Form::label('employee_number', '人数') !!}</th>
		<td>{!! Form::text('employee_number', null, ["style"=>"width:300px;"]) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('description', '概要') !!}</th>
		<td>{!! Form::textarea('description') !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('note', '備考') !!}</th>
		<td>{!! Form::textarea('note') !!}</td>
	</tr>

</table>

		@include('_include.admin_address')

<div class="submit">{!! Form::submit("登録する", ["name"=>"submit[done]", "class"=>"button"]) !!}</div>

{!! Form::close() !!}

@include('_include.admin_footer')