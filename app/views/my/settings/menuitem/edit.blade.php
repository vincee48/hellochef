@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">		
			<div class="row header">
				<div class="col-md-12">
					<h3>Edit Menu Item</h3>
					@include('alerts')
					<p><a href="{{ $back }}" class="btn btn-default">Back to Previous Page</a></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					@if ($enquire)
					{{ Form::model($history, array('route' => array('chef.menuitem.edit', $item->id), 'role' => 'Form', 'class' => 'form-horizontal', 'files' => true)) }}
					@else
					{{ Form::model($history, array('role' => 'Form', 'class' => 'form-horizontal', 'files' => true)) }}
					@endif
						@include('chef.forms.menuitem', array('item' => $item))
						
						<div class="form-group">
							<div class="submit col-sm-offset-2 col-sm-10">
								{{ Form::submit('Update') }}
							</div>
						</div>
						
					{{ Form::close() }}
				</div>
			</div>						
		</div>
	</div>
	
@stop
