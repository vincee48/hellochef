<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<style>

		</style>
	</head>
	<body>
		@yield('content')

		@if (!isset($dbOnly))
		<div style="padding-top: 25px">
			<div>Cheers!</div>
			<div>Hello Chef</div>
			<div>Enquiries: help@hellochef.com.au</div>
			<p>
				<a href="https://www.facebook.com/pages/Hello-Chef/720543784659707"><img src="{{ $message->embed(URL::to('/images/social/fb-blue.png')) }}" alt="Facebook" width="25" /></a>
				<a href="http://www.instagram.com/ohhellochef"><img src="{{ $message->embed(URL::to('/images/social/ig.png')) }}" alt="Instagram" width="25" /></a>
			</p>
		</div>
		@endif
	</body>
</html>
