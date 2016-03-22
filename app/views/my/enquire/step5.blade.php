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
					<p>Enter your bank details</p>
					@include('alerts')
				</div>
			</div>
			<div class="row">
				{{ Form::model($user, array('role' => 'Form', 'class' => 'form-horizontal')) }}

				<div class="col-md-12">
					<div class="project">
						<h3>Bank Details</h3>
						<p class="description">
							Just one last piece of information so that we can transfer you the money earned for your events. <b>This information will not be displayed on your profile</b> - it is only kept for payment purposes.

						</p>
						<div class="divider"></div>
						<div class="visit">
							@if (!$errors->has('bsb'))
							<div class="form-group required">
							@else
							<div class="form-group required has-error">
							@endif
								<div class="col-sm-2">
									{{ Form::label('bsb', 'BSB', array('class' => 'pull-left control-label')) }}
								</div>
								<div class="col-sm-7">
									{{ Form::text('bsb', Input::old('bsb'), array('class' => 'form-control', 'placeholder' => 'Enter your BSB', 'id' => 'bsb')) }}
								</div>
								<div class="col-sm-3">
									{{ $errors->first('bsb') }}
								</div>
							</div>

							@if (!$errors->has('accountnum'))
							<div class="form-group required">
							@else
							<div class="form-group required has-error">
							@endif
								<div class="col-sm-2">
									{{ Form::label('accountnum', 'Account No', array('class' => 'pull-left control-label')) }}
								</div>
								<div class="col-sm-7">
									{{ Form::text('accountnum', Input::old('accountnum'), array('class' => 'form-control', 'placeholder' => 'Enter your account number', 'id' => 'accountnum')) }}
								</div>
								<div class="col-sm-3">
									{{ $errors->first('accountnum') }}
								</div>
							</div>
						</div>
					</div>
					<a href="/my/become-a-chef/step-4" class="button pull-left">Previous</a>
					<input class="button pull-right" type="submit" name="action" value="Submit for Approval">
				</div>

				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop
