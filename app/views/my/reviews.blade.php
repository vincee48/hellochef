@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Pending reviews for {{ Auth::user()->username }}</h3>
					@include('alerts')
					<hr/>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					@if (Enquiry::getNumberOfPendingReviews(Auth::id()) > 0)
						@foreach ($pendingReviews as $enquiry)
							<h4>How did you enjoy the meal with Chef {{ $enquiry->getChefName() }}?</h4>
							<strong>Description:</strong>
							<ul>
								<li>Menu: {{ $enquiry->getMenuName() }}</li>
								<li>Party Size: {{ $enquiry->quantity }}</li>
								<li>Date: {{ $enquiry->getEnquiryDate() }}</li>
							</ul>

							<br/>
							{{ Form::open(array('class' => 'form-horizontal')) }}
								<div class="form-group">
									<div class="col-sm-2">
										{{ Form::label('summary', 'Summary', array('class' => 'control-label')) }}
									</div>
									<div class="col-sm-7">
										{{ Form::text('summary', Input::old('summary'), array('class' => 'form-control', 'placeholder' => 'Enter a summary of your experience...')) }}
									</div>
									<div class="col-sm-3">
										{{ $errors->first('summary') }}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2">
										{{ Form::label('content', 'Review', array('class' => 'control-label')) }}
									</div>
									<div class="col-sm-7">
										{{ Form::textarea('content', Input::old('content'), array('class' => 'form-control', 'placeholder' => 'Enter your review...')) }}
									</div>
									<div class="col-sm-3">
										{{ $errors->first('content') }}
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-2">
										{{ Form::label('thumbs', 'Opinion', array('class' => 'control-label')) }}
									</div>
									<div class="col-sm-1">
										<a href="#" id="thumbsup" class="selected-green"><span class="glyphicon glyphicon-thumbs-up glyphicon-lg"></span></a>
									</div>
									<div class="col-sm-offset-1 col-sm-8">
										<a href="#" id="thumbsdown"><span class="glyphicon glyphicon-thumbs-down glyphicon-lg"></span></a>
									</div>
								</div>
								{{ Form::hidden('negative', '0', array('id' => 'negative')) }}
								{{ Form::hidden('enquiryid', $enquiry->id) }}
								<div class="col-sm-offset-2 col-sm-10">
									{{ Form::submit("Submit Review", array('class' => 'btn btn-primary')) }}
								</div>
							{{ Form::close() }}
							<hr/>
						@endforeach
					@else
						<p>You have no pending reviews.</p>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script>
	$("#thumbsup").click(function () {
		$("#thumbsup").addClass("selected-green");
		$("#thumbsdown").removeClass("selected-red");
		$("#negative").val("0");
		return false;
	});

	$("#thumbsdown").click(function () {
		$("#thumbsup").removeClass("selected-green");
		$("#thumbsdown").addClass("selected-red");
		$("#negative").val("1");
		return false;
	});
</script>

@stop
