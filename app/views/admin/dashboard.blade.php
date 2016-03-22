@extends('admin.dashboard-layout')

@section('breadcrumb')
<h2>Dashboard</h2>
<ol class="breadcrumb">
	<li>
		<a href="/">Home</a>
	</li>
	<li class="active">
		<strong>Dashboard</strong>
	</li>
</ol>
@endsection

@section('content')
<div class="col-lg-12">
	<div class="ibox float-e-margins">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Overview</h5>
			</div>
			<div>
				<div class="ibox-content">
					<div class="row">
						<a class="col-lg-3 btn btn-primary" href="/admin/leads">
							<span class="fa fa-laptop"></span> Leads
						</a>
						<a class="col-lg-offset-1 col-lg-3 btn btn-primary" href="/admin/enquiries">
							<span class="fa fa-credit-card"></span> Enquiries
						</a>
						<a class="col-lg-offset-1 col-lg-3 btn btn-primary" href="/admin/users">
							<span class="fa fa-users"></span> Users
						</a>				
						<a class="col-lg-3 btn btn-primary" href="/admin/mailbox">
							<span class="fa fa-envelope"></span> Mailbox
						</a>
						<a class="col-lg-offset-1 col-lg-3 btn btn-primary" href="/admin/cuisines">
							<span class="fa fa-cutlery"></span> Cuisine
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
@stop