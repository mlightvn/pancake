@include('_include.admin_header'
	, [
		'title'			=> "Product " . $product->mode_label,
	]
)
<ol class="bl">
	<li><a href="/admin/">Admin</a></li>
	<li><em>&gt;</em></li>
	<li><a href="/admin/company/product">Product list</a></li>
	<li><em>&gt;</em></li>
	<li><em>画像編集</em></li>
</ol>

<h1 class="headline"><span>{{ $product->name }}画像編集</span></h1>

@if ($product->id)
<ul class="tab clearfix">
	<li><a href="/admin/company/product/{{ $product->id }}/edit">情報編集</a></li>
	<li><a href="/admin/company/product/{{ $product->id }}/image/edit" class="now">画像編集</a></li>
</ul>
@endif

<div class="alert-warning">
	@foreach( $errors->all() as $error )
	<br> {{ $error }}
	@endforeach
</div>

{!! Form::model($product, ['class'=>'form-inline', 'files'=>true]) !!}
<p class="message">画像は自動的に正しいサイズにリサイズされます。</p>
<table class="sheet">
	<col width="160" />
	<thead>
		<tr>
			<th colspan="2">画像</th>
		</tr>
	</thead>
	<tr>
		<th>
			{!! Form::label('logo', 'ロゴ') !!}
		</th>
		<td><span class="guide">350 x 350 ピクセル</span>
			@if ($product->logo)
				<img src="{{ $product->logo }}">
				<br><a href="/admin/company/product/{{ $product->id }}/image/delete/logo" onclick="return confirm('削除してよろしいでしょうか。');" class="delete">この画像を削除する</a>
				<br>
			@endif
			{!! Form::file('logo') !!}
		</td>
	</tr>
</table>

<div class="submit">
	<input type="submit" class="button" name="submit[done]" value="　登録する　" />
</div>

{!! Form::close() !!}

@include('_include.admin_footer')