@extends('emails.layout')

@section('content')
		<h2>Dear {{ $firstname }},</h2>

		<p>Your Chef's Profile has now been approved.</p>
		<p>Your unique URL is {{ URL::to('/chef/' . $chefname) }}.</p>
		<p>Share with your friends and family now and spread the word!</p>

@stop
