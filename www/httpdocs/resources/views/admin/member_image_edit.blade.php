@include('_include.admin_header'
	, [
		'title'			=> "管理者の" . $model->mode_label,
	]
)
<ol class="bl">
	<li><a href="/admin/">管理画面</a></li>
	<li><em>&gt;</em></li>
	<li><a href="/admin/member/list">管理者一覧</a></li>
	<li><em>&gt;</em></li>
	<li><em>画像編集</em></li>
</ol>

<h1 class="headline"><span>{{ $model->name }}画像編集</span></h1>

@if ($model->id)
<ul class="tab clearfix">
	<li><a href="/admin/member/{{ $model->id }}/edit">情報編集</a></li>
	<li><a href="/admin/member/{{ $model->id }}/image/edit" class="now">画像編集</a></li>
</ul>
@endif

@include('_include.error_message')

{!! Form::model($model, ['class'=>'form-inline', 'files'=>true]) !!}
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
			{!! Form::label('thumbnail', 'Thumbnail') !!}
		</th>
		<td>
			@if ($model->thumbnail)
				<span class="guide">{{ env('IMAGE_THUMBNAIL_WIDTH') }} x {{ env('IMAGE_THUMBNAIL_HEIGHT') }} ピクセル</span>
				<img src="{{ $model->thumbnail }}">
				<br><a href="/admin/member/{{ $model->id }}/image/delete/thumbnail" onclick="return confirm('削除してよろしいでしょうか。');" class="delete">この画像を削除する</a>
				<br>
			@endif
		</td>
	</tr>
	<tr>
		<th>
			{!! Form::label('logo', 'ロゴ') !!}
		</th>
		<td>
			@if ($model->logo)
				<span class="guide">{{ env('IMAGE_LOGO_WIDTH') }} x {{ env('IMAGE_LOGO_HEIGHT') }} ピクセル</span>
				<img src="{{ $model->logo }}">
				<br><a href="/admin/member/{{ $model->id }}/image/delete/logo" onclick="return confirm('削除してよろしいでしょうか。');" class="delete">この画像を削除する</a>
				<br>
			@endif
			<div class="file-upload btn btn-success">
				<span>Add files...</span>
				{!! Form::file('logo') !!}
			</div>
		</td>
	</tr>
</table>

<div class="submit">
	<input type="submit" class="button" name="submit[done]" value="　登録する　" />
</div>

{!! Form::close() !!}

@include('_include.admin_footer')