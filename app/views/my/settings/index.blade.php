@extends('layout')

@section('body-id')
	gallery
@endsection

@section('content')
	<div id="showcase">
		<div class="container">
			<div class="row header">
				<div class="col-md-12">
					<h3>My Settings</h3>
					@include('alerts')
				</div>
				<div class="col-md-12 filtering">
					<ul id="filters">
						@if (Auth::user()->canUseProfile())
						<li><a href="#" data-filter=".account" class='account'>Account</a></li>
						<li><a href="#" data-filter=".profile" class='profile'>Profile</a></li>
						<li><a href="#" data-filter=".menu" class='menu'>Menu</a></li>
						@endif
					</ul>
				</div>
			</div>

			<div class="row gallery_container">

				@include('my.settings.account', array('userhistory' => $userhistory, 'errors' => $errors))
				@include('my.settings.profile', array('profile' => $profile, 'errors' => $errors))
				@include('my.settings.menu', array('menus' => $menus))

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
			if (selector === '') selector = '.account';
			$container.isotope({ filter: selector });
			$(selector).addClass("active");
        });
    </script>

@stop
