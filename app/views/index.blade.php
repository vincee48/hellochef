@extends('layout')

@section('body-id')
	home2
@endsection

@section('content')
	<div id="hero">
		<div class="slides">
			<div class="slide first active">
				<div class="bg"></div>
				<div class="container">
					<div class="row">
						<div class="col-sm-12 landingBox info">
							<h1 class="hero-text">
								Kickstart your dinner party here
							</h1>
							<h3 class="hero-subtext">
								Hire a private chef to cater for your next function
							</h3>

							<div class="cta" align="center">
								<a href="/browse" class="button-outline" >
									Browse menus
									<i class="glyphicon glyphicon-chevron-right"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12 home-header">
				<h2><span>OUR CHEFS</span></h2>
			</div>
			<div class="col-md-12 home-content">
				<h3 class="text-center">Our chefs vary from a diverse background and specialise in their own unique flair. We take pride in screening our chefs thoroughly to make sure they deliver first class culinary experiences to you</h3>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-6">
							<img class="home-img img-responsive img-circle" src="/images/kumar.png" />
						</div>
						<div class="col-xs-6">
							<img class="home-img img-responsive img-circle" src="/images/hannah-crop.png" />
						</div>
					</div>

					<div class="row">
						<div class="col-xs-6 text-center">
							Kumar - Previous contestant in Masterchef season 3 and Masterchef all stars, Kumar turns the heat up with exotic flavours boasted in his contemporary Asian inspired cuisine.
						</div>

						<div class="col-xs-6 text-center">
							Hannah - Working in property, this young foodie and talented home cook enjoys preparing hearty dishes, specialising in Malayasian street food.
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 home-header">
				<h2><span>HOW IT WORKS</span></h2>
			</div>
			<div class="col-md-12 home-content">
				<div class="row">
					<div class="col-lg-12">
						<h4 class="text-center"><a href="#" id="dinersButton">For Diners</a> | <a href="#" id="chefsButton">For Chefs</a></h4>
							<div id="dinersTab">
								<div class="col-sm-4 how-to-content">
									<img class="home-img img-responsive img-circle" src="/images/diners1.jpg" />
									<h4>SEARCH</h4>
									<p>Search through our chefs' profiles and menus to find your favourite cuisine</p>
								</div>
								<div class="col-sm-4 how-to-content">
									<img class="home-img img-responsive img-circle" src="/images/diners2.jpg" />
									<h4>ENQUIRE</h4>
									<p>Message the chef to customise any of the menu items or with any questions you have</p>
								</div>
								<div class="col-sm-4 how-to-content">
									<img class="home-img img-responsive img-circle" src="/images/diners3.jpg" />
									<h4>CONFIRM</h4>
									<p>Pay for your package. All done! Your Chef will source fresh ingredients and prepare a delicious meal at your event.</p>
								</div>
							</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
							<div id="chefsTab">
								<div class="col-sm-4 how-to-content">
									<img class="home-img img-responsive img-circle" src="/images/howchefs1.jpg" />
									<h4>SIGN UP</h4>
									<p>Sign up and build your profile (don't forget to list your experiences and upload any photos of your food)</p>
								</div>
								<div class="col-sm-4 how-to-content">
									<img class="home-img img-responsive img-circle" src="/images/howchefs2.jpg" />
									<h4>SHARE</h4>
									<p>Share your profile with your friends and family</p>
								</div>
								<div class="col-sm-4 how-to-content">
									<img class="home-img img-responsive img-circle" src="/images/howchefs3.jpg" />
									<h4>COOK</h4>
									<p>Do what you do best, and get paid after the event!</p>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 home-header">
				<h2><span>GALLERY</span></h2>
			</div>
			<div class="col-md-12 home-content">
				<h3 class="text-center">Browse our Chef's creations</h3>
				@include('widgets.gallery', array('max' => 9, 'searchBar' => false))
			</div>
		</div>
	</div>

@endsection

@stop
