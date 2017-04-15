@include('_include.admin_header'
	, [
		'title'			=> "会社の" . $model->mode_label,
		'map'			=> '1',
		'zip_code'		=> $model->zip_code,
		'text_editor'	=> true,
	]
)
<div class="container-fluid">
	<div class="row">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/admin/">管理画面</a></li>
			<li class="breadcrumb-item"><a href="/admin/category">Shop list</a></li>
			<li class="breadcrumb-item active">{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</li>
		</ol>
	</div>
</div>

<h1><span>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</span></h1>

<br>

@if ($model->id)
<ul class="tab clearfix">
	<li><a href="/admin/company/{{ $model->id }}/edit" class="now">情報編集</a></li>
	<li><a href="/admin/company/{{ $model->id }}/image/edit">画像編集</a></li>
</ul>
@endif

{!! Form::model($model) !!}
{!! Form::hidden('id') !!}

@include('_include.error_message')

<table class="table table-bordered table-hover">
	<thead class="w3-dark-grey">
	<tr>
		<th colspan="2">ログイン情報</th>
	</tr>
	</thead>

	<tr>
		<th class="w3-light-grey">{!! Form::label('email', 'メール') !!}</th>
		<td>
		{!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'email@example.com']) !!}
		<span class="example">email@example.com</span></td>
	</tr>

	<tr>
		<th class="w3-light-grey">{!! Form::label('password', 'パスワード') !!}</th>
		<td>{!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) !!}</td>
	</tr>

	<tr>
		<th class="w3-light-grey">{!! Form::label('status', '状態') !!}</th>
		<td>{!! Form::select('status', \Config::get('constants.STATUS'), NULL, ['class'=>'form-control']) !!}</td>
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
		<td>{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'店名']) !!}</td>
	</tr>
	<tr>
		<th style="width:160px;">{!! Form::label('slug', 'Slug') !!}</th>
		<td>{!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'company']) !!}</td>
	</tr>

	<tr>
		<th class="w3-light-grey">{!! Form::label('website', 'Website') !!}</th>
		<td>{!! Form::text('website', null, ['class'=>'form-control', 'placeholder'=>'Website']) !!}</td>
	</tr>
	<tr>
		<th class="w3-light-grey">{!! Form::label('president', '連絡先') !!}</th>
		<td>{!! Form::text('president', null, ['class'=>'form-control', 'placeholder'=>'Contact person']) !!}</td>
	</tr>

	<tr>
		<th class="w3-light-grey">{!! Form::label('contact_tel', '電話番号') !!}</th>
		<td>
			{!! Form::text('contact_tel', null, ["style"=>"width:180px;"]) !!}
			<span class="example">{[#EXAMPLE_PHONE#]}</span>
		</td>
	</tr>
	<tr>
		<th class="w3-light-grey">{!! Form::label('contact_phone', '携帯番号') !!}</th>
		<td>
			{!! Form::text('contact_phone', null, ["style"=>"width:180px;"]) !!}
			<span class="example">{[#EXAMPLE_PHONE#]}</span>
		</td>
	</tr>

	<tr>
		<th class="w3-light-grey">{!! Form::label('employee_number', '人数') !!}</th>
		<td>{!! Form::text('employee_number', null, ['class'=>'form-control']) !!}</td>
	</tr>

	<tr>
		<th class="w3-light-grey">{!! Form::label('description', '概要') !!}</th>
		<td>{!! Form::textarea('description') !!}</td>
	</tr>
	<tr>
		<th class="w3-light-grey">{!! Form::label('note', '備考') !!}</th>
		<td>{!! Form::textarea('note') !!}</td>
	</tr>

</table>

		@include('_include.admin_address')

<div class="submit">{!! Form::submit("登録する", ["name"=>"submit[done]", "class"=>"button"]) !!}</div>

{!! Form::close() !!}

@include('_include.admin_footer')