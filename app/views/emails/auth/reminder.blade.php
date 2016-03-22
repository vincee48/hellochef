@extends('emails.layout')

@section('content')
		<h2>Password Reset</h2>

		<div>
			To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.<br/>
			This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
		</div>

@stop
