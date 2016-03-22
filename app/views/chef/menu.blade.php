<?php
	if ($preview) {
		$lead = Lead::where('chefname', '=', $chefname)->first();
	}

	$history = $menu->getLatestHistory();
	$menuitems = $menu->getMenuItems();
	$minpax = $history->minpax;
	$maxpax = $history->maxpax;
	$price = $history->price;
?>

@extends('chef.layout')

@section('gallery')
<div class="col-md-12">
	<div class="row">
		<div class="flexslider" id="wrapper">
			<ul class="slides">
			@foreach ($menu->getPictures() as $pic)
				<li><a href="/images/{{$chef->id}}/{{$pic->getDocument()->filename}}" title="">{{ HTML::image("images/" . $chef->id . "/" . $pic->getDocument()->filename, null) }}</a></li>
			@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection

@section('chef-content')
	@include('alerts')

	<div class="col-sm-12 text-center">
		<h2><span>{{ $menu->getLatestHistory()->title }}</span></h2>
	</div>
	<div class="col-md-12 home-content">
		<h3 class="text-center">{{ $history->description }}</h3>
	</div>
	<div class="col-sm-12">
		@foreach ($menuitems as $key => $menuitem)
		<?php $history = $menuitem->getLatestHistory() ?>
		<div class="row menu-display">
			<div class="col-sm-12 menuitem text-center">
				<div class="menuitem-name">{{ $history->name }}</div>
				<div class="menuitem-desc">{{ $history->description }}</div>
			</div>
		</div>
		@endforeach
	</div>
@endsection

@section('enquiry-modal')
	<hr/>
	<div class="row">
		<div class="col-md-12 text-center">
			<p>Min. Attendees: {{ $minpax }}</p>
			<p>Max. Attendees: {{ $maxpax }}</p>
			<p>${{ number_format($price, 2) }} per person</p>
			<button class="btn btn-primary" data-toggle="modal" data-target="#enquiryModal">
				Send Enquiry
			</button>
		</div>
	</div>
	<br/>
	<div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="enquiryModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				{{ Form::open(array('class' => 'form-horizontal')) }}

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="enquiryModalLabel">Leave an enquiry for {{ $chef->getName() }}</h4>
				</div>
				<div class="modal-body">
					@include('alerts')
					@if (!Auth::check())
					<div class="row">
							<div class="col-xs-12">
								<div class="alert alert-warning">Please log in to leave an enquiry</div>
							</div>
					</div>
					@endif
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group col-xs-12">
								{{ Form::button('-', array('class' => 'qtyminus', 'field' => 'quantity')) }}
								{{ Form::text('quantity', max(Input::old('quantity'), $minpax), array('class' => 'qty', 'id' => 'quantity')) }}
								{{ Form::button('+', array('class' => 'qtyplus', 'field' => 'quantity')) }}
								{{ Form::label('quantity', ' people', array('class' => 'form-label')) }}
							</div>

							<div class="form-group col-xs-12">
								<div class="input-group date">
									<input value="{{ Input::old('enquirydate') }}" type="text" name="enquirydate" class="form-control" placeholder="Select a date">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>

							<div class='form-group col-xs-12'>
								<div class='input-group datetimepicker'>
									<input value="{{ Input::old('time') }}" type='text' name='time' class="form-control" placeholder="Enter time" />
									<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
								</div>
							</div>

							@if ($menu->getProfile()->useownvenue)
							<div class='form-group col-xs-12'>
								{{ Form::checkbox('usechefvenue', '1', Input::old('usechefvenue')) }}
								{{ Form::label('usechefvenue', 'Use Chef Venue') }}
							</div>
							@endif
						</div>

						<div class="col-xs-5 col-xs-offset-1">
							<p><span class="font-large">${{ number_format($price, 2) }}</span> per person</p>
							<p>The price of this menu includes the chef's time, ingredient cost, and gratuity. You may customize the menu with the chef to suit your budget and food preferences</p>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								{{ Form::label('venue', 'Venue') }}
								{{ Form::textarea('venue', Input::old('venue'), array('class' => 'form-control', 'placeholder' => 'Enter your preferred venue/location here.', 'rows' => '3')) }}
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								{{ Form::label('specialreq', 'Special Requirements') }}
								{{ Form::textarea('specialreq', Input::old('specialreq'), array('class' => 'form-control', 'placeholder' => 'Enter any special requirements for your meal.', 'rows' => '3')) }}
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								{{ Form::label('additionalinfo', 'Additional Information') }}
								{{ Form::textarea('additionalinfo', Input::old('additionalinfo'), array('class' => 'form-control', 'placeholder' => 'Enter any additional information for your meal.', 'rows' => '3')) }}
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					@if (!Auth::check())
						<a href="/signin" class="btn btn-default">Login</a>
					@else
						{{ Form::submit('Enquire', array('class' => 'btn btn-primary')) }}
					@endif
				</div>

				{{ Form::close() }}
			</div>
		</div>
	</div>
@endsection

@section('image-height')
	2
@endsection

@section('chef-scripts')
	<script type="text/javascript" src="/js/magnific-popup-0.9.9.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var fixed = false;

			$('.flexslider').magnificPopup({
				delegate: 'a',
				type: 'image',
				tLoading: 'Loading image #%curr%...',
				mainClass: 'mfp-img-mobile',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1] // Will preload 0 - before current, and 1 after the current image
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
					titleSrc: function(item) {
						return item.el.attr('title') + '<small>by {{ $chefname }}</small>';
					}
				},
				callbacks: {
					beforeOpen: function() {
						if (!fixed) {
							var mp = $.magnificPopup.instance;
							mp.items.pop();
							mp.items.pop();
							mp.updateItemHTML();
						}
					}
				}
			});
			var date = new Date();
			date.setDate(date.getDate()+1);

			$('.datetimepicker').datetimepicker({
				pickDate: false
			});
			$('.date').datepicker({
				format: "dd/mm/yyyy",
				startDate: date
			});
			// This button will increment the value
			$('.qtyplus').click(function(e){
				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				fieldName = $(this).attr('field');
				// Get its current value
				var currentVal = parseInt($('input[name='+fieldName+']').val());
				// If is not undefined
				if (!isNaN(currentVal) && currentVal < {{ $maxpax }}) {
					// Increment
					$('input[name='+fieldName+']').val(currentVal + 1);
				} else {
					// Otherwise put a 0 there
					$('input[name='+fieldName+']').val({{ $maxpax }});
				}
			});
			// This button will decrement the value till 0
			$(".qtyminus").click(function(e) {
				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				fieldName = $(this).attr('field');
				// Get its current value
				var currentVal = parseInt($('input[name='+fieldName+']').val());
				// If it isn't undefined or its greater than 0
				if (!isNaN(currentVal) && currentVal > {{ $minpax }}) {
					// Decrement one
					$('input[name='+fieldName+']').val(currentVal - 1);
				} else {
					// Otherwise put a 0 there
					$('input[name='+fieldName+']').val({{ $minpax }});
				}
			});

			@if (Session::has('error_modal'))
			$("#enquiryModal").modal("show");
			@endif
		});
	</script>

@stop
