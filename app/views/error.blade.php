@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Ooops!</h3>
					<br/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<p>We apologise for the inconvenience. Please refresh browser or go back and try to click on the link again.</p>
					<br/>
					<p><a href="{{ URL::previous() }}" class="join-team button button-small">Back</a></p>
				</div>
			</div>
		</div>
	</div>
@stop
