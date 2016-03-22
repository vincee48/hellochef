@extends('emails.layout')

@section('content')
		<h2>Confirm your email</h2>

		<div>
			To confirm your email, please go to this link here {{ URL::to('/confirm/' . $id . '/' . $confirmation) }}.<br/>
		</div>
@stop
