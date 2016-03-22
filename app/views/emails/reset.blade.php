@extends('emails.layout')

@section('content')
	<h2>Reset your password</h2>

	<div>
		<p>Hi {{ $firstname }}</p>
		<p></p>
		<p>You have requested to reset your password.</p>
		<p>Please click on {{ URL::to('/reset/' . $id . '/' . $reset) }} and follow the prompts to select a new password.<br/>
	</div>

@stop