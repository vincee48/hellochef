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
		<strong>Cuisines</strong>
	</li>
</ol>
@endsection

@section('content')
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Cuisines</h5>
				</div>
				<div>
					<div class="ibox-content">
						<table class="table table-striped table-bordered table-hover dataTable" >
							<thead>
								<tr>
									<th>Name</th>
									<th>Created At</th>								
									<th>Active</th>
									<th>Options</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($cuisines as $cuisine)								
								<tr>
									<td>{{ $cuisine->name }}</td>
									<td>{{ $cuisine->created_at->format('d/m/Y g:i A') }}</td>							
									<td><span class="invis">{{ $cuisine->active ? 'cell-success' : 'cell-error'}}"></span>{{ $cuisine->active ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
									<td>
										@if ($cuisine->active)
										<a href="/admin/cuisines/{{ $cuisine->id }}/unpublish" class="btn-sm btn-danger">Hide</a>
										@else
										<a href="/admin/cuisines/{{ $cuisine->id }}/publish" class="btn-sm btn-success">Show</a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>                    
						</table>
						<a href="/admin/cuisines/add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add</a>
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