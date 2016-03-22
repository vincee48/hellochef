@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="loading"></div>
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Step 2</h3>
					<p>Set up your profile</p>
					@include('alerts')
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				{{ Form::model($leadProfile, array('route' => array('chef.enquire.step2'), 'role' => 'Form', 'class' => 'form-horizontal', 'files' => true)) }}

					<div class="project">
						<h3>Your Profile</h3>

						<div class="visit">
								<div class="form-group">
									<div class="col-sm-2">
										{{ Form::label('profilepic', 'Profile picture', array('class' => 'pull-left control-label')) }}
									</div>
									<div class="col-sm-7">
										@if (Auth::user()->getProfilePicture())
											<div class="img-container">
												{{ HTML::image("images/" . Auth::id() . "/" . Auth::user()->getProfilePicture()->filename, null, array('class' => '')) }}						
											</div>
											<div class="text-center">
												<div class="btn-group">
													<button class="btn btn-primary" data-method="zoom" data-option="0.1" type="button" title="Zoom In">
														<span class="docs-tooltip" data-toggle="tooltip">
															<span class="glyphicon glyphicon-zoom-in"></span>
														</span>
													</button>
													<button class="btn btn-primary" data-method="zoom" data-option="-0.1" type="button" title="Zoom Out">
														<span class="docs-tooltip" data-toggle="tooltip">
															<span class="glyphicon glyphicon-zoom-out"></span>
														</span>
													</button>
													<button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate Left">
														<span class="docs-tooltip" data-toggle="tooltip">
															<span class="glyphicon glyphicon-share-alt icon-flipped"></span>
														</span>
													</button>
													<button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate Right">
														<span class="docs-tooltip" data-toggle="tooltip">
															<span class="glyphicon glyphicon-share-alt"></span>
														</span>
													</button>
													<button class="btn btn-primary" id="download" type="button" title="Crop image">
														<span class="docs-tooltip" data-toggle="tooltip">
															<span class="glyphicon glyphicon-download"></span>
														</span>
													</button>
												</div>
											</div>

										@else
											<img src="/images/circle-icons/full-color/profile.png" class="img-responsive img-rounded" />
										@endif
										<p></p>
										{{ Form::file('profilepic', array('accept'=>'image/*')) }}
									</div>
									<div class="col-sm-2">
										{{ $errors->first('profilepic') }}
									</div>
								</div>

								<div class="divider"></div>

								<br />

								<h3>About Yourself</h3>
								<p class="description">
									Tell us about yourself. For example, who you are, what your cooking style is, your favourite ingredients...
								</p>

								@if (!$errors->has('aboutme'))
								<div class="form-group required">
								@else
								<div class="form-group required has-error">
								@endif
									<div class="col-sm-2">
										{{ Form::label('aboutme', 'About me', array('class' => 'pull-left control-label')) }}
									</div>
									<div class="col-sm-7">
										{{ Form::textarea('aboutme', null, array('class' => 'form-control', 'placeholder' => 'Enter some information about yourself...', 'id' => 'aboutme')) }}
									</div>
									<div class="col-sm-3">
										{{ $errors->first('aboutme') }}
									</div>
								</div>

								<div class="divider"></div>

								<br />
								<h3>Experience</h3>
								<p class="description">
									Tell us about your culinary experiences. For example, any qualifications or places you've worked in.
								</p>

								@if (!$errors->has('experience'))
								<div class="form-group required">
								@else
								<div class="form-group required has-error">
								@endif
									<div class="col-sm-2">
										{{ Form::label('experience', 'Experience', array('class' => 'pull-left control-label')) }}
									</div>
									<div class="col-sm-7">
										{{ Form::textarea('experience', null, array('class' => 'form-control', 'placeholder' => 'Enter some information about your previous Experience...', 'id' => 'experience')) }}
									</div>
									<div class="col-sm-3">
										{{ $errors->first('experience') }}
									</div>
								</div>

								<div class="divider"></div>

								<br />
								<h3>Options</h3>
								<p class="description">
									You also have the option to host diners at your home to provide an intimate dining experience.
								</p>

								<div class="form-group">
									{{ Form::label('useownvenue', 'Use Own Venue') }} 
									{{ Form::checkbox('useownvenue', '1', $lead->getProfile()->useownvenue) }}		 							
								</div>

								{{ Form::submit('Save', array('class' => 'btn btn-default')) }}
							</div>
						</div>

						<a href="/my/become-a-chef/step-1" class="button pull-left">Previous</a>
						@if ($lead->step2)
						<a href="/my/become-a-chef/step-3" class="button pull-right">Next</a>
						@endif

						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
	var $image = $(".img-container img"),
    $dataX = $("#dataX"),
    $dataY = $("#dataY"),
    $dataHeight = $("#dataHeight"),
    $dataWidth = $("#dataWidth");

	$image.cropper({
	  aspectRatio: 1,
	  data: {
		width: 500,
		height: 500
	  },
	  preview: ".img-preview",
	  done: function(data) {
		$dataX.val(data.x);
		$dataY.val(data.y);
		$dataHeight.val(data.height);
		$dataWidth.val(data.width);
	  },
	  zoomable: true,
	  rotatable: true,
	  dashed: false
	});
	$(document).on("click", "[data-method]", function () {
      var data = $(this).data();

      if (data.method) {
        $image.cropper(data.method, data.option);
      }

    });
	
	$("#download").click(function() {
		$('#loading').toggle();
		$.ajax({
			type: "POST",
			url: "/my/settings/profile/crop",
			data: { img : $image.cropper("getDataURL") },
			success: function() { window.location = '/my/become-a-chef/step-2' },
			failure: function() { window.location = '/my/become-a-chef/step-2' }
		});
    });
});	
</script>
@stop
