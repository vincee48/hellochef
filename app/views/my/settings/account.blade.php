<div class="col-md-12 account">
	{{ Form::model($userhistory, array('route' => array('user.updateAccount', Auth::id()), 'role' => 'Form', 'class' => 'form-horizontal')) }}


		<div class='row'>
			<h4 class='col-sm-12'>Account Information</h4>
		</div>
		<hr/>

		@if (!$errors->has('password'))
		<div class="form-group required">
		@else
		<div class="form-group required has-error">
		@endif
			{{ Form::label('password', 'Current Password', array('class' => 'control-label col-sm-3')) }}
			<div class="col-sm-5">
				{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter password', 'id' => 'password')) }}
			</div>
			<div class="col-sm-4">
				{{ $errors->first('password') }}
			</div>
		</div>


		@if (!$errors->has('email'))
		<div class="form-group required">
		@else
		<div class="form-group required has-error">
		@endif
			{{ Form::label('email', 'Email', array('class' => 'control-label col-sm-3')) }}
			<div class="col-sm-5">
				{{ Form::text('email', $userhistory->getUser()->email, array('class' => 'form-control', 'id' => 'email')) }}
			</div>
			<div class="col-sm-4">
				{{ $errors->first('email') }}
			</div>
		</div>

		<div class='row'>
			<h4 class='col-sm-12'>Contact Information</h4>
		</div>

		<hr/>

		@if (!$errors->has('firstname'))
		<div class="form-group required">
		@else
		<div class="form-group required has-error">
		@endif
			{{ Form::label('firstname', 'First Name', array('class' => 'control-label col-sm-3')) }}
			<div class="col-sm-5">
				{{ Form::text('firstname', Input::old('firstname'), array('class' => 'form-control', 'id' => 'firstname')) }}
			</div>
			<div class="col-sm-4">
				{{ $errors->first('firstname') }}
			</div>
		</div>

		@if (!$errors->has('middlename'))
		<div class="form-group">
		@else
		<div class="form-group has-error">
		@endif
			{{ Form::label('middlename', 'Middle Name', array('class' => 'control-label col-sm-3')) }}
			<div class="col-sm-5">
				{{ Form::text('middlename', Input::old('middlename'), array('class' => 'form-control', 'id' => 'middlename')) }}
			</div>
			<div class="col-sm-4">
				{{ $errors->first('middlename') }}
			</div>
		</div>

		@if (!$errors->has('lastname'))
		<div class="form-group required">
		@else
		<div class="form-group required has-error">
		@endif
			{{ Form::label('lastname', 'Last Name', array('class' => 'control-label col-sm-3')) }}
			<div class="col-sm-5">
				{{ Form::text('lastname', Input::old('lastname'), array('class' => 'form-control', 'id' => 'lastname')) }}
			</div>
			<div class="col-sm-4">
				{{ $errors->first('lastname') }}
			</div>
		</div>

		<div class='row'>
			<h4 class='col-sm-12'>Change Password</h4>
		</div>

		<hr/>

		@if (!$errors->has('newpassword'))
		<div class="form-group">
		@else
		<div class="form-group has-error">
		@endif
			{{ Form::label('newpassword', 'New password', array('class' => 'control-label col-sm-3')) }}
			<div class="col-sm-5">
				{{ Form::password('newpassword', array('class' => 'form-control', 'placeholder' => 'Enter new password', 'id' => 'newpassword')) }}
			</div>
			<div class="col-sm-4">
				{{ $errors->first('newpassword') }}
			</div>
		</div>

		@if (!$errors->has('newpassword_confirmation'))
		<div class="form-group">
		@else
		<div class="form-group has-error">
		@endif
			{{ Form::label('newpassword_confirmation', 'Confirm new password', array('class' => 'control-label col-sm-3')) }}
			<div class="col-sm-5">
				{{ Form::password('newpassword_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm new password', 'id' => 'newpassword_confirmation')) }}
			</div>
			<div class="col-sm-4">
				{{ $errors->first('newpassword_confirmation') }}
			</div>
		</div>

		<div class="form-group">
			<div class="submit col-sm-offset-3 col-sm-9">
				{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
			</div>
		</div>

	{{ Form::close() }}
</div>
