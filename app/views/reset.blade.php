@extends('layout')

@section('body-id')
	signup
@endsection

@section('content')
	<div class="container">
		<div class="row header">
			<div class="col-md-12">
				<h4>Reset your password</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="wrapper clearfix">
					<div class="formy">
						<div class="row">
							<div class="col-md-12">
									@include('alerts')				
								{{ Form::open(array('role' => 'Form')) }}
									@if (!$errors->has('email'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif
										{{ Form::label('email', 'Email') }} {{ $errors->first('email') }}
										{{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Enter email', 'id' => 'email')) }}
									</div>

									@if (!$errors->has('recaptcha_response_field'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif
											{{ Form::label('recaptcha_response_field', 'Human Confirmation', array('class' => 'form-label')) }}
											{{ $errors->first('recaptcha_response_field') }}
											{{ Form::captcha() }}
									</div>

									<div class="submit">
										{{ Form::submit('Reset your password') }}
									</div>
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
				<div class="already-account">
					<p>Don't have an account?	<a href="/signup">Create one here</a></p>
				</div>
			</div>
		</div>
	</div>
@stop
