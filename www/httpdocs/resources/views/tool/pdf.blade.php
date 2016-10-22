@include('_include.user_header',
	[
		'id'		=> 'tool.pdf'
	]
)

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="/">Home</a></li>
				<li class="active">My page</li>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h3>Header</h3>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-3">
				<div class="panel panel-default">
                    <form method="post">
                        @include('_include.error_message')

                        {!! csrf_field() !!}
                        <input type="submit" value="Download PDF">
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>


@include('_include.user_footer')
