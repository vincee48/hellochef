@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">		
			<div class="row header">
				<div class="col-md-12">
					<h3>Add New Menu Item</h3>
					@include('alerts')
					<p><a href="{{$back}}" class="btn btn-default">Back to Previous Page</a></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					@if ($enquire)
					{{ Form::open(array('route' => array('chef.menuitem.add'), 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
					@else
					{{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
					@endif
						@include('chef.forms.menuitem', array('item' => new MenuItem))

						<div class="form-group">
							<div class="submit col-sm-offset-2 col-sm-10">
								{{ Form::submit('Add') }}
							</div>
						</div>
						
					{{ Form::close() }}
				</div>
			</div>						
		</div>
	</div>
	
@stop
