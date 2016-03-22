@if (!$errors->has('title'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif			
	<div class="col-sm-2">
		{{ Form::label('title', 'Title', array('class' => 'pull-left control-label')) }} 
	</div>	
	<div class="col-sm-7">
		{{ Form::text('title', Input::old('title'), array('class' => 'form-control', 'placeholder' => 'Enter menu title', 'id' => 'title')) }}
	</div>
	<div class="col-sm-3">
		{{ $errors->first('title') }}
	</div>
</div>

@if (!$errors->has('description'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif			
	<div class="col-sm-2">
		{{ Form::label('description', 'Description', array('class' => 'pull-left control-label')) }} 
	</div>	
	<div class="col-sm-7">
		{{ Form::text('description', Input::old('description'), array('class' => 'form-control', 'placeholder' => 'Enter menu description', 'id' => 'description')) }}
	</div>
	<div class="col-sm-3">
		{{ $errors->first('description') }}
	</div>
</div>

<?php
/*
@if (!$errors->has('cuisineid'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif
	<div class="col-sm-2">
		{{ Form::label('cuisineid', 'Cuisine', array('class' => 'pull-left control-label')) }} 
	</div>	
	<div class="col-sm-7">
		{{ Form::select('cuisineid', Cuisine::getOrderedArray(), $menu ? $menu->cuisineid : '', array('class' => 'form-control')) }}
	</div>
	<div class="col-sm-3">
		{{ $errors->first('cuisineid') }}
	</div>
</div>
*/
?>

@if (!$errors->has('minpax'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif
	<div class="col-sm-2">
		{{ Form::label('minpax', 'Min PAX', array('class' => 'pull-left control-label')) }} 
	</div>
	<div class="col-sm-7">	
		{{ Form::text('minpax', Input::old('minpax'), array('class' => 'form-control', 'placeholder' => 'Enter minimum number of people', 'id' => 'minpax')) }}
	</div>							
	<div class="col-sm-3">
		{{ $errors->first('minpax') }}
	</div>
</div>

@if (!$errors->has('maxpax'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif
	<div class="col-sm-2">
		{{ Form::label('maxpax', 'Max PAX', array('class' => 'pull-left control-label')) }} 
	</div>
	<div class="col-sm-7">	
		{{ Form::text('maxpax', Input::old('maxpax'), array('class' => 'form-control', 'placeholder' => 'Enter maximum number of people', 'id' => 'maxpax')) }}
	</div>							
	<div class="col-sm-3">
		{{ $errors->first('maxpax') }}
	</div>
</div>

@if (!$errors->has('price'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif
	<div class="col-sm-2">
		{{ Form::label('price', 'Price/Person', array('class' => 'pull-left control-label')) }} 
	</div>
	<div class="col-sm-7">	
		<div class="input-group">
			<div class="input-group-addon">$</div>
			{{ Form::text('price', Input::old('price'), array('class' => 'form-control', 'placeholder' => 'Price per person', 'id' => 'price')) }}
		</div>
	</div>							
	<div class="col-sm-3">
		{{ $errors->first('price') }}
	</div>
</div>

@if (!$errors->has('tags'))
<div class="form-group required">
@else
<div class="form-group required has-error">
@endif
	<div class="col-sm-2">
		{{ Form::label('tags', 'Cuisine Types', array('class' => 'pull-left control-label')) }} 
	</div>
	<div class="col-sm-7">	
		{{ Form::hidden('tags', Input::old('tags'), array('class' => 'form-control', 'id' => 'tags')) }}
		<ul id="tags"></ul>
	</div>							
	<div class="col-sm-3">
		{{ $errors->first('tags') }}
		<span class="label label-danger" id="tagError" style="display:none;"><span class="glyphicon glyphicon-exclamation-sign"></span> You may have a maximum of 5 tags.</span>
	</div>
</div>

<script type="text/javascript">
$(function() {
	var availableTags = {{ Cuisine::getOrderedJson() }};
	$('#tags').tagit({
		availableTags: availableTags,
		placeholderText: "add cuisine type",
		tagLimit: 5,
		beforeTagAdded: function(event, ui) {
			if ($.inArray( ui.tagLabel, availableTags ) == -1) {				
				return false;
			}
		},
		onTagLimitExceeded: function(event, ui) {
			$('#tagError').css('display', 'block');
		}
	});
});
</script>