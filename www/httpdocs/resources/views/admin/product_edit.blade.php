@include('_include.admin_header'
	, [
		'title'			=> "Product " . $model->mode_label,
	]
)

<ol class="bl">
	<li><a href="/admin/">Admin</a></li>
	<li><em>&gt;</em></li>
	<li><a href="/admin/product">Product list</a></li>
	<li><em>&gt;</em></li>
	<li><em>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</em></li>
</ol>
<h1 class="headline"><span>{{ (isset($model->name) ? ($model->name . "の") : "") }}{{ $model->mode_label }}</span></h1>

@if ($model->id)
<ul class="tab clearfix">
	<li><a href="/admin/product/{{ $model->id }}/edit" class="now">情報編集</a></li>
	<li><a href="/admin/product/{{ $model->id }}/image/edit">画像編集</a></li>
</ul>
@endif


{!! Form::model($model, ['class'=>'form-inline']) !!}
{!! Form::hidden('id') !!}

@include('_include.error_message')

<table class="sheet">
<col width="160px">
<thead>
	<tr>
		<th colspan="2">商品情報 </th>
	</tr>
</thead>
	<tr>
		<th>{!! Form::label('company_id', '店') !!}</th>
		<td>{!! Form::select('company_id', $data['company_id']) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('category_id', 'カテゴリー') !!}</th>
		<td>{!! Form::select('category_id', $data['category_id']) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('name', '商品名・タイトル') !!}</th>
		<td>{!! Form::text('name', null, ['class'=>'formfield', "style"=>"width:100%;", 'placeholder'=>'商品名・タイトル']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('url', 'Original Url') !!}</th>
		<td>{!! Form::text('url', null, ['class'=>'formfield', "style"=>"width:100%;", 'placeholder'=>'Original Url']) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('market_price', 'Market price') !!}</th>
		<td>{!! Form::text('market_price', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'Market price']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('price', 'Price') !!}</th>
		<td>{!! Form::text('price', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'Price']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('quantity', 'Quantity') !!}</th>
		<td>{!! Form::text('quantity', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'Quantity']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('max_quantity', 'Max quantity') !!}</th>
		<td>{!! Form::text('max_quantity', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'Max quantity']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('status', '状態') !!}</th>
		<td>{!! Form::select('status', \Config::get('constants.STATUS')) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('short_description', 'Short Description') !!}</th>
		<td>{!! Form::textarea('short_description', null, ['placeholder'=>'Short Description']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('description', 'Description') !!}</th>
		<td>{!! Form::textarea('description', null, ['placeholder'=>'Description']) !!}</td>
	</tr>
</table>

<div class="submit">{!! Form::submit("登録する", ["name"=>"submit[done]", "class"=>"button"]) !!}</div>

{!! Form::close() !!}

@include('_include.admin_footer')