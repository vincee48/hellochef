<?php
$messages = array_reverse(EmailEnquiry::getNonSystemMessages($enquiry->id));
?>

<div class="col-md-8">
	<div class="row">
		<h4>Message board</h4>
	</div>
	<div class="row message-board" id="message-board">
		@foreach ($messages as $message)
			<?php $email = $message->getEmail() ?>
			<div class="single-message">
				<div class="col-md-12">
					<strong>{{ $email->getFromUserName() }}:</strong>
				</div>

				<div class="col-md-12">
					{{ $email->getCreatedAt() }}
				</div>
				<div class="col-md-12">
					{{ $email->body }}
				</div>
			</div>
		@endforeach
	</div>
	<div class="row topPadding">
		<div class="col-md-12">
				{{ Form::open(array('route' => array('message-board.update', $email->id), 'class' => 'form-horizontal')) }}
					{{ Form::text('body', '', array('class' => 'form-control', 'placeholder' => 'Leave a message here')) }}
					<br/>
					<div class="text-center">
						{{ Form::submit('Send Reply', array('class' => 'btn btn-primary')) }}
					</div>
				{{ Form::close() }}
		</div>
	</div>
</div>

<div class="col-md-4 enquiry-overview">
	<h4>Enquiry Overview</h4>

	@if (!$enquiry->approved)
	{{ Form::open(array('route' => array('enquiry.update', $enquiry->id))) }}
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('from', 'From:', array('class' => 'control-label')) }}
			{{ $enquiry->getUserName() }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('menu', 'Menu:', array('class' => 'control-label')) }}
			<a href="{{ $enquiry->getMenuUrl() }}">{{ $enquiry->getMenuName() }}</a>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('quantity', 'Party Size:', array('class' => 'control-label')) }}
			{{ Form::button('-', array('class' => 'qtyminus', 'field' => 'quantity')) }}
			{{ Form::text('quantity', $enquiry->quantity, array('class' => 'qty', 'id' => 'quantity')) }}
			{{ Form::button('+', array('class' => 'qtyplus', 'field' => 'quantity')) }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('enquirydate', 'Preferred Date:', array('class' => 'control-label')) }}
			<div class="input-group date">
				<input type="text" value="{{ $enquiry->getEnquiryDate() }}" name="enquirydate" class="form-control" placeholder="Select a date">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('time', 'Preferred Time:', array('class' => 'control-label')) }}
			<div class='input-group datetimepicker'>
				<input type='text' name='time' class="form-control" placeholder="Enter time" />
				<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
			</div>
		</div>
	</div>

	@if ($enquiry->getProfile()->useownvenue)
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::checkbox('usechefvenue', '1', $enquiry->usechefvenue) }}
			{{ Form::label('usechefvenue', 'Use Chef Venue') }}
		</div>
	</div>
	@endif

	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('venue', 'Venue:', array('class' => 'control-label')) }}
			{{ Form::textarea('venue', $enquiry->venue, array('class' => 'form-control', 'rows' => '1', 'placeholder' => 'Enter venue information here...')) }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('specialreq', 'Special Requirements:', array('class' => 'control-label')) }}
			{{ Form::textarea('specialreq', $enquiry->specialreq, array('class' => 'form-control', 'rows' => '1', 'placeholder' => 'Enter special requirements here...')) }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('additionalinfo', 'Additional Information:',  array('class' => 'control-label')) }}
			{{ Form::textarea('additionalinfo', $enquiry->additionalinfo, array('class' => 'form-control', 'rows' => '1', 'placeholder' => 'Enter additional information here...')) }}
		</div>
	</div>
	
	@if ($enquiry->chefid == Auth::id()) 
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('price', 'Price Per Person:',  array('class' => 'control-label')) }}
			<div class="input-group">
				<span class="input-group-addon">$</span>
				{{ Form::text('price', $enquiry->price, array('class' => 'form-control')) }}
			</div>
		</div>
	</div>
	
	<div class="col-xs-12">
		<div class="form-group">
			{{ Form::label('additionalcost', 'Additional Costs:',  array('class' => 'control-label')) }}
			<div class="input-group">
				<span class="input-group-addon">$</span>
				{{ Form::text('additionalcost', $enquiry->additionalcost, array('class' => 'form-control')) }}
			</div>
		</div>
	</div>
	@endif
	
	<div class="col-xs-12">
		<label class="control-label">Event Price:</label>
	</div>
	
	<div class="col-xs-12">
		<div class="col-xs-8 border-right">
			{{ $enquiry->quantity }} x ${{ $enquiry->getPrice() }}
		</div>
		<div class="col-xs-4">
			${{ $enquiry->getPriceLessAdditional() }}
		</div>
		<div class="col-xs-8 border-right padding-bottom">
			Additional Costs
		</div>
		<div class="col-xs-4 padding-bottom">				
			${{ $enquiry->getAdditionalCost() }}
		</div>
		<div class="col-xs-8 border-right border-top padding-top">
			Total
		</div>
		<div class="col-xs-4 border-top padding-top">
			${{ $enquiry->getTotalPrice() }}		
		</div>
	</div>	
	
	<div class="col-xs-12">	
		<hr/>
		<div class="form-group text-center">
			{{ Form::submit('Update Enquiry', array('class' => 'btn btn-primary')) }}
			<br/>
			<span class="last-updated">Last Updated: {{ $enquiry->getUpdatedAt() }}</span>
		</div>
	</div>
	{{ Form::close() }}

	@else

	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">From:</label>
			{{ $enquiry->getUserName() }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Menu:</label>
			<a href="{{ $enquiry->getMenuUrl() }}">{{ $enquiry->getMenuName() }}</a>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Party Size:</label>
			{{ $enquiry->quantity }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Preferred Date:</label>
			{{ $enquiry->getEnquiryDate() }}
		</div>
	</div>

	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Preferred Time:</label>
			{{ $enquiry->getTime() }}
		</div>
	</div>

	@if ($enquiry->getProfile()->useownvenue)
	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Use Chef Venue:</label>
			{{ $enquiry->usechefvenue ? "Yes" : "No" }}
		</div>
	</div>
	@endif

	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Venue:</label>
			{{ $enquiry->venue }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Special Requirements:</label>
			{{ $enquiry->specialreq }}
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
			<label class="control-label">Additional Information:</label>
			{{ $enquiry->additionalinfo }}
		</div>
	</div>
	
	<div class="col-xs-12">
		<label class="control-label">Event Price:</label>
	</div>
	
	<div class="col-xs-12">
		<div class="col-xs-8 border-right">
			{{ $enquiry->quantity }} x ${{ $enquiry->getPrice() }}
		</div>
		<div class="col-xs-4">
			${{ $enquiry->getPriceLessAdditional() }}
		</div>
		<div class="col-xs-8 border-right padding-bottom">
			Additional Costs
		</div>
		<div class="col-xs-4 padding-bottom">
			${{ $enquiry->getAdditionalCost() }}
		</div>
		<div class="col-xs-8 border-right border-top padding-top">
			Total
		</div>
		<div class="col-xs-4 border-top padding-top">
			${{ $enquiry->getTotalPrice() }}		
		</div>
	</div>	
		
	<div class="col-xs-12">
		<div class="form-group text-center">
			<span class="last-updated">Last Updated: {{ $enquiry->getUpdatedAt() }}</span>
		</div>
	</div>
	@endif
</div>
