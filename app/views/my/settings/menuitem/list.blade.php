<table class="table table-striped table-bordered">
	<thead>
		<tr><th>Name</th><th>Description</th><th>Options</th></tr>								
	</thead>
	<tbody>
		@foreach ($menuitems as $item)
			@if ($item->active)
			<?php $history = $item->getLatestHistory() ?>
			<tr>
				<td>{{ $history->name }}</td>
				<td>{{ $history->description }}</td>
				<td>
					{{ Form::open(array('url' => '/my/become-a-chef/step-4/action')) }}
						{{ Form::hidden('id', $item->id) }}
						<input type="submit" name="action" value="Edit" class="btn btn-default"> <input type="submit" name="action" value="Delete" class="btn btn-danger">
					{{ Form::close() }}
				</td>
			</tr>
			@endif
		@endforeach
	</tbody>
</table>
