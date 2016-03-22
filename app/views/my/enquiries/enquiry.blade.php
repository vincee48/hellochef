@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Enquiry</h3>
					@include('alerts')
					<div class="row">
						<div class="col-md-12">
							<a href="{{ URL::previous() }}" class="btn btn-white btn-sm">Back</a>
							<button class="btn btn-primary" data-toggle="modal" data-target="#enquiryModal" >
								{{ $enquiry->chefid == Auth::id() ? 'Customize ' : 'View ' }}Menu
							</button>
							@if ($enquiry->approved)
								<span class="label label-success">Confirmed</span>
							@endif
							@if ($enquiry->paid)
								<span class="label label-success">Paid</span>
							@endif
						</div>
					</div>
				</div>
			</div>
			<hr/>
			@include('my.enquiries.details', array('enquiry' => $enquiry))

			<div class="row topPadding">
				<div class="col-md-12 text-center">
					<hr/>

			@if (!$enquiry->approved && $enquiry->chefid == Auth::id())
				<a href="/my/chef/enquiries/{{ $enquiry->id }}/confirm" class="btn btn-primary" onclick="return confirm('Are you sure you want to confirm enquiry? Changes cannot be made to menu items or event details after this.');">Confirm Enquiry</a>
				<div class="last-updated">Note: only confirm the enquiry when you have finalised ALL event details with diners.</div>
			@endif

			@if (!$enquiry->paid && $enquiry->approved && $enquiry->userid == Auth::id())
				<form action="" method="POST">
					<script
					src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-key="enter_stripe_pk"
					data-amount="{{ $enquiry->getTotalPriceInCents() }}"
					data-name="Hello Chef"
					data-description="{{ $enquiry->getMenuName() }} (${{ $enquiry->getTotalPrice() }})"
					data-image="/images/centred.png"
					data-email="{{ Auth::user()->email}}">
					</script>
				</form>
			@endif
				</div>

			</div>
		</div>
	</div>

	<div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="enquiryModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="enquiryModalLabel">{{ $enquiry->chefid == Auth::id() ? 'Customize ' : 'View ' }}Menu</h4>
				</div>
				<div class="modal-body">
					@foreach ($enquiry->getMenu()->getMenuItems() as $menuitem)
						<?php
						$history = $menuitem->getLatestHistory();
						$amended = Amendment::getAmendment($enquiry->id, $menuitem->id);
						$desc = $amended ? $amended->description : $history->description;
						?>
						<div class="row menu-display">
							<div class="col-sm-12 menuitem text-center">
								<div class="menuitem-name">{{ $history->name }}</div>
								@if ($enquiry->chefid == Auth::id() && !$enquiry->approved)
									{{ Form::open(array('route' => array('enquiry.amend', $enquiry->id))) }}
										{{ Form::hidden('menuitemid', $menuitem->id) }}
										@if ($amended)
											<div class="menuitem-desc strike">{{ $history->description }}</div>
										@endif
										<div class="menuitem-desc">{{ Form::text('description', $desc, array('class' => 'form-control')) }}</div>
										<br/>
										{{ Form::submit('Update', array('class' => 'btn btn-default')) }}
									{{ Form::close() }}
								@else
									@if ($amended)
										<div class="menuitem-desc strike">{{ $history->description }}</div>
										<div class="menuitem-desc">{{ $desc }}</div>
									@else
										<div class="menuitem-desc">{{ $desc }}</div>
									@endif
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')


<script type="text/javascript">
	<?php $menu = $enquiry->getMenu()->getLatestHistory(); ?>
	$(document).ready(function(){
		var date = new Date();
		date.setDate(date.getDate()+1);

		$('.datetimepicker').datetimepicker({
			pickDate: false,
			defaultDate: "{{ $enquiry->time }}"
		});

		$('.date').datepicker({
			format: "dd/mm/yyyy",
			startDate: date
		});

		$('#message-board').scrollTop($('#message-board')[0].scrollHeight);

		// This button will increment the value
		$('.qtyplus').click(function(e){
			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			fieldName = $(this).attr('field');
			// Get its current value
			var currentVal = parseInt($('input[name='+fieldName+']').val());
			// If is not undefined
			if (!isNaN(currentVal) && currentVal < {{ $menu->maxpax }}) {
				// Increment
				$('input[name='+fieldName+']').val(currentVal + 1);
			} else {
				// Otherwise put a 0 there
				$('input[name='+fieldName+']').val({{ $menu->maxpax }});
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
			if (!isNaN(currentVal) && currentVal > {{ $menu->minpax }}) {
				// Decrement one
				$('input[name='+fieldName+']').val(currentVal - 1);
			} else {
				// Otherwise put a 0 there
				$('input[name='+fieldName+']').val({{ $menu->minpax }});
			}
		});
	});
</script>
@stop
