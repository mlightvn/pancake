@include('_include.company_header'
	, [
		'title'			=> "Shop " . $company->mode_label,
		'map'			=> '1',
		'zip_code'		=> $company->zip_code,
	]
)

<ol class="bl">
	<li><a href="/company/">会社</a></li>
	<li><em>&gt;</em></li>
	<li><em>{{ (isset($company->name) ? ($company->name . "の") : "") }}{{ $company->mode_label }}</em></li>
</ol>
<h1 class="headline"><span>{{ (isset($company->name) ? ($company->name . "の") : "") }}{{ $company->mode_label }}</span></h1>


@if ($company->id)
<ul class="tab clearfix">
	<li><a href="/company/edit" class="now">情報編集</a></li>
	<li><a href="/company/image/edit">画像編集</a></li>
</ul>
@endif


{[is_error]}

{{-- !! $error->first('login_mail', ':message') !! --}}

{[/is_error]}

{{--
https://github.com/illuminate/html

-- tutorial
https://laracasts.com/series/laravel-5-fundamentals/episodes/10

{!! Form::open(['class'=>'form-inline']) !!}
--}}

{!! Form::model($company, ['class'=>'form-inline']) !!}
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
		<th colspan="2">ログイン情報</th>
	</tr>
	</thead>

	<tr>
		<th style="width:150px;">{!! Form::label('login_mail', 'メール') !!}</th>
		<td>
		<span class="guide">メールアドレスを入力して下さい。エントリー通知先にメールアドレスが無い場合にはこちらに配信されます。</span>
		{!! Form::email('login_mail', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'email@example.com']) !!}
		<span class="example">email@example.com</span></td>
	</tr>
	<tr>
		<th>{!! Form::label('login_pass', 'パスワード') !!}</th>
		<td>
			<span class="guide">半角英数字で記入してください</span>
			{!! Form::input('password', 'login_password', $company->login_password, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'パスワード']) !!}<br>
			{!! Form::input('password', 'login_password_confirm', $company->login_password, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'確認パスワード']) !!}
		</td>
	</tr>

	<tr>
		<th>{!! Form::label('president', '連絡先') !!}</th>
		<td>{!! Form::text('president', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'Contact person']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('contact_tel', '電話番号') !!}</th>
		<td>
			{!! Form::text('contact_tel', null, ['class'=>'formfield', "style"=>"width:180px;"]) !!}
			{[is_not_confirm]}<span class="example">{[#EXAMPLE_PHONE#]}</span>{[/is_not_confirm]}
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('contact_phone', '携帯番号') !!}</th>
		<td>
			{!! Form::text('contact_phone', null, ['class'=>'formfield', "style"=>"width:180px;"]) !!}
			{[is_not_confirm]}<span class="example">{[#EXAMPLE_PHONE#]}</span>{[/is_not_confirm]}
		</td>
	</tr>

	<tr>
		<th>{!! Form::label('status', '状態') !!}</th>
		<td>{!! Form::select('status', ['Active'=>'Active', 'Disabled'=>'Disabled', 'Stop'=>'Stop']) !!}</td>
	</tr>

</table>

<table class="sheet">
<col width="150px">
	<thead>
		<tr>
			<th colspan="2">情報編集</th>
		</tr>
	</thead>
	<tr>
		<th style="width:150px;">{!! Form::label('name', '店名') !!}</th>
		<td>{!! Form::text('name', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'店名']) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('employee_number', '人数') !!}</th>
		<td>{!! Form::text('employee_number', null, ['class'=>'formfield', "style"=>"width:300px;"]) !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('description', '概要') !!}</th>
		<td>{!! Form::textarea('description') !!}</td>
	</tr>

	<tr>
		<th>{!! Form::label('zip_code', '郵便番号') !!}</th>
		<td>
		{[is_not_confirm]}<span class="guide">郵便番号をハイフン（-）ありでご記入下さい。</span>{[/is_not_confirm]}<br>
		{!! Form::text('zip_code', null, ['class'=>'formfield', "style"=>"width:70px;", 'placeholder'=>'000-0000']) !!}
		{!! Form::button('自動取得', ["onclick"=>"getAddrFromZip();return false;"]) !!}
		<span class="example">{[#EXAMPLE_ZIP#]}</span></td>
	</tr>
	<tr>
		<th>{!! Form::label('prefecture', '都道府県') !!}</th>
		<td>{!! Form::text('prefecture', null, ['class'=>'formfield', "style"=>"width:300px;"]) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('city', 'City') !!}</th>
		<td>
			{!! Form::text('city', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'東京都']) !!}
			<span class="example">{[#EXAMPLE_CITY#]}{[#EXAMPLE_ADDR#]}</span>
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('address', '住所') !!}</th>
		<td>
			{!! Form::text('address', null, ['class'=>'formfield', "style"=>"width:300px;", 'placeholder'=>'Chiyoda, Chiyoda, Tokyo 100-0001, Japan']) !!}
			<span class="example">{[#EXAMPLE_CITY#]}{[#EXAMPLE_ADDR#]}</span>
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('address', '住所') !!}</th>
		<td>
			{!! Form::text('building', null, ['class'=>'formfield', "style"=>"width:300px;"]) !!}
			<span class="example">{[#EXAMPLE_BLDG#]}</span>
		</td>
	</tr>
	<tr>
		<th>地図</th>
		<td>
			<div id="map" style="width:100%;height:400px;"></div>
		</td>
	</tr>

	<tr>
		<th>{!! Form::label('note', '備考') !!}</th>
		<td>{!! Form::textarea('note') !!}</td>
	</tr>

</table>

<div class="submit">{!! Form::submit("登録する", ["name"=>"submit[done]", "class"=>"button"]) !!}</div>

{!! Form::close() !!}

@include('_include.company_footer')