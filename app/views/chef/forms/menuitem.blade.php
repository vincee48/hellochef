@if (!$errors->has('name'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif
	<div class="col-sm-4">
		{{ Form::label('name', 'Name', array('class' => 'control-label')) }}
	</div>
	<div class="col-sm-8">
		{{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Enter menu item name', 'id' => 'name')) }}
	</div>
</div>

@if (!$errors->has('description'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif
	<div class="col-sm-4">
		{{ Form::label('description', 'Description', array('class' => 'control-label')) }}
	</div>
	<div class="col-sm-8">
		{{ Form::text('description', Input::old('description'), array('class' => 'form-control', 'placeholder' => 'Enter menu item description', 'id' => 'description')) }}
	</div>	
</div>