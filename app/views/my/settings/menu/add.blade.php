@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">		
			<div class="row header">
				<div class="col-md-12">
					<h3>Menu</h3>
					@include('alerts')
					<p><a href="/my/settings/menu" class="btn btn-default">Back to Settings</a></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">					
					{{ Form::open(array('role' => 'form', 'class' => 'form-horizontal')) }}
												
						@include('my.settings.menu.details', array('menu' => new Menu))
						<div class="form-group">
							<div class="col-md-offset-2 col-md-7">
								{{ Form::submit('Add Menu', array('class' => 'btn btn-primary')) }}
							</div>
						</div>
					{{ Form::close() }}
					
				</div>
			</div>						
		</div>
	</div>
	
@stop
