<?php $history = $user->getLatestHistory(); ?>
@extends('admin.dashboard-layout')

@section('breadcrumb')
<h2>User</h2>
<ol class="breadcrumb">
	<li>
		<a href="/">Home</a>
	</li>
	<li>
		<a href="/admin/dashboard">Dashboard</a>
	</li>
	<li>
		<a href="/admin/users">Users</a>
	</li>
	<li>
		<strong>Details</strong>
	</li>
</ol>
@endsection

@section('content')
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>User</h5>
				</div>
				<div>
					<div class="ibox-content">
						<a href="{{ URL::previous() }}" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
						<br/><br/>
						<div class="row">						
							<div class="col-xs-3">
								<strong>Email:</strong>
							</div>
							<div class="col-xs-9">
								{{ $user->email }}
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-3">
								<strong>Chef Name:</strong>
							</div>
							<div class="col-xs-9">
								<a href="/chef/{{ $user->chefname }}">{{ $user->chefname }}</a>
							</div>			
						</div>
						
						<div class="row">	
							<div class="col-xs-3">
								<strong>First Name:</strong>
							</div>
							<div class="col-xs-9">
								{{ $history->firstname }}
							</div>
						</div>
						
						<div class="row">	
							<div class="col-xs-3">
								<strong>Middle Name:</strong>
							</div>
							<div class="col-xs-9">
								{{ $history->middlename }}
							</div>
						</div>
						
						<div class="row">	
							<div class="col-xs-3">
								<strong>Last Name:</strong>
							</div>
							<div class="col-xs-9">
								{{ $history->lastname }}
							</div>
						</div>
						
						<div class="row">	
							<div class="col-xs-3">
								<strong>BSB:</strong>
							</div>
							<div class="col-xs-9">
								{{ $user->bsb }}
							</div>
						</div>
						
						<div class="row">	
							<div class="col-xs-3">
								<strong>Account Number:</strong>
							</div>
							<div class="col-xs-9">
								{{ $user->accountnum }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop