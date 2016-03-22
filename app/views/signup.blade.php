@extends('layout')

@section('body-id')
	signup
@endsection

@section('content')
	<div class="container">
		<div class="row header">
			<div class="col-md-12">
				<h4>Sign up for an account</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="wrapper clearfix">
					<div class="formy">
						<div class="row">
							<div class="col-md-12">
								{{ Form::open(array('role' => 'Form')) }}
									@if (!$errors->has('email'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif
										{{ Form::label('email', 'Email') }} {{ $errors->first('email') }}
										{{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Enter email', 'id' => 'email')) }}
									</div>
									@if (!$errors->has('password'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif
										{{ Form::label('password', 'Password') }} {{ $errors->first('password') }}
										{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter password', 'id' => 'password')) }}
									</div>
									@if (!$errors->has('password_confirmation'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif
										{{ Form::label('password_confirmation', 'Confirm Password') }}
										{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm password', 'id' => 'confirmpassword')) }}
									</div>
									@if (!$errors->has('firstname'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif
										{{ Form::label('firstname', 'First Name') }} {{ $errors->first('firstname') }}
										{{ Form::text('firstname', Input::old('firstname'), array('class' => 'form-control', 'placeholder' => 'Enter first name', 'id' => 'firstname')) }}
									</div>
									@if (!$errors->has('lastname'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif
										{{ Form::label('lastname', 'Last Name') }} {{ $errors->first('lastname') }}
										{{ Form::text('lastname', Input::old('lastname'), array('class' => 'form-control', 'placeholder' => 'Enter last name', 'id' => 'lastname')) }}
									</div>
									<div class="form-group">
										<input type="checkbox" id="terms" /> I agree to the <a href="/terms" target="_blank">terms and conditions</a>.
									</div>
									<div class="submit">
										{{ Form::submit('Sign up', array('class' => 'btn btn-primary', 'disabled', 'id' => 'signup-button')) }}
									</div>
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
				<div class="already-account">
					Already have an account?
					<a href="signin">Login here</a>
				</div>
			</div>
		</div>
	</div>
@endsection	
@section('scripts')
	<script>
		$(document).ready(function() {
			$("#terms").click(function() {
				$("#signup-button").attr("disabled", !this.checked);
			});
		});
	</script>
@stop
