<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Hello Chef</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="shortcut icon" type="image/png" href="/images/hat-icon.ico" />
		<!-- stylesheets -->
		<link rel="stylesheet" type="text/css" href="/css/compiled/theme.css" />
		<link rel="stylesheet" type="text/css" href="/css/vendor/animate.css" />
		<link rel="stylesheet" type="text/css" href="/css/site.css" />
		<link rel="stylesheet" type="text/css" href="/css/vendor/flexslider.css" />
		<link rel="stylesheet" type="text/css" href="/css/plugins/dataTables/dataTables.bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-datepicker.css" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/magnific-popup.css" />
		<link rel="stylesheet" type="text/css" href="/css/cropper.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/jquery.tagit.css" />
		<link rel="stylesheet" type="text/css" href="/css/tagit.ui-zendesk.css" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript"></script>

		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-60390439-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</head>
    <body id=@yield('body-id')>
		<header class="navbar navbar-inverse white" role="banner">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
						<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
					</button>
					<a href="/" class="navbar-brand">Hello Chef</a>
				</div>
				<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
					<ul class="nav navbar-nav navbar-right">
						<li class="{{ Request::is('browse') ? 'active' : '' }}">
							<a href="/browse"><span class="glyphicon glyphicon-search"></span> Browse</a>
						</li>
						@if (!Auth::check())
						<li class="{{ Request::is('signin') ? 'active' : '' }}">
							<a href="/signin"><span class="glyphicon glyphicon-log-in"></span> Login</a>
						</li>
						<li class="{{ Request::is('signup') ? 'active' : '' }}">
							<a href="/signup"><span class="glyphicon glyphicon-edit"></span> Sign up</a>
						</li>
						@else

						@if (Auth::user()->isChef())
							<li class="{{ Request::is('my/chef/enquiries') ? 'active' : '' }}">
								<a href="/my/chef/enquiries"><span class="glyphicon glyphicon-comment"></span> Enquiries
								@if (Enquiry::getNumberOfPendingEnquiries(Auth::id()) > 0)
									<span class="label label-warning">{{ Enquiry::getNumberOfPendingEnquiries(Auth::id()) }}</span>
								@elseif (Enquiry::getNumberOfApprovedUnpaidEnquiries(Auth::id()) > 0)
									<span class="label label-warning">{{ Enquiry::getNumberOfApprovedUnpaidEnquiries(Auth::id()) }}</span>
								@endif
								</a>
							</li>
							@else
							<li class="{{ Request::is('my/enquiries') ? 'active' : '' }}">
								<a href="/my/enquiries"><span class="glyphicon glyphicon-comment"></span> Enquiries

								@if (Enquiry::getNumberOfMyEnquiries(Auth::id()) > 0)
									<span class="label label-warning">{{ Enquiry::getNumberOfMyEnquiries(Auth::id()) }}</span>
								@endif

								</a>
							</li>
						@endif
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->email; }} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								@if (Auth::user()->isAdmin())
								<li><a href="/admin/dashboard"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
								@endif
								@if (Enquiry::getNumberOfPendingReviews(Auth::id()) > 0)
								<li class="{{ Request::is('my/reviews') ? 'active' : '' }}">
									<a href="/my/reviews"><span class="glyphicon glyphicon-thumbs-up"></span> Reviews
										<span class="label label-warning">{{ Enquiry::getNumberOfPendingReviews(Auth::id()) }}</span>
									</a>
								</li>
								@endif
								@if (!Auth::user()->isChef())
								<li class="{{ Request::is('my/become-a-chef/*') ? 'active' : '' }}"><a href="/my/become-a-chef/latest"><span class="glyphicon glyphicon-glass"></span> Become a Chef</a></li>
								@else
								<li class="{{ Request::is('chef/' . Auth::user()->chefname . '') ? 'active' : '' }}"><a href="/chef/{{ Auth::user()->chefname }}"><span class="glyphicon glyphicon-glass"></span> View Profile</a></li>
								@endif
								<li class="{{ Request::is('my/settings') ? 'active' : '' }}"><a href="/my/settings"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
								<li><a href="/logout"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
							</ul>
						</li>
						@endif
					</ul>
				</nav>
			</div>
		</header>

		@if (Request::is('/'))
			<img src="/images/logo-white.png" class="logo logo-white"/>
		@else
			<a href="/"><img src="/images/logo-black.png" class="logo logo-black"/></a>
		@endif

		@yield('content')

		@include('footer')

		<!-- javascript -->
		<script type="text/javascript" src="/js/moment.js"></script>
		<script type="text/javascript" src="/js/cropper.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="/js/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript" src="/js/vendor/jquery.isotope.min.js"></script>
		<script type="text/javascript" src="/js/vendor/imagesloaded.js"></script>
		<script type="text/javascript" src="/js/theme.js"></script>
		<script type="text/javascript" src="/js/gallery.js"></script>
		<script type="text/javascript" src="/js/vendor/jquery.flexslider.min.js"></script>
		<script type="text/javascript" src="/js/plugins/dataTables/jquery.dataTables.js"></script>
		<script type="text/javascript" src="/js/plugins/dataTables/dataTables.bootstrap.js"></script>
		<script type="text/javascript" src="/js/masonry.pkgd.min.js"></script>
		<script type="text/javascript" src="/js/tag-it.min.js"></script>
		<script type="text/javascript">

			$(window).load(function () {
				$('#masonry').masonry({
					// options
					columnWidth: 15,
					itemSelector: '.pin'
				});
			});
			$("#dinersButton").click(function() {
			$("#dinersTab").css("display", "block");
			$("#chefsTab").css("display", "none");
			return false;
			});
			$("#chefsButton").click(function() {
			$("#dinersTab").css("display", "none");
			$("#chefsTab").css("display", "block");
			return false;
			});
		</script>
		@yield('scripts')

    </body>
</html>
