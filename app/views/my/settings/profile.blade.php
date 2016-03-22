<div class="col-md-12 profile">
	<div id="loading"></div>

	<div class="row">
		<div class="col-md-12 text-center">
			<p>
				<a href="/chef/{{ Auth::user()->chefname }}" class="btn btn-primary"><span>View Profile</span></a>
			</p>
		</div>
	</div>
	<hr/>
	{{ Form::model($profile, array('route' => array('user.updateProfile', Auth::id()), 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}

		@if (!$errors->has('profilepic'))
		<div class="form-group required">
		@else
		<div class="form-group required has-error">
		@endif
			<div class="col-sm-2">
				{{ Form::label('profilepic', 'Profile picture', array('class' => 'control-label')) }}
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
			<div class="col-sm-3">
				{{ $errors->first('profilepic') }}
			</div>
		</div>

		@if (!$errors->has('aboutme'))
		<div class="form-group required">
		@else
		<div class="form-group required has-error">
		@endif
			<div class="col-sm-2">
				{{ Form::label('aboutme', 'About me', array('class' => 'control-label')) }}
			</div>
			<div class="col-sm-7">
				{{ Form::textarea('aboutme', null, array('class' => 'form-control', 'placeholder' => 'Enter some information about yourself...', 'id' => 'aboutme')) }}
			</div>
			<div class="col-sm-3">
				{{ $errors->first('aboutme') }}
			</div>
		</div>

		@if (!$errors->has('experience'))
		<div class="form-group required">
		@else
		<div class="form-group required has-error">
		@endif
			<div class="col-sm-2">
				{{ Form::label('experience', 'Experience', array('class' => 'control-label')) }}
			</div>
			<div class="col-sm-7">
				{{ Form::textarea('experience', null, array('class' => 'form-control', 'placeholder' => 'Enter some of your previous experiences here...', 'id' => 'experience')) }}
			</div>
			<div class="col-sm-3">
				{{ $errors->first('experience') }}
			</div>
		</div>
		
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
					'Western Australia' => 'Western Australia'), Input::old('state') != "" ? Input::old('state') : ($profile && $profile->getProfile()->state != "" ? $profile->getProfile()->state : 'New South Wales'), array('class' => 'form-control', 'id' => 'state')) }}
			</div>
			<div class="col-sm-3">
				{{ $errors->first('state') }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-xs-2">
				{{ Form::label('useownvenue', 'Use Own Venue', array('class' => 'pull-left')) }}
			</div>
			<div class="col-xs-10">
				{{ Form::checkbox('useownvenue', '1', $profile ? $profile->getProfile()->useownvenue : false, array('class' => 'pull-left')) }}
			</div>
		</div>

		<div class="form-group">
			<div class="submit col-sm-offset-2 col-sm-10">
				{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
			</div>
		</div>

	{{ Form::close() }}
</div>

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
			success: function() { window.location = '/my/settings/profile' },
			failure: function() { window.location = '/my/settings/profile' }
		});
    });
});	
</script>