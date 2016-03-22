@extends('layout')

@section('body-id')
	signup
@endsection

@section('content')
	<div class="container">
		<div class="row header">
			<div class="col-md-12">
				<h4>Sign in to your account</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="wrapper clearfix">
					<div class="formy">
						<div class="row">
							<div class="col-md-12">
								@include('alerts')

								@if (Session::has('flash_error'))
									<div class='alert alert-danger'><span class="glyphicon glyphicon glyphicon-exclamation-sign"></span> {{ Session::get('flash_error') }}</div>
								@endif
								{{ Form::open(array('role' => 'form')) }}
									@if (!$errors->has('email'))
									<div class="form-group">
									@else
									<div class="form-group has-error">
									@endif
										{{ Form::label('email', 'Email') }} {{ $errors->first('email') }}
										{{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Enter email', 'id' => 'email')) }}
									</div>
									@if (!$errors->has('password'))
									<div class="form-group">
									@else
									<div class="form-group has-error">
									@endif
										{{ Form::label('password', 'Password') }} {{ $errors->first('password') }}
										{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter password', 'id' => 'password')) }}
									</div>
									<div class="checkbox">
										<label>
											{{ Form::hidden('remember_me', '0') }}
											{{ Form::checkbox('remember_me', '1') }} Remember me
										</label>
									</div>
									<div class="submit">
										{{ Form::submit('Sign in', array('class' => 'btn btn-primary')) }}
										<p></p>
										<p><a href="/reset">Forgot your password?</a></p>
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
