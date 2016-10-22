	<meta property="og:url"           content="{{ Request::url() }}" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="{{ (isset($title) ? $title : env('APP_TITLE')) }}" />
	<meta property="og:description"   content="{{ (isset($description) ? strip_tags($description) : env('APP_DESCRIPTION')) }}" />
	<meta property="og:image"         content="{{ (isset($img_url) ? $img_url : env('APP_URL') . env('FB_IMG_PATH')) }}" />
	<meta property="fb:app_id"        content="1733228170265821" />

	<meta property="og:site_name"     content="{{ env('APP_NAME') }}">
