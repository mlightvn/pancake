@include('_include.company_header'
	, [
		'title'			=> "Product " . $product->mode_label,
	]
)

<ol class="bl">
	<li><a href="/company/">会社</a></li>
	<li><em>&gt;</em></li>
	<li><a href="/company/product">Product list</a></li>
	<li><em>&gt;</em></li>
	<li><em>{{ (isset($product->name) ? ($product->name . "の") : "") }}{{ $product->mode_label }}</em></li>
</ol>
<h1 class="headline"><span>{{ (isset($product->name) ? ($product->name . "の") : "") }}{{ $product->mode_label }}</span></h1>

@if ($product->id)
<ul class="tab clearfix">
	<li><a href="/company/product/{{ $product->id }}/edit" class="now">情報編集</a></li>
	<li><a href="/company/product/{{ $product->id }}/image/edit">画像編集</a></li>
</ul>
@endif


{!! Form::model($product, ['class'=>'form-inline']) !!}
{!! Form::hidden('id') !!}

@if (isset($messages))
	<ul>
	@foreach ($messages->all() as $message)
		<li>{{ $message }}</li>
	@endforeach
	</ul>
@endif


<table class="sheet">
<col width="160px">
<thead>
	<tr>
		<th colspan="2">商品情報 </th>
	</tr>
</thead>
	<tr>
		<th>{!! Form::label('name', '商品名') !!}</th>
		<td>{!! Form::text('name', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'商品名']) !!}</td>
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
		<td>{!! Form::select('status', ['Active'=>'Active', 'Disabled'=>'Disabled', 'Stop'=>'Stop']) !!}</td>
	</tr>
</table>

<div class="submit">{!! Form::submit("登録する", ["name"=>"submit[done]", "class"=>"button"]) !!}</div>

{!! Form::close() !!}

@include('_include.company_footer')