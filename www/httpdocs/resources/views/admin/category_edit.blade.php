@include('_include.admin_header'
	, [
		'title'			=> "Category " . $model->mode_label,
	]
)

<ol class="bl">
	<li><a href="/admin/">Admin</a></li>
	<li><em>&gt;</em></li>
	<li><a href="/admin/category">Category list</a></li>
	<li><em>&gt;</em></li>
	<li><em>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</em></li>
</ol>
<h1 class="headline"><span>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</span></h1>

{!! Form::model($model, ['class'=>'form-inline']) !!}
{!! csrf_field() !!}
{!! Form::hidden('id') !!}

@include('_include.error_message')

<table class="sheet">
<col width="160px">
<thead>
	<tr>
		<th colspan="2">カテゴリー情報 </th>
	</tr>
</thead>
	<tr>
		<th>{!! Form::label('name', 'カテゴリー') !!}</th>
		<td>{!! Form::text('name', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'カテゴリー']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('parent_id', '親ID') !!}</th>
		<td>{!! Form::input('number', 'parent_id', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'親ID', 'min'=>'0', 'max'=>'999']) !!}
		<br>
		{{--
		{!! selectboxCategories($categorylist, 'id', 'name') !!}
		{!! Common::selectboxCategories($categorylist, 'id', 'name') !!}
		--}}
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('level', 'レベル') !!}</th>
		<td>{!! Form::input('number', 'level', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'レベル', 'min'=>'0', 'max'=>'99']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('slug', 'URL') !!}</th>
		<td>{!! Form::text('slug', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'URL']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('status', '状態') !!}</th>
		<td>{!! Form::select('status', \Config::get('constants.STATUS')) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('position', '順番') !!}</th>
		<td>{!! Form::input('number', 'position', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'順番', 'min'=>'0', 'max'=>'99']) !!}</td>
	</tr>
</table>

<div class="submit">{!! Form::submit("登録する", ["name"=>"submit[done]", "class"=>"button"]) !!}</div>

{!! Form::close() !!}

@include('_include.admin_footer')