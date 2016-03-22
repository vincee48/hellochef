@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Step 1</h3>
					<p>Create a username</p>
					@include('alerts')
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ Form::model($lead, array('route' => array('chef.enquire.step1'), 'role' => 'Form', 'class' => 'form-horizontal')) }}

						<div class="project">
							<h3>Your Personalized URL</h3>
							<div class="screen">
								<em>www.hellochef.com.au/chef/{{ $lead->chefname ? $lead->chefname : 'johnsmith' }}</em>
							</div>
							<p class="description">
								Choose your unique web address.
							</p>
							<div class="visit">
								@if (!$errors->has('chefname'))
								<div class="form-group required">
								@else
								<div class="form-group required has-error">
								@endif
									<div class="col-sm-2">
										{{ Form::label('chefname', 'Username', array('class' => 'pull-left control-label')) }}
									</div>
									<div class="col-sm-7">
										{{ Form::text('chefname', Input::old('chefname'), array('class' => 'form-control', 'placeholder' => 'Enter username', 'id' => 'chefname')) }}
									</div>
									<div class="col-sm-3">
										{{ $errors->first('chefname') }}
									</div>
								</div>
							</div>
							
							<div class="divider"></div>

							<br />

							<h3>Location</h3>
							<p class="description">
								Tell us which state you are in.
							</p>			
							
							<div class="visit">
								@if (!$errors->has('state'))
								<div class="form-group required">
								@else
								<div class="form-group required has-error">
								@endif
									<div class="col-sm-2">
										{{ Form::label('state', 'State', array('class' => 'pull-left control-label')) }}
									</div>
									<div class="col-sm-7">
										{{ Form::select('state', array(
											'Australian Capital Territory' => 'Australian Capital Territory', 
											'New South Wales' => 'New South Wales', 
											'Queensland' => 'Queensland', 
											'South Australia' => 'South Australia', 
											'Tasmania' => 'Tasmania', 
											'Victoria' => 'Victoria', 
											'Western Australia' => 'Western Australia'), Input::old('state') != "" ? Input::old('state') : ($lead->getProfile() && $lead->getProfile()->state != "" ? $lead->getProfile()->state : 'New South Wales'), array('class' => 'form-control', 'id' => 'state')) }}
									</div>
									<div class="col-sm-3">
										{{ $errors->first('state') }}
									</div>
								</div>
								
								{{ Form::submit('Save', array('class' => 'btn btn-default')) }}
							</div>
							

						</div>
						@if ($lead->step1)
						<a href="/my/become-a-chef/step-2" class="button pull-right">Next</a>
						@endif
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	</div>
@stop
