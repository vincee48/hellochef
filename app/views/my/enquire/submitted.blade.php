@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Step 5</h3>
					<p>Submitted for Appoval</p>
					@include('alerts')
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="project">
						<h3>Submitted for Approval</h3>
						<p class="description">
							Thank you for submitting your application, we will get back to you shortly!
						</p>
					</div>
					<a href="/my/become-a-chef/step-5" class="button pull-left">Previous</a>
				</div>
			</div>
		</div>
	</div>
@stop
