@extends('admin.dashboard-layout')

@section('breadcrumb')
<h2>Enquiries</h2>
<ol class="breadcrumb">
	<li>
		<a href="/">Home</a>
	</li>
	<li>
		<a href="/admin/dashboard">Dashboard</a>
	</li>
	<li>
		<strong>Enquiries</strong>
	</li>
</ol>
@endsection

@section('content')
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Enquiries</h5>
				</div>
				<div>
					<div class="ibox-content">
						<table class="table table-striped table-bordered table-hover dataTable" >
							<thead>
								<tr>
									<th>User</th>
									<th>Chef</th>
									<th>Menu</th>
									<th>Quantity</th>
									<th>Price / Person</th>
									<th>Enquiry Date</th>
									<th>Approved</th>
									<th>Paid</th>
									<th>Created At</th>									
								</tr>
							</thead>
							<tbody>
								@foreach ($enquiries as $enquiry)								
								<tr>
									<td>{{ $enquiry->getUserName() }}</td>
									<td><a href="/admin/chef/{{ $enquiry->getChefName() }}">{{ $enquiry->getChefName() }}</a></td>
									<td>{{ $enquiry->getMenuName() }}</td>
									<td>{{ $enquiry->quantity }}</td>
									<td>{{ $enquiry->price }}</td>
									<td>{{ $enquiry->getEnquiryDate() }}</td>
									<td><span class="invis">{{ $enquiry->approved ? '1' : '0'}}</span>{{ $enquiry->approved ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
									<td><span class="invis">{{ $enquiry->paid ? '1' : '0'}}</span>{{ $enquiry->paid ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>									
									<td>{{ $enquiry->getCreatedAt() }}</td>
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