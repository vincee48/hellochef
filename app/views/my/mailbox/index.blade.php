@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Mailbox for {{ Auth::user()->email }}</h3>
					@include('alerts')
				</div>
				<div class="col-md-12 filtering">
					<ul id="filters">
						<li><a href="#" data-filter=".inbox" class='inbox'>Inbox
							@if (Email::getNumberOfUnreadEmails(Auth::id()) > 0)
								({{ Email::getNumberOfUnreadEmails(Auth::id()) }})
							@endif
						</a></li>
						<li><a href="#" data-filter=".sent" class='sent'>Sent</a></li>
						@if ($viewemail)
						<li><a href="#" data-filter=".view-email" class="view-email">View Email Message</a></li>
						@endif
					</ul>
				</div>
			</div>

			<div class="row gallery_container">
				<div class="col-md-12 inbox">
					<div class="ibox float-e-margins">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div>
									<h2>Inbox ({{ Email::getNumberOfUnreadEmails(Auth::id()) }})</h2>
								</div>
								<div>
									<table class="table table-striped table-bordered table-hover dataTable">
										<thead>
											<th></th>
											<th>From</th>
											<th>Subject</th>
											<th>Date</th>
										</thead>
										<tbody>
											@foreach ($emails as $email)
											<tr class="{{ $email->read ? 'read' : 'unread' }}">
												<?php $fromuser = $email->getFromUser() ?>
												<td class="text-center">
												@if ($fromuser && $fromuser->getProfilePicture())
													{{ HTML::image("images/" . $fromuser->id . "/" . $fromuser->getProfilePicture()->filename, null, array('class' => 'img-mailbox img-circle')) }}
												@else
													<img src="/images/circle-icons/full-color/profile.png" class="img-mailbox img-circle" />
												@endif
												</td>
												<td><a href="/my/mailbox/{{$email->id}}">{{ $email->getFromUserName() }}</a></td>
												<td><a href="/my/mailbox/{{$email->id}}">{{ $email->subject }}</a></td>
												<td class="text-right">{{ $email->created_at->format('d/m/Y g:i A') }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 sent">
					<div class="ibox float-e-magins">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div>
									<h2>Sent</h2>
								</div>
								<div>
									<table class="table table-striped table-bordered table-hover dataTable">
										<thead>
											<th></th>
											<th>To</th>
											<th>Subject</th>
											<th>Date</th>
										</thead>
										<tbody>
											@foreach ($sentemails as $email)
											<tr class="read">
												<?php $fromuser = $email->getFromUser() ?>
												<td class="text-center">
												@if ($fromuser && $fromuser->getProfilePicture())
													{{ HTML::image("images/" . $fromuser->id . "/" . $fromuser->getProfilePicture()->filename, null, array('class' => 'img-mailbox img-circle')) }}
												@else
													<img src="/images/circle-icons/full-color/profile.png" class="img-mailbox img-circle" />
												@endif
												<td><a href="/my/mailbox/sent/{{$email->id}}">{{ $email->getToUserName() }}</a></td>
												<td><a href="/my/mailbox/sent/{{$email->id}}">{{ $email->subject }}</a></td>
												<td class="text-right">{{ $email->created_at->format('d/m/Y g:i A') }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				@if ($viewemail)
				<?php
					if (!$viewemail->fromSystem())
					{
						$emailenquiry = EmailEnquiry::where('emailid', '=', $viewemail->id)->first();

						$emailtrace = array();

						if ($emailenquiry) {
							$emenquiry = Enquiry::find($emailenquiry->enquiryid);
							$emailenquiries = EmailEnquiry::where('enquiryid', '=', $emenquiry->id)->orderby('created_at', 'desc')->get();

							foreach ($emailenquiries as $emailenquiry)
							{
								$curemail = Email::find($emailenquiry->emailid);

								if (!$curemail->isReply())
								{
									if ($sent && $curemail->fromuser == Auth::id()) {
										$emailtrace[] = $curemail;
									}
									else if (!$sent && $curemail->touser == Auth::id()) {
										$emailtrace[] = $curemail;
									}
								}
								else {
									$emailtrace[] = $curemail;
								}
							}
						}
					}
				?>
				<div class="col-md-12 view-email">
					<div class="ibox float-e-margins">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div class="row">
									<div class="pull-left tooltip-demo">
										<a href="/my/mailbox{{ $sent ? '/sent' : '' }}" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Back"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
									</div>
									<div class="pull-right tooltip-demo">
										@if ($viewemail->canReply() && !$sent)
											<button class="btn btn-white btn-sm" data-toggle="modal" data-target="#replyModal">
												<i class="glyphicon glyphicon-share"></i> Reply
											</button>
										@endif
									</div>
								</div>
								@if ($viewemail->fromSystem() || count($emailtrace) == 0)
								<div class="mail-tools tooltip-demo m-t-md">
									<h3>
										<span class="font-noraml">Subject: </span>{{ $viewemail->subject }}
									</h3>
									<h5>
										<span class="pull-right font-noraml">{{ $viewemail->created_at->format('D, M d, Y \a\t g:i A') }}</span>
										<span class="font-noraml">From: </span>{{ $viewemail->getFromUserName() }}
										<p></p>
										<span class="font-noraml">To: </span>{{ $viewemail->getToUserName() }}
									</h5>
								</div>
								<div class="mail-body">
									{{ $viewemail->body }}
								</div>
								<div class="clearfix"></div>
								@else
								@foreach ($emailtrace as $displayemail)
								<div class="mail-tools tooltip-demo m-t-md">
									<h3>
										<span class="font-noraml">Subject: </span>{{ $displayemail->subject }}
									</h3>
									<h5>
										<span class="pull-right font-noraml">{{ $displayemail->created_at->format('D, M d, Y \a\t g:i A') }}</span>
										<span class="font-noraml">From: </span>{{ $displayemail->getFromUserName() }}
										<p></p>
										<span class="font-noraml">To: </span>{{ $displayemail->getToUserName() }}
									</h5>
								</div>
								<div class="mail-body">
									{{ $displayemail->body }}
								</div>
								<div class="clearfix"></div>
								@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>

	@if ($viewemail)
	<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				{{ Form::open(array('class' => 'form-horizontal')) }}

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="replyModalLabel">Reply</h4>
				</div>
				<div class="modal-body">
					@include('alerts')
					<div class="row">
						<div class="form-group">
							<div class="col-md-3">
								{{ Form::label('subject', 'Subject', array('class' => 'control-label')) }}
							</div>
							<div class="col-md-9">
								@if (substr($viewemail->subject, 0, 3) == "RE:")
								{{ Form::text('subject', $viewemail->subject, array('class' => 'form-control', 'disabled')) }}
								@else
								{{ Form::text('subject', "RE: " . $viewemail->subject, array('class' => 'form-control', 'disabled')) }}
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-3">
								{{ Form::label('body', 'Body', array('class' => 'control-label')) }}
							</div>
							<div class="col-md-9">
								{{ Form::textarea('body', '', array('class' => 'form-control', 'placeholder' => 'Enter reply here...')) }}
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					{{ Form::submit('Reply', array('class' => 'btn btn-primary')) }}
				</div>

				{{ Form::close() }}
			</div>
		</div>
	</div>
	@endif
@endsection

@section('scripts')
	<script type="text/javascript">
        $(function(){

        	// Initialize Isotope plugin for filtering
            var $container = $('.gallery_container'),
                  $filters = $("#filters a");

            $container.imagesLoaded( function(){
                $container.isotope({
                    itemSelector : '.col-md-12',
                    masonry: {
                        columnWidth: 323
                    }
                });
            });

            // filter items when filter link is clicked
            $filters.click(function() {
                $filters.removeClass("active");
                $(this).addClass("active");
                var selector = $(this).data('filter');
                $container.isotope({ filter: selector });
                return false;
            });

			var selector = '{{ Session::get("prevSettingPage") }}';
			if (selector === '') {
				@if ($viewemail)
					selector = '.view-email';
				@elseif ($sent)
					selector = '.sent';
				@else
					selector = '.inbox';
				@endif
			}
			$container.isotope({ filter: selector });
			$(selector).addClass("active");

			$('.dataTable').dataTable({
				"order": [],
				"bLengthChange": false,
				"oLanguage" : {
					"sEmptyTable" : "You have no mail!"
				}
			});

        });
    </script>

@stop
