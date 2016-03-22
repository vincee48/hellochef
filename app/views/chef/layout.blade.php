@extends('layout')

@section('body-id')
	portfolio-item
@endsection

@section('content')
	<?php
		$history = "";
		if ($profile) {
			$history = $profile->getLatestHistory();
		}

		if ($preview) {
			$lead = Lead::where('chefname', '=', $chefname)->first();
		}

	?>

	@yield('flexslider')

	<div class="container">
		<div class="col-sm-12">
			<div class="project">
				@yield('gallery')
				@if ($chef->id == Auth::id() && !$preview)
				<div class="row topPadding">
					<div class="col-md-12 text-center">
						<p>
							<a href="/my/settings/profile" class="btn btn-primary"><span>Edit Profile</span></a>
							<a href="/my/settings/menu" class="btn btn-primary"><span>Edit Menu</span></a>
						</p>
					</div>
				</div>
				<hr/>
				@endif
				<div class="row">
					<div class="col-sm-9">
						@yield('chef-content')
					</div>

					<div class="col-sm-3 chef-profile">
						<div class="info">
							<div class="profile-pic">
							@if ($chef && $chef->getProfilePicture())
								{{ HTML::image("images/" . $chef->id . "/" . $chef->getProfilePicture()->filename, null, array('class' => 'img-responsive')) }}
							@else
								<img src="/images/circle-icons/full-color/profile.png" class="img-responsive" />
							@endif
							</div>
							<div class="row">
								<div class="col-sm-12">
									@if (!$preview)
									<h3><a href="/chef/{{ $chefname }}">{{ $chef->getName() }}</a></h3>
									@else
									<h3><a href="/admin/leads/{{ $id }}">{{ $chef->getName() }}</a></h3>
									@endif
								</div>
							</div>

							@if (!$history)
							<div class="row">
								<div class="col-sm-12">
									<p>No chef found with that name!</p>
								</div>
							</div>
							@elseif (!$history->aboutme)
							<div class="row">
								<div class="col-sm-12">
									<h4>Profile is not ready yet.</h4>
								</div>
							</div>
							@else
							<div class="row">
								@if ($profile->useownvenue)
								<div class="col-sm-12 text-center">
									<p><span class="glyphicon glyphicon-glass"></span> Chef can host diners</p>
								</div>
								@endif
								<div class="col-xs-12">
									<h4>About</h4>
									<p>
										{{ nl2br($history->aboutme) }}
									</p>
								</div>
							</div>
							@endif

							@if ($preview)
							<div class="row">
								<div class="text-center col-md-12">
									<p>
										<a href="/admin/leads" class="btn-signup button-clear"><span>Back</span></a>
										<a href="/admin/leads/{{$lead->id}}/qualify" class="btn-signup button-clear"><span>Qualify</span></a>
									</p>
								</div>
							</div>
							@endif

							@yield('enquiry-modal')

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection

@section('scripts')
	@yield('chef-scripts')
	<script type="text/javascript">
		$(function() {
			$('.flexslider').flexslider({
				directionNav: true,
				controlNav: false,
				slideshowSpeed: 10000
			});
	  	});

		$(document).ready(function() {
 
		    var imageHeight, wrapperHeight, overlap, container = $('.flexslider'); 
		 
		    function centerImage() {
				$('.flexslider').find('img').each(function() {
			        imageHeight = $(this).height();
			        wrapperHeight = container.height();
			        overlap = (wrapperHeight - imageHeight) / @yield('image-height');		
					$(this).css('margin-top', overlap);
				});
		    }
		     
		    $(window).on("load resize", centerImage);
		     
		    var el = document.getElementById('wrapper');
		    if (el != null && el.addEventListener) { 
		        el.addEventListener("webkitTransitionEnd", centerImage, false); // Webkit event
		        el.addEventListener("transitionend", centerImage, false); // FF event
		        el.addEventListener("oTransitionEnd", centerImage, false); // Opera event
		    }		 
		});
	</script>
@stop
