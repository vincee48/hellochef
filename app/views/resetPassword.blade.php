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
								{{ Form::open(array('role' => 'Form')) }}

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
									<div class="submit">
										{{ Form::submit('Update your password') }}
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
@stop
