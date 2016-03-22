<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Food Social | Dashboard</title>
	<link rel="shortcut icon" type="image/png" href="/images/hat-icon.ico" />	
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/cropper.min.css" />	
    <link href="/css/site.css" rel="stylesheet">
    <link href="/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
</head>

<body>
	<div id="loading"></div>

    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->getName() }}</strong> <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="/my/settings">Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="/"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                    </li>
                    <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <a href="/admin/dashboard"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
					<li class="{{ Request::is('admin/mailbox') ? 'active' : '' }}">
						<a href="/admin/mailbox"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox</span></a>
					</li>
					<li class="{{ Request::is('admin/leads') ? 'active' : '' }}">
						<a href="/admin/leads"><i class="fa fa-laptop"></i> <span class="nav-label">Leads</span>
						@if (Lead::getNumberOfCompletedLeads() > 0)
							 <span class="label label-warning pull-right">{{ Lead::getNumberOfCompletedLeads() }} New</span>
						 @endif
						 </a>
					</li>
					<li class="{{ Request::is('admin/users*') || Request::is('admin/chef*') ? 'active' : '' }}">
						<a href="/admin/users"><i class="fa fa-users"></i> <span class="nav-label">Users</span></a>
					</li>
					<li class="{{ Request::is('admin/cuisines') ? 'active' : '' }}">
						<a href="/admin/cuisines"><i class="fa fa-cutlery"></i> <span class="nav-label">Cuisines</span></a>
					</li>
					<li class="{{ Request::is('admin/enquiries') ? 'active' : '' }}">
						<a href="/admin/enquiries"><i class="fa fa-credit-card"></i> <span class="nav-label">Enquiries</span></a>
					</li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					<ul class="nav navbar-top-links navbar-right">
						<li>
							<a href="/logout">
								<i class="fa fa-sign-out"></i> Log out
							</a>
						</li>
					</ul>
				</nav>
			</div>

			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                    @yield('breadcrumb')
					<p></p>
					@include('alerts')
					@include('admin.dashboard-header')
                </div>
            </div>

			<div class="wrapper wrapper-content">
				<div class="row animated fadeInRight">
					@yield('content')
				</div>
			</div>

			@include('admin.dashboard-footer')
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/js/plugins/dataTables/dataTables.bootstrap.js"></script>
	<script type="text/javascript" src="/js/cropper.min.js"></script>

    <!-- jQuery UI -->
    <script src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>    

	@yield('scripts')
</body>

</html>
