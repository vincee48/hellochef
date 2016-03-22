@extends('emails.layout')

@section('content')
		<h2>A new lead has been submitted!</h2>

		<p>A user, <a href="{{ URL::to('/admin/users/' . $userid) }}"> {{ $email . ' - ' . $name }}</a> has submitted a new lead! Please <a href="{{ URL::to('/admin/leads/' .  $leadid) }}">click here to preview and qualify the lead</a>.</p>

@stop
