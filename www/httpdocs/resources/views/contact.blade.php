@include('_include.user_w3.user_header',
	[
		'id'		=> 'contact',
	]
)

<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col">
			<a href="/"><i class="fa fa-home"></i> Trang chủ</a>
			&gt;
			Liên lạc
		</div>
	</div>
</div>
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="w3-container w3-leftbar w3-border-black w3-hover-border-green">
				<h2><b>Thông tin</b></h2>
			</div>

			<table class="table table-hover">
				<tbody>
				<tr>
					<td width="250px">Logo</td>
					<td><img src="/common/image/logo_rgreen.png" alt="{{ env('APP_NAME') }}" width="200px">
					</td>
				</tr>
				<tr>
					<td>Chủ sở hữu</td>
					<td>Ông. Nguyễn Ngọc Nam</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<br>
<div class="container">
	{!! Form::model($model, ['role'=>'form', 'class'=>'form-horizontal']) !!}
	<div class="w3-container w3-leftbar w3-border-black w3-hover-border-green">
		<h1><b>Liên lạc</b></h1>
	</div>
	@include('_include.error_message')
	<fieldset>
{{--
	<legend><h1>Contact</h1></legend>
--}}
	<div class="form-group">
		{!! Form::label('name', 'Tên người gửi', ['class'=>'col-lg-2 control-label']) !!}
		<div class="input-group col-lg-9">
			<span class="input-group-addon">※</span>
			{!! Form::text('name', null, ["class"=>"form-control", 'placeholder'=>'Tên người gửi', 'rows'=>'20', 'required'=>'required']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('email', 'Email', ['class'=>'col-lg-2 control-label']) !!}
		<div class="input-group col-lg-9">
			<span class="input-group-addon">※</span>
			{!! Form::text('email', null, ["class"=>"form-control", 'placeholder'=>'Email', 'rows'=>'20', 'required'=>'required', 'autocomplete'=>'on']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('message', 'Tin nhắn', ['class'=>'col-lg-2 control-label']) !!}
		<div class="input-group col-lg-9">
			<span class="input-group-addon">※</span>
			{!! Form::textarea('message', null, ["class"=>"form-control", 'placeholder'=>'Tin nhắn', 'rows'=>'20', 'required'=>'required']) !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<button type="reset" class="w3-btn w3-grey w3-text-white">Xóa</button>
			<button type="submit" class="w3-btn w3-green" disabled="disabled">Gửi</button> <font color="red">※Chưa hoàn thiện chức năng này. Sẽ hoàn thành sớm.</font>
		</div>
	</div>
	</fieldset>

	{!! Form::close() !!}

</div>


@include('_include.user_w3.user_footer')
