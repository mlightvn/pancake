@include('_include.company_header'
	, [
		'title' 		=> 'ログイン',
		'id' 			=> 'login',
		'css' 			=> NULL,
		'js' 			=> NULL,
	]
)

	<ol class="bl">
		<li><a href="/company/">会社</a></li>
		<li><em>ログイン</em></li>
	</ol>

	<h1 class="headline"><span>ログイン</span></h1>
	{[form]}
	<p class="message">管理画面にログインします。メールアドレスとパスワードを入力してください。</p>
	{[is_error]}
		{[form_error]}
	{[/is_error]}

	<table class="sheet">
	<thead>
		<tr>
			<th colspan="2">メールアドレス・パスワード入力</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>メールアドレス</td>
			<td>{[input_html name="company_login_mail" class="formfield"]}<span class="example">{["info@pharma-career.jp"|escape:hexentity]}</span></td>
		</tr>
		<tr>
			<td>パスワード</td>
			<td>{[input_html name="company_login_pass" class="formfield"]}<span class="example">*********</span></td>
		</tr>
	</tbody>
	</table>
	<div class="submit">
	<input type="image" value="ログインする" src="/img/btn/btn_login.gif" alt="ログインする" />
	</div>
	{[/form]}

{[*	<h2 class="headline"><span>新規登録</span></h2>
	<p class="center">企業様会員登録は<strong>無料</strong>になります。管理画面にて掲載のご相談、お申し込みも可能です。<br />
	ご不明な点がございましたらお気軽にご連絡ください。</p>
	<div class="center"><a href="./register" ><img src="/img/btn/btn_company_id.gif" alt="会員登録はこちら" /></a></div>
*]}
	<h2>パスワードを忘れた場合</h2>
	<ul class="submit center">
		<li><a href="/corp/reminder" class="more">パスワードを忘れた方はこちら</a><li>
	</ul>
{[include file="/_includes/corp_footer.html"]}