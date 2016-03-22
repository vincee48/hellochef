@extends('admin.dashboard-layout')

@section('breadcrumb')
<h2>Mailbox</h2>
<ol class="breadcrumb">
	<li>
		<a href="/">Home</a>
	</li>
	<li>
		<strong>Mailbox</strong>
	</li>
</ol>
@endsection

@section('content')
<div class="col-lg-2">
	<div class="ibox float-e-margins">
		<div class="ibox-content mailbox-content">
			<div class="file-manager">				
				<h5>Folders</h5>
				<ul class="folder-list m-b-md" style="padding: 0">
					<li><a href="/my/mailbox" class="{{ $folder == 'admin' ? 'active' : '' }}"> <i class="fa fa-inbox "></i> Inbox</a></li>					
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-10">
	<div class="ibox float-e-margins">
		<div class="ibox float-e-margins">
		
			@if ($email)
			<div class="ibox-title">
				<h5>Email</h5>
			</div>		
			<div class="ibox-content">
				<div class="row">
					<div class="pull-left tooltip-demo">
						<a href="/admin/mailbox{{ ($back == 'sent') ? '/sent' : ''}}" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Back"><i class="fa fa-arrow-left"></i> Back</a>					
					</div>
				</div>
				<div class="mail-tools tooltip-demo m-t-md">
					<h3>
						<span class="font-noraml">Subject: </span>{{ $email->subject }}
					</h3>
					<h5>
						<span class="pull-right font-noraml">{{ $email->created_at->format('D, M d, Y \a\t g:i A') }}</span>
						<span class="font-noraml">From: </span>{{ $email->getFromUserName() }}
					</h5>
				</div>			
				<div class="mail-body">
					{{ $email->body }}
				</div>				
				<div class="clearfix"></div>
			</div>			
			@elseif ($folder == "admin")
			<div class="ibox-content">
				<div>					
					<h2>Admin</h2>
				</div>
				<div>
					<table class="table table-striped table-bordered table-hover dataTable">
						<thead>
							<th>From</th>
							<th>To</th>
							<th>Subject</th>
							<th>Date</th>
						</thead>
						<tbody>
							@foreach ($emails as $email)
							<tr class="read">
								<td><a href="/admin/mailbox/{{$email->id}}">{{ $email->getFromUserName() }}</a></td>
								<td><a href="/admin/mailbox/{{$email->id}}">{{ $email->getToUserName() }}</a></td>
								<td><a href="/admin/mailbox/{{$email->id}}">{{ $email->subject }}</a></td>											
								<td class="text-right">{{ $email->created_at->format('d/m/Y g:i A') }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@endif
			
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