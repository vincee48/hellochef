@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div class="showcase">
		<div class="container">			
			@include('widgets.gallery', array('max' => 24, 'searchBar' => true))
			</div>
		</div>
	</div>
@stop
