@extends('emails.layout')

@section('content')
		<h2>Dear {{ $firstname }},</h2>

		<p>Your submission has been sent to the team</p>

		<p>Our team is currently reviewing your submission. We will get back to you shortly.</p>

@stop
