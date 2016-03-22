@extends('layout')

@section('body-id')
	portfolio
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Step 4</h3>
					<p>Set up your menu items</p>
					@include('alerts')
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="project">
						<h3>Menu items</h3>
						<p class="description">
							Create your menu items here.
						</p>
						<div class="divider"></div>
						<div class="visit">
							
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
															{{ Form::model($history, array('url' => '/my/become-a-chef/step-4/edit/'.$item->id, 'role' => 'Form', 'class' => 'form-horizontal')) }}

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
													<a href="/my/become-a-chef/step-4/{{ $lead->getMenu()->id }}/{{ $item->id }}/unpublish" class="btn btn-danger">Hide</a>												
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>

							
							<div class="row">
																
								<button class="btn btn-primary" data-toggle="modal" data-target="#addMenuItem">
									<span class="glyphicon glyphicon-plus"></span> Add Menu Item
								</button>
								
								<div class="modal fade" id="addMenuItem" tabindex="-1" role="dialog" aria-labelledby="addMenuItemLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">								
											{{ Form::open(array('url' => '/my/become-a-chef/step-4/add', 'role' => 'form', 'class' => 'form-horizontal')) }}								

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
					<a href="/my/become-a-chef/step-3" class="button pull-left">Previous</a>
					@if (count($menuitems) > 0)
					{{ Form::open(array('url' => '/my/become-a-chef/step-4/submit')) }}
						<input class="button pull-right" type="submit" name="action" value="Next">
					{{ Form::close() }}
					@endif
				</div>
			</div>
		</div>
	</div>
@stop
