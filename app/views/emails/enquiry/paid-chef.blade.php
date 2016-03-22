@extends('emails.layout')

@section('content')
		<h2>Dear {{ $chef }},</h2>

		<p>{{ $user }} has paid for the enquiry for your menu {{ $menu }}!</p>

		<p>Size: {{ $quantity }}</p>
		<p>Date: {{ $date }}</p>
		<p>Time: {{ $time }}</p>
		<p>Use Chef Venue: {{ $usechefvenue == 1 ? 'Yes' : 'No' }}</p>
		<p>Venue: {{ $venue }}</p>
		<p>Special Requirements: {{ $reqs }}</p>
		<p>Additional Information: {{ $info }}</p>
		<p>Price / Person: ${{ number_format($price, 2) }}</p>
		<p>Surcharge: ${{ number_format($surcharge, 2) }}</p>
		<p>Total: ${{ number_format($total, 2) }}</p>

@stop
