@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Upload Menu Photos</h3>
					@include('alerts')
					<p><a href="{{ $back }}" class="btn btn-default">Back to Previous Page</a></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					@foreach ($pics as $pic)
					<div class="row">
						{{ Form::open(array('route' => array('menu.image.update', $pic->id), 'role' => 'form', 'class' => 'form-horizontal')) }}

						<div class="col-md-4 bottomPadding">
							{{ HTML::image("images/" . $pic->getDocument()->userid . "/" . $pic->getDocument()->filename, null, array('class' => 'img-responsive img-rounded')) }}
						</div>
						<div class="col-md-1">
							<a href="/images/{{ $pic->getDocument()->userid}}/{{$pic->getDocument()->filename}}/delete"><span class="glyphicon glyphicon-remove icon-red"></span></a>
						</div>
						<div class="col-md-7">
							<div class="row bottomPadding">
								<div class="form-group required">
									<div class="col-sm-2">
										{{ Form::label('description', 'Title', array('class' => 'control-label')) }}
									</div>
									<div class="col-sm-7">
										{{ Form::text('description', $pic->description, array('class'=>'form-control')) }}
									</div>
									<div class="col-sm-2">
										{{ Form::submit('Update', array('class' => 'btn btn-default')) }}										
									</div>
								</div>
							</div>
						</div>
					</div>

					{{ Form::close() }}
					@endforeach
					<hr/>
					{{ Form::open(array('files' => true, 'role' => 'form', 'class' => 'form-horizontal')) }}

					<div class="row">
						@if (!$errors->has('picture'))
						<div class="form-group">
						@else
						<div class="form-group has-error">
						@endif
							<div class="col-sm-2">
								{{ Form::label('picture', 'Images', array('class' => 'control-label')) }}
							</div>
							<div class="col-sm-7">
								{{ Form::file('picture', array('accept'=>'image/*')) }}
							</div>
							<div class="col-sm-3">
								{{ $errors->first('picture') }}
							</div>
						</div>
					</div>					
					
					<div class="row">
						@if (!$errors->has('description'))
						<div class="form-group required">
						@else
						<div class="form-group required has-error">
						@endif
							<div class="col-sm-2">
								{{ Form::label('description', 'Title', array('class' => 'control-label')) }}
							</div>
							<div class="col-sm-7">
								{{ Form::text('description', Input::old('description'), array('class'=>'form-control')) }}
							</div>
							<div class="col-sm-3">
								{{ $errors->first('description') }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<div class="submit col-sm-offset-2 col-sm-10">
								{{ Form::submit('Attach Image', array('class' => 'btn btn-primary')) }}
							</div>
						</div>
					</div>
					
					{{ Form::close() }}					

				</div>
			</div>
		</div>
	</div>

@stop
