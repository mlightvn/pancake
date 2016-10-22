@include('_include.company_header'
	, [
		'title' 		=> NULL,
		'id' 			=> NULL,
		'css' 			=> NULL,
		'js' 			=> NULL,
	]
)

<ol class="bl">
	<li><em>会社</em></li>
</ol>
<h1 class="headline"><span>会社{{-- $company->name --}}</span></h1>


{{-- Comment --}}

@include('_include.company_footer')
