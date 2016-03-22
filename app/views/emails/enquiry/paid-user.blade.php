@extends('emails.layout')

@section('content')
		<h2>Dear {{ $user }},</h2>

		<p>Thank you for your payment with Hello Chef!</p>

		<p>{{ $chef }} has approved their availability during that time to cook you the feast to your liking.</p>

		<h3>{{ $menu }}</h3>
		<p>Size: {{ $quantity }}</p>
		<p>Date: {{ $date }}</p>
		<p>Time: {{ $time }}</p>
		<p>Use Chef Venue: {{ $usechefvenue == 1 ? 'Yes' : 'No' }}</p>
		<p>Venue: {{ $venue }}</p>
		<p>Special Requirements: {{ $reqs }}</p>
		<p>Additional Information: {{ $info }}</p>

		<p>We hope you enjoy your meal!</p>

@stop
