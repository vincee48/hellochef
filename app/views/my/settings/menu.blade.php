<div class="col-md-12 menu">
	<div class="row">
		<div class="col-md-12 text-center">
			<p>
				<a href="/chef/{{ Auth::user()->chefname }}" class="btn btn-primary"><span>View Profile</span></a>
			</p>
		</div>
	</div>
	<hr/>
	<table class="table table-striped table-bordered">
		<thead>
			<tr><th>Title</th><th>Description</th><th>Cuisine</th><th>PAX</th><th>Price / Person</th><th>Options</th></tr>
		</thead>
		<tbody>
			@foreach ($menus as $menu)
				<?php $history = $menu->getLatestHistory() ?>
				<tr>
					<td>{{ $history->title }}</td>
					<td>{{ $history->description }}</td>
					<td>
					<ul class="tags">
						@foreach (explode(",", $history->tags ) as $tag)
							<li>{{ $tag }}</li>
						@endforeach
					</ul>
					</td>
					<td>{{ $history->minpax . " - " . $history->maxpax }}</td>
					<td>${{ $history->getPrice() }}</td>
					<td>
						<a href="/my/settings/menu/{{ $menu->id }}" class="btn btn-default">Edit</a>
						@if ($menu->active)
							<a href="/my/settings/menu/{{ $menu->id }}/unpublish" class="btn btn-danger">Hide</a>
						@else
							<a href="/my/settings/menu/{{ $menu->id }}/publish" class="btn btn-success">Show</a>
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<a href="/my/settings/menu/add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add</a>
	
	<script type="text/javascript">
	$(function() {
		$('.tags').tagit({
			readOnly: true
		});
		$('.tagit-new').remove();
	});
	</script>
	
</div>
