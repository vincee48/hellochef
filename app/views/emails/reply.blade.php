@extends('emails.layout')

@section('content')
		<h2>Dear {{ $user }},</h2>

		<p>You have received a new message from {{ $fromuser }}:</p>

		<em>{{ $body }}</em>

		@if ($enq)
		<p>You may view and reply to this message at {{ URL::to('/my/enquiries/' . $enq) }}.
		@endif
@stop
