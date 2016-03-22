@extends('emails.layout')

@section('content')
		<h2>Dear {{ $user }},</h2>

		<p>Thank you for your enquiry. {{ $chef }} will contact you shortly.</p>

		<p>Size: {{ $quantity }}</p>
		<p>Date: {{ $date }}</p>
		<p>Time: {{ $time }}</p>
		<p>Use Chef Venue: {{ $usechefvenue == 1 ? 'Yes' : 'No' }}</p>
		<p>Venue: {{ $venue }}</p>
		<p>Special Requirements: {{ $reqs }}</p>
		<p>Additional Information: {{ $info }}</p>
		
		<p>You may view the enquiry at <a href="{{ URL::to('/my/enquiries/' . $enquiryid) }}">{{ URL::to('/my/enquiries/' . $enquiryid) }}</a></p>.

@stop
