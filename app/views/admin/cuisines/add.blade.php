@extends('admin.dashboard-layout')

@section('breadcrumb')
<h2>Cuisines</h2>
<ol class="breadcrumb">
	<li>
		<a href="/">Home</a>
	</li>
	<li>
		<a href="/admin/dashboard">Dashboard</a>
	</li>
	<li>
		<a href="/admin/cuisines">Cuisines</a>
	</li>
	<li>
		<strong>Add</strong>
	</li>
</ol>
@endsection

@section('content')
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Add Cuisine</h5>
				</div>
				<div>
					<div class="ibox-content">
						<a href="/admin/cuisines" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
						{{ Form::open(array('class' => 'form-horizontal')) }}
							<div class="row">
								<div class="col-md-12">
									@if (!$errors->has('name'))
									<div class="form-group required">
									@else
									<div class="form-group required has-error">
									@endif			
										<div class="col-sm-2">
											{{ Form::label('name', 'Cuisine name', array('class' => 'control-label')) }} 
										</div>	
										<div class="col-sm-7">
											{{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Enter cuisine name here', 'id' => 'name')) }}
										</div>
										<div class="col-sm-3">
											{{ $errors->first('name') }}
										</div>
									</div>
								</div>

								<div class="col-md-offset-2 col-md-10">
									{{ Form::submit('Add Cuisine') }}
								</div>
							</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
        $(document).ready(function() {
            $('.dataTable').dataTable({
				"order": []
			});
        });
    </script>
@stop