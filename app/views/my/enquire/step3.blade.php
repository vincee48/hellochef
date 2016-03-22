@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Step 3</h3>
					<p>Set up a menu</p>
					@include('alerts')
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">

						<div class="project">
							<h3>Create Menu</h3>							
							<p class="description">
								Please submit your first sample menu to best represent your creativity and specialties. After management approval you may continue to upload additional menus styles. i.e. canape, tasting menus, family style, fine dining, picnics. 
							</p>
							<div class="divider"></div>
							<div class="visit">
								<div class="form-group">
									@include('attachment.modal', array('pics' => $pics, 'url' => '/my/become-a-chef/step-3/attachments'))
								</div>							
								
								<hr/>
								
								{{ Form::model($leadMenu, array('route' => array('chef.enquire.step3'), 'role' => 'Form', 'class' => 'form-horizontal')) }}

								@include('my.settings.menu.details', array('menu' => $leadMenu))
								{{ Form::submit('Save', array('class' => 'btn btn-default')) }}

								{{ Form::close() }}
							</div>
						</div>
						<a href="/my/become-a-chef/step-2" class="button pull-left">Previous</a>
						@if ($lead->step3 && count($lead->getMenu()->getPictures()) > 0)
						<a href="/my/become-a-chef/step-4" class="button pull-right">Next</a>
						@endif
				</div>
			</div>
		</div>
	</div>

@stop
