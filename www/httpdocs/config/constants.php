<?php

return [
	'PROJECT_NAME' => env("APP_NAME"),
	'PROJECT_NAME_EN' => env("APP_NAME_EN"),
	'EXAMPLE_EMAIL' => 'nam@mincorp.com',
	'ENTRY_EMAIL' => 'nam@mincorp.com',

	'STATUS'					=> ['Active'=>'Active', 'Inactive'=>'Inactive'],
	'FORM_SEARCH_STATUS'		=> [''=>'▼状態を選択してください', 'Active'=>'Active', 'Inactive'=>'Inactive'],
	'GENDER'					=> ['男性'=>'男性', '女性'=>'女性'],
	'PUBLISH_STATUS' 			=> ['公開'=>'公開', '非公開'=>'非公開'],
	'FORM_SEARCH_PUBLISH_STATUS' => [''=>'▼状態を選択してください', '公開'=>'公開', '非公開'=>'非公開'],

	'FORM_STATUS'				=> [''=>'▼Choose below value', 'Active'=>'Active', 'Inactive'=>'Inactive'],

	'FORM_PUBLISH_STATUS' 		=> [''=>'▼Choose below value', 'Publish'=>'Publish', 'Unpublish'=>'Unpublish'],

	'MEDIA_TYPE'					=> ['File', 'Image', 'Music', 'Video'],
	'FORM_MEDIA_TYPE'				=> [''=>'▼Choose below value', 'File', 'Image', 'Music', 'Video'],
];
