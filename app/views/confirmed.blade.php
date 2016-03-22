@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Welcome!</h3>
					<br/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<p>Thank you for confirming your email. Start browsing our menus now.</p>
					<br/>
					<p><a href="/browse" class="join-team button button-small">Browse</a></p>
				</div>
			</div>
		</div>
	</div>
@stop
