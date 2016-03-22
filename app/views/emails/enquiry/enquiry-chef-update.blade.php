@extends('emails.layout')

@section('content')
		<h2>Dear {{ $chef }},</h2>

		<p>An enquiry for your menu {{ $menu }} by {{ $user }} has been updated.</p>

		<p>You may view the enquiry at <a href="{{ URL::to('/my/enquiries/' . $enquiryid) }}">{{ URL::to('/my/enquiries/' . $enquiryid) }}</a>.</p>

@stop
