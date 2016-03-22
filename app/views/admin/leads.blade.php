@extends('admin.dashboard-layout')

@section('breadcrumb')
<h2>Leads</h2>
<ol class="breadcrumb">
	<li>
		<a href="/">Home</a>
	</li>
	<li>
		<a href="/admin/dashboard">Dashboard</a>
	</li>
	<li>
		<strong>Leads</strong>
	</li>
</ol>
@endsection

@section('content')
<div class="col-lg-12">
	<div class="ibox float-e-margins">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Leads</h5>
			</div>
			<div>
				<div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTable" >
						<thead>
							<tr>
								<th>User</th>
								<th>Chef Handle</th>
								<th>Step 1</th>
								<th>Step 2</th>
								<th>Step 3</th>
								<th>Step 4</th>
								<th>Qualified</th>
								<th>Created At</th>
								<th>View</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($leads as $lead)
							<tr>
								<td><a href="/admin/users/{{ $lead->userid }}">{{ $lead->getUser()->email }}</a></td>
								<td>{{ $lead->chefname }}</td>
								<td><span class="invis">{{ $lead->step1 ? '1' : '0'}}</span>{{ $lead->step1 ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
								<td><span class="invis">{{ $lead->step2 ? '1' : '0'}}</span>{{ $lead->step2 ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
								<td><span class="invis">{{ $lead->step3 ? '1' : '0'}}</span>{{ $lead->step3 ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
								<td><span class="invis">{{ $lead->step4 ? '1' : '0'}}</span>{{ $lead->step4 ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
								<td><span class="invis">{{ $lead->qualified ? '1' : '0'}}</span>{{ $lead->qualified ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
								<td>{{ $lead->created_at->format('d/m/Y g:i A') }}</td>
								<td><a href="/admin/leads/{{ $lead->id }}">{{ $lead->step4 && !$lead->qualified ? 'Preview' : 'View' }}</a></td>
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
