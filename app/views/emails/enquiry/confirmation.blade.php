@extends('emails.layout')

@section('content')
		<h2>Dear {{ $user }},</h2>

		<p>{{ $chef }} has confirmed your enquiry!</p>

		<p>You may view the enquiry at <a href="{{ URL::to('/my/enquiries/' . $enquiryid) }}">{{ URL::to('/my/enquiries/' . $enquiryid) }}</a>.</p>

@stop
