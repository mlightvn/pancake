@include('_include.company_header'
	, [
		'title'			=> "Shop " . $company->mode_label,
	]
)
<ol class="bl">
	<li><a href="/company/">会社</a></li>
	<li><em>&gt;</em></li>
	<li><em>画像編集</em></li>
</ol>

<h1 class="headline"><span>{{ $company->name }}画像編集</span></h1>

@if (isset($company->id))
<ul class="tab clearfix">
	<li><a href="/company/edit">情報編集</a></li>
	<li><a href="/company/image/edit" class="now">画像編集</a></li>
</ul>
@endif

<div class="alert-warning">
	@foreach( $errors->all() as $error )
	<br> {{ $error }}
	@endforeach
</div>

{!! Form::model($company, ['class'=>'form-inline', 'files'=>true]) !!}
<p class="message">画像は自動的に正しいサイズにリサイズされます。</p>
<table class="sheet">
	<col width="160">
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
			@if ($company->logo)
				<img src="{{ $company->logo }}">
				<br><a href="/company/image/delete" onclick="return confirm('削除してよろしいでしょうか。');" class="delete">この画像を削除する</a>
				<br>
			@endif
			{!! Form::file('logo') !!}
		</td>
	</tr>
</table>

<div class="submit">
	<input type="submit" class="button" value="　登録する　">
</div>

{!! Form::close() !!}

@include('_include.company_footer')