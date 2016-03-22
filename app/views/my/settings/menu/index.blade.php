@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<?php
	$history = $menu->getLatestHistory();
	$menuitems = $menu->getAllMenuItems();
	?>
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Menu</h3>
					@include('alerts')
					<p><a href="/my/settings/menu" class="btn btn-default">Back to Settings</a>
					@if ($menu->active)
						<a href="/my/settings/menu/{{ $menu->id }}/unpublish" class="btn btn-danger">Hide</a>
					@else
						<a href="/my/settings/menu/{{ $menu->id }}/publish" class="btn btn-success">Show</a>
					@endif</p>
					<hr/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group text-center">
						@include('attachment.modal', array('pics' => $pics, 'url' => '/my/settings/menu/' . $menu->id .'/attachments'))
					</div>	
					
					<hr/>
					{{ Form::model($history, array('role' => 'form', 'class' => 'form-horizontal')) }}

						@include('my.settings.menu.details')
						<div class="form-group">
							<div class="col-md-offset-2 col-md-7">
								{{ Form::submit('Update Menu', array('class' => 'btn btn-primary')) }}
							</div>
						</div>
					{{ Form::close() }}

					<hr/>

					<h3>Menu Items</h3>
					<table class="table table-striped table-bordered">
						<thead>
							<tr><th>Name</th><th>Description</th><th>Options</th></tr>
						</thead>
						<tbody>
							@foreach ($menuitems as $item)
								<?php $history = $item->getLatestHistory() ?>
								<tr>
									<td>{{ $history->name }}</td>
									<td>{{ $history->description }}</td>
									<td>
										<button class="btn btn-default" data-toggle="modal" data-target="#editMenuItem{{ $item->id }}">
											Edit
										</button>
										
										<div class="modal fade" id="editMenuItem{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editMenuItemLabel{{$item->id}}" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">								
													{{ Form::model($history, array('url' => '/my/settings/menu/'.$menu->id.'/'.$item->id, 'role' => 'Form', 'class' => 'form-horizontal')) }}

													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<h4 class="modal-title" id="editMenuItemLabel{{$item->id}}">Edit Menu Item</h4>
													</div>
													<div class="modal-body">														
														@include('chef.forms.menuitem', array('item' => $item))
																													
													</div>
													<div class="modal-footer">
														<div class="form-group">
															<div class="submit col-sm-offset-2 col-sm-10">
																{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
															</div>
														</div>
													</div>

													{{ Form::close() }}
												</div>
											</div>
										</div>
										
										@if ($item->active)
											<a href="/my/settings/menu/{{ $menu->id }}/{{ $item->id }}/unpublish" class="btn btn-danger">Hide</a>
										@else
											<a href="/my/settings/menu/{{ $menu->id }}/{{ $item->id }}/publish" class="btn btn-success">Show</a>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<button class="btn btn-primary" data-toggle="modal" data-target="#addMenuItem">
						<span class="glyphicon glyphicon-plus"></span> Add Menu Item
					</button>
					
					<div class="modal fade" id="addMenuItem" tabindex="-1" role="dialog" aria-labelledby="addMenuItemLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">								
								{{ Form::open(array('url' => '/my/settings/menu/'.$menu->id.'/add', 'role' => 'form', 'class' => 'form-horizontal')) }}								

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="addMenuItemLabel">Add Menu Item</h4>
								</div>
								<div class="modal-body">
									@include('chef.forms.menuitem', array('item' => new MenuItem, 'history' => null))
								</div>
								<div class="modal-footer">
									<div class="form-group">
										<div class="submit col-sm-offset-2 col-sm-10">
											{{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
										</div>
									</div>
								</div>

								{{ Form::close() }}
							</div>
						</div>
					</div>				

				</div>
			</div>
		</div>
	</div>

@stop
