@include('_include.user_w3.user_header'
	, [
		'title'			=> "メンバーの" . $model->mode_label,
		'map'			=> '1',
		'zip_code'		=> $model->zip_code,
		'text_editor'	=> true,
	]
)

<div class="w3-container">
	<div class="w3-row">
		<a href="/"><i class="fa fa-home"></i> Trang chủ</a>
		&gt;
		<a href="/member">My Profile</a>
		&gt;
		Edit
	</div>
</div>

<div class="w3-container">
	<div class="w3-row">
		<h1 class="w3-leftbar w3-border-green">Profile edit</h1>
	</div>
</div>

<div class="w3-container">
	<div class="w3-row">
		<ul class="w3-navbar w3-bottombar w3-border-green">
			<li class="w3-green"><a href="/member/edit">情報編集</a></li>
			<li><a href="/member/image/edit">画像編集</a></li>
		</ul>
	</div>
</div>


<div class="w3-container w3-responsive">

	{!! Form::model($model, ['class'=>'col s9']) !!}
	{!! Form::hidden('id') !!}

	@include('_include.error_message')

	<table class="w3-table w3-hoverable">
	<thead class="w3-bottombar w3-border-green">
		<tr>
			<th colspan="2">
				<h3>Login</h3>
			</th>
		</tr>
	</thead>
		<tr>
			<th>{!! Form::label('email', 'ログインメール', ['class'=>'w3-validate']) !!}</th>
			<td>{!! Form::input('email', 'email', null, ['placeholder'=>\Config::get('constants.EXAMPLE_EMAIL'), 'required'=>'required', 'class'=>'w3-input']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('password', 'パスワード') !!}</th>
			<td><span>+ Alphabet and number letters, at least 8 characters<br>
				+ Not input: no change password<br></span>
				{!! Form::password('password', null, ['placeholder'=>'パスワード', 'min'=>'8', 'max'=>'100', 'class'=>'w3-input']) !!}<br>
				{!! Form::password('password_confirmation', null, ['placeholder'=>'確認パスワード', 'min'=>'8', 'max'=>'100', 'class'=>'w3-input']) !!}
			</td>
		</tr>
	</table>
	<br><br>
	<table class="w3-table w3-hoverable">
		<thead class="w3-bottombar w3-border-green">
			<tr>
				<th colspan="2"><h3>Personal Information</h3></th>
			</tr>
		</thead>
		<tr>
			<th>{!! Form::label('firstname', '氏名', ['class'=>'w3-validate']) !!}</th>
			<td>{!! Form::text('firstname', null, ['placeholder'=>'メイ', 'class'=>'w3-input']) !!}
			<br>
			{!! Form::text('lastname', null, ['placeholder'=>'セイ', 'class'=>'w3-input']) !!}</td>
		</tr>
		<tr>
			<th>{!! Form::label('phone', '携帯電話') !!}</th>
			<td>{!! Form::text('phone', null, ['placeholder'=>'携帯電話', 'class'=>'w3-input']) !!}</td>
		</tr>
		<tr>
			<th>{!! Form::label('gender', '性別') !!}</th>
			<td>
				{!! Form::select('gender', \Config::get('constants.GENDER'), ['class'=>'w3-select']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('birthday', '誕生日') !!}</th>
			<td>{!! Form::input('date', 'birthday', null) !!}</td>
		</tr>
		<tr>
			<th>{!! Form::label('short_description', 'Short description') !!}</th>
			<td>{!! Form::textarea('short_description', null, ['placeholder'=>'Short description', 'class'=>'w3-text']) !!}
				<script>
				// $('#short_description').ckeditor();
				$('#short_description').trigger('autoresize');
				</script>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('description', '概要') !!}</th>
			<td>{!! Form::textarea('description', null, ['placeholder'=>'概要', 'class'=>'']) !!}
				<script>
				// $('#description').ckeditor();
				$('#description').trigger('autoresize');
				</script>
			</td>
		</tr>
	</table>
	<br><br>

	{{--
	<table class="w3-table w3-hoverable">
		<thead class="w3-bottombar w3-border-green">
			<tr>
				<th colspan="2"><h3>Address</h3></th>
			</tr>
		</thead>

		<tr>
			<th>{!! Form::label('zip_code', '郵便番号') !!}</th>
			<td>
			{[is_not_confirm]}<span class="guide">郵便番号をハイフン（-）ありでご記入下さい。</span>{[/is_not_confirm]}<br>
			{!! Form::text('zip_code', null, ["style"=>"width:70px;", 'placeholder'=>'000-0000']) !!}
			{!! Form::button('自動取得', ["onclick"=>"getAddrFromZip();return false;"]) !!}
			<span class="example">{[#EXAMPLE_ZIP#]}</span></td>
		</tr>
		<tr>
			<th>{!! Form::label('prefecture', '都道府県') !!}</th>
			<td>{!! Form::text('prefecture', null, ["style"=>"width:300px;"]) !!}</td>
		</tr>
		<tr>
			<th>{!! Form::label('city', 'City') !!}</th>
			<td>
				{!! Form::text('city', null, ["style"=>"width:300px;", 'placeholder'=>'東京都']) !!}
				<span class="example">{[#EXAMPLE_CITY#]}{[#EXAMPLE_ADDR#]}</span>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('address', '住所') !!}</th>
			<td>
				{!! Form::text('address', null, ["style"=>"width:300px;", 'placeholder'=>'Chiyoda, Chiyoda, Tokyo 100-0001, Japan']) !!}
				<span class="example">{[#EXAMPLE_CITY#]}{[#EXAMPLE_ADDR#]}</span>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('building', 'ビル名') !!}</th>
			<td>
				{!! Form::text('building', null, ["style"=>"width:300px;"]) !!}
				<span class="example">{[#EXAMPLE_BLDG#]}</span>
			</td>
		</tr>
		<tr>
			<th>地図</th>
			<td>
				<div id="map" style="width:100%;height:400px;"></div>
			</td>
		</tr>

	</table>
	--}}

	<div class="w3-container w3-center">
		{!! Form::submit("Update", ["name"=>"submit[done]", "class"=>"w3-btn"]) !!}
	</div>

	{!! Form::close() !!}

</div>

@include('_include.user_w3.user_footer')