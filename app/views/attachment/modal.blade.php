<div class="row">
@foreach ($pics as $pic)
	<div class="col-md-4 bottomPadding">
		<a href="/images/{{ $pic->getDocument()->userid}}/{{$pic->getDocument()->filename}}/delete"><span class="glyphicon glyphicon-remove icon-red"></span></a>
		{{ HTML::image("images/" . $pic->getDocument()->userid . "/" . $pic->getDocument()->filename, null, array('class' => 'img-responsive img-rounded')) }}
	</div>
@endforeach
</div>

<button class="btn btn-primary" data-toggle="modal" data-target="#addMenuImages">
	<span class="glyphicon glyphicon-plus"></span> Add Menu Images
</button>

<div class="modal fade" id="addMenuImages" tabindex="-1" role="dialog" aria-labelledby="addMenuImagesLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">								
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="addMenuImagesLabel">Add Menu Images</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => $url, 'files' => true, 'role' => 'form', 'class' => 'form-horizontal')) }}

				<div class="row">
					<div class="form-group">					
						<div class="col-sm-12">
							Add multiple images at a time to your menu.
						</div>
					</div>
				</div>
				<p></p>
				<div class="row">
					@if (!$errors->has('pics'))
					<div class="form-group">
					@else
					<div class="form-group has-error">
					@endif
						<div class="col-sm-3">
							{{ Form::label('pics[]', 'Images', array('class' => 'control-label')) }}
						</div>
						<div class="col-sm-9">
							{{ Form::file('pics[]', array('accept'=>'image/*', 'multiple' => true)) }}
						</div>
					</div>
				</div>			
				
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="submit col-sm-offset-2 col-sm-10">
						{{ Form::submit('Attach Images', array('class' => 'btn btn-primary')) }}
					</div>
				</div>
			</div>

			{{ Form::close() }}
		</div>
	</div>
</div>