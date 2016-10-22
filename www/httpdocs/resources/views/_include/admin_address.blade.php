<table class="sheet">
<col width="160px">
	<thead>
		<tr>
			<th colspan="2">住所編集</th>
		</tr>
	</thead>
	<tr>
		<th>{!! Form::label('zip_code', '郵便番号') !!}</th>
		<td>
		<span class="guide">郵便番号をハイフン（-）ありでご記入下さい。</span><br>
		{!! Form::text('zip_code', null, ["style"=>"width:80px;", 'placeholder'=>'000-0000']) !!}
		{!! Form::button('自動取得', ["onclick"=>"getAddrFromZip();return false;"]) !!}
		<span class="example">{{ env('EXAMPLE_ZIP') }}</span></td>
	</tr>
	<tr>
		<th>{!! Form::label('prefecture', '都道府県') !!}</th>
		<td>{!! Form::text('prefecture', null, ["style"=>"width:500px;"]) !!}</td>
	</tr>
	<tr>
		<th>{!! Form::label('city', 'City') !!}</th>
		<td>
			{!! Form::text('city', null, ["style"=>"width:500px;", 'placeholder'=>'Hồ Chí Minh']) !!}
			<span class="example">{[#EXAMPLE_CITY#]}{[#EXAMPLE_ADDR#]}</span>
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('district', 'District') !!}</th>
		<td>
			{!! Form::text('district', null, ["style"=>"width:500px;", 'placeholder'=>'１区']) !!}
			<span class="example">{[#EXAMPLE_CITY#]}{[#EXAMPLE_ADDR#]}</span>
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('address', '住所') !!}</th>
		<td>
			{!! Form::text('address', null, ["style"=>"width:500px;", 'placeholder'=>'Chiyoda, Chiyoda, Tokyo 100-0001, Japan']) !!}
			<span class="example">{[#EXAMPLE_CITY#]}{[#EXAMPLE_ADDR#]}</span>
		</td>
	</tr>
	<tr>
		<th>{!! Form::label('building', 'Building') !!}</th>
		<td>
			{!! Form::text('building', null, ["style"=>"width:500px;"]) !!}
			<span class="example">{[#EXAMPLE_BLDG#]}</span>
		</td>
	</tr>
{{--
	<tr>
		<th>地図 <font color="red">Cannot register for Google Maps API now.</font></th>
		<td>
			<div id="map" style="width:100%;height:400px;"></div>
		</td>
	</tr>
--}}
</table>
