@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row gallery_container">
				<div class="col-md-12 my">
					<div>
						<h2>My Enquiries</h2>
					</div>
					<div>
						<table class="table table-striped table-bordered table-hover dataTable">
							<thead>
								<th>Chef</th>
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
									<td class="black"><a href="/chef/{{$enquiry->getChefName()}}">{{ $enquiry->getChefFullName() }}</a></td>
									<td><a href="/my/enquiries/{{$enquiry->id}}">{{ $enquiry->getMenuName() }}</a></td>
									<td>{{ $enquiry->quantity }}</td>
									<td><span class="invis">{{ $enquiry->approved ? '1' : '0'}}</span>{{ $enquiry->approved ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' }}</td>
									<td class="text-right">{{ date('d/m/Y', strtotime($enquiry->enquirydate)) }}</td>
									<td class="text-right">{{ $enquiry->created_at->format('d/m/Y g:i A') }}</td>
									<td><span class="invis">{{ $enquiry->paid ? '1' : '0'}}</span>{{ $enquiry->paid ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>'}}</td>
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
            })

            // filter items when filter link is clicked
            $filters.click(function() {
                $filters.removeClass("active");
                $(this).addClass("active");
                var selector = $(this).data('filter');
                $container.isotope({ filter: selector });
                return false;
            });

			var selector = '{{ Session::get("tab") }}';
			if (selector === '') {
				selector = '.my';
			}
			$container.isotope({ filter: selector });
			$(selector).addClass("active");

			$('.dataTable').dataTable({
				"order": [ ],
				"bLengthChange": false,
				"oLanguage" : {
					"sEmptyTable" : "You have made no enquiries!"
				}
			});

        });
    </script>

@stop
