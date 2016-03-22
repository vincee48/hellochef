@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>For security reasons, please confirm your email address</h3>
					@include('alerts')
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<p>You should have received an email from us containing an “activate” button in your sign up email account.</p>
					<br/>
					<p>If by any chance you didn't, please enter your email again to have it resent.</p>
					{{ Form::open(array('role' => 'form', 'class' => 'form-horizontal')) }}

					@if (!$errors->has('email'))
					<div class="form-group required">
					@else
					<div class="form-group required has-error">
					@endif
						<div class="col-md-2">
							{{ Form::label('email', 'Email', array('class' => 'control-label')) }}
						</div>

						<div class="col-md-6">
							{{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Enter email', 'id' => 'email')) }}
						</div>

						<div class="col-md-4">
							{{ $errors->first('email') }}
						</div>
					</div>

					@if (!$errors->has('recaptcha_response_field'))
					<div class="form-group required">
					@else
					<div class="form-group required has-error">
					@endif
						<div class="col-md-2">
							{{ Form::label('recaptcha_response_field', 'Human Confirmation', array('class' => 'form-label')) }}
						</div>
						<div class="col-md-6">
							{{ Form::captcha() }}
						</div>
						<div class="col-md-4">
							{{ $errors->first('recaptcha_response_field') }}
						</div>
					</div>

					<div class="col-md-offset-2 col-md-4">
						{{ Form::submit('Resend confirmation email') }}
					</div>

					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
