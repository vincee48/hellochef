@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>Enquiries for {{ Auth::user()->username }}</h3>
					@include('alerts')
				</div>
				<div class="col-md-12 filtering">
					<ul id="filters">
						<li><a href="#" data-filter=".my" class='my'>My Enquiries</a></li>

						@if (Auth::user()->isChef())
						<li><a href="#" data-filter=".pending" class='pending'>Pending</a></li>
						<li><a href="#" data-filter=".approved" class='approved'>Approved</a></li>
						@endif
					</ul>
				</div>
			</div>
			
			<div class="row gallery_container">
				<div class="col-md-12 my">
					<div class="ibox float-e-margins">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div>					
									<h2>My Enquiries</h2>
								</div>
								<div>
									<table class="table table-striped table-bordered table-hover dataTable">
										<thead>
											<th>From</th>
											<th>Menu</th>
											<th>Quantity</th>
											<th>Approved</th>
											<th>Desired Date</th>
											<th>Enquired Date</th>				
											<th>Paid</th>
										</thead>
										<tbody>
											@foreach ($myEnquiries as $enquiry)
											<tr>											
												<td><a href="/my/enquiries/{{$enquiry->id}}">{{ $enquiry->getUserName() }}</a></td>
												<td><a href="/my/enquiries/{{$enquiry->id}}">{{ $enquiry->getMenuName() }}</a></td>
												<td>{{ $enquiry->quantity }}</td>
												<td class="{{ $enquiry->approved ? 'cell-success' : 'cell-error'}}"><span>{{ $enquiry->approved ? '1' : '0'}}</span></td>
												<td class="text-right">{{ date('d/m/Y', strtotime($enquiry->enquirydate)) }}</td>
												<td class="text-right">{{ $enquiry->created_at->format('d/m/Y g:i A') }}</td>
												<td class="{{ $enquiry->paid ? 'cell-success' : 'cell-error'}}"><span>{{ $enquiry->paid ? '1' : '0'}}</span></td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			
				@if (Auth::user()->isChef())
				<div class="col-md-12 pending">
					<div class="ibox float-e-margins">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div>					
									<h2>Pending</h2>
								</div>
								<div>
									<table class="table table-striped table-bordered table-hover dataTable">
										<thead>
											<th>From</th>
											<th>Menu</th>
											<th>Quantity</th>
											<th>Desired Date</th>
											<th>Enquired Date</th>
										</thead>
										<tbody>
											@foreach ($enquiries as $enquiry)
											<tr>											
												<td><a href="/my/enquiries/{{$enquiry->id}}">{{ $enquiry->getUserName() }}</a></td>
												<td><a href="/my/enquiries/{{$enquiry->id}}">{{ $enquiry->getMenuName() }}</a></td>
												<td>{{ $enquiry->quantity }}</td>
												<td class="text-right">{{ date('d/m/Y', strtotime($enquiry->enquirydate)) }}</td>
												<td class="text-right">{{ $enquiry->created_at->format('d/m/Y g:i A') }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 approved">
					<div class="ibox float-e-magins">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div>					
									<h2>Approved</h2>
								</div>
								<div>
									<table class="table table-striped table-bordered table-hover dataTable">
										<thead>
											<th>From</th>
											<th>Menu</th>
											<th>Quantity</th>
											<th>Desired Date</th>
											<th>Enquired Date</th>
										</thead>
										<tbody>
											@foreach ($approvedEnquiries as $enquiry)
											<tr>											
												<td><a href="/my/enquiries/{{$enquiry->id}}">{{ $enquiry->getUserName() }}</a></td>
												<td><a href="/my/enquiries/{{$enquiry->id}}">{{ $enquiry->getMenuName() }}</a></td>
												<td>{{ $enquiry->quantity }}</td>
												<td class="text-right">{{ date('d/m/Y', strtotime($enquiry->enquirydate)) }}</td>
												<td class="text-right">{{ $enquiry->created_at->format('d/m/Y g:i A') }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>					
				</div>
				@endif
			</div>			
		</div>
	</div>	
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
				@if (Auth::user()->isChef())
				selector = '.pending';
				@else
				selector = '.my';
				@endif
			}
			$container.isotope({ filter: selector });
			$(selector).addClass("active");
			
			$('.dataTable').dataTable({				
				"order": [ ],
				"oLanguage" : {
					"sEmptyTable" : "You have no enquiries!"
				}
			});
			
        });
    </script>
	
@stop