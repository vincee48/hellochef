@extends('admin.dashboard-layout')

@section('breadcrumb')
<h2>Users</h2>
<ol class="breadcrumb">
	<li>
		<a href="/">Home</a>
	</li>
	<li>
		<a href="/admin/dashboard">Dashboard</a>
	</li>
	<li>
		<strong>Users</strong>
	</li>
</ol>
@endsection

@section('content')
<div class="col-lg-12">
	<div class="ibox float-e-margins">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Users</h5>
			</div>
			<div>
				<div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTable" >
						<thead>
							<tr>
								<th>Email</th>
								<th>Chef</th>
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Type</th>
								<th>Active</th>
								<th>Updated At</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
							<?php $history = $user->getLatestHistory() ?>
							<tr>
								<td><a href="/admin/users/{{ $user->id }}">{{ $user->email }}</a></td>
								<td><a href="/admin/chef/{{ $user->chefname }}">{{ $user->chefname }}</a></td>
								<td>{{ $history->firstname }}</td>
								<td>{{ $history->middlename }}</td>
								<td>{{ $history->lastname }}</td>
								<td>{{ $user->type }}</td>
								<td><span class="invis">{{ $user->active ? '1' : '0'}}</span>{{ $user->active ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
								<td>{{ $history->updated_at->format('d/m/Y g:i A') }}</td>
								<td>{{ $user->created_at->format('d/m/Y g:i A') }}</td>
							</tr>
							@endforeach
						</tbody>
                    </table>

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
