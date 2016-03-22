@extends('chef.layout')

@section('flexslider')
<?php
/*
<div class="col-md-12">
	<div class="row">
		<div class="flexslider" id="wrapper">
			<ul class="slides">
				<li>
					<img src="/images/photo1.jpg" />
				</li>
				<li>
					<img src="/images/photo2.jpg" />
				</li>
				<li>
					<img src="/images/photo3.jpg" />
				</li>
			</ul>
		</div>
	</div>
</div>*/
?>

@endsection

@section('chef-content')
	<?php
		$history = "";
		$menus = "";
		if ($profile) {
			$history = $profile->getLatestHistory();
			if (!$preview) {
				$menus = $profile->getActiveMenus();
			}
			else {
				$menus = $profile->getMenus();
			}
		}

		if ($preview) {
			$lead = Lead::where('chefname', '=', $chefname)->first();
		}

		$reviews = Review::getRandomReviews($profile->id, 3);

	?>
	<div class="row">
		<div class="col-sm-12 home-header">
			<h2><span>Menus</span></h2>
		</div>
		<div class="col-sm-12">
		@foreach ($menus as $menu)
			<?php $menuhistory = $menu->getLatestHistory() ?>
			<div class="row menu-display">
				<div class="col-sm-6">
					<div class="menu-image-slider menu-pics">
						<ul class="slides">
							<?php $pic = $menu->getFirstPicture(); ?>
							@if ($pic)
								@if (!$preview)
									<li><a href="/chef/{{ $chefname }}/{{ $menu->id}}">
										{{ HTML::image("images/" . $chef->id . "/" . $pic->getDocument()->filename, null, array('class' => 'img-responsive no-margin')) }}
									</a></li>
								@else
									<li><a href="/admin/leads/{{ $lead->id }}/{{ $menu->id}}">
										{{ HTML::image("images/" . $chef->id . "/" . $pic->getDocument()->filename, null, array('class' => 'img-responsive no-margin')) }}
									</a></li>
								@endif
							@endif
						</ul>
					</div>
				</div>
				<div class="col-sm-6">
					@if (!$preview)
						<h3><a href="/chef/{{ $chefname }}/{{ $menu->id}}">{{ $menuhistory->title }}</a></h3>
					@else
						<h3><a href="/admin/leads/{{ $lead->id }}/{{ $menu->id}}">{{ $menuhistory->title }}</a></h3>
					@endif
					<div class="cuisine">{{ $menuhistory->tags }}</div>
					<div class="description">{{ $menuhistory->description }}</div>
				</div>
			</div>
		@endforeach
		</div>
	</div>
	<br/><br/>

	<div class="row">
		<div class="col-sm-12 home-header">
			<h2><span>Experience</span></h2>
		</div>
		<div class="col-sm-12">
			<p>
				{{ nl2br($history->experience) }}
			</p>
		</div>
	</div>

	@if ($profile->hasReviews())
	<div class="row">
		<div class="col-sm-12 home-header">
			<h2><span>Reviews</span></h2>
		</div>
		<div class="col-sm-12">
			@foreach ($reviews as $review)
				<?php
				$reviewUser = $review->getUser();
				$userHist = $review->getUser()->getLatestHistory();
				?>
				<div class="col-sm-2">
					@if ($reviewUser->getProfilePicture())
						{{ HTML::image("images/" . $reviewUser->id . "/" . $reviewUser->getProfilePicture()->filename, null, array('class' => 'img-responsive img-circle')) }}
					@else
						<img src="/images/circle-icons/full-color/profile.png" class="img-responsive img-circle" />
					@endif
				</div>
				<div class="col-sm-9">
					<h4>{{ $review->summary }}</h4>
					<p>{{ nl2br($review->content) }}</p>
					<p>{{ $userHist->firstname . ' ' . $userHist->lastname }} - {{ $review->getCreatedAt() }}</p>
				</div>
				<div class="col-sm-1">
					@if ($review->negative)
						<span class="glyphicon glyphicon-thumbs-down glyphicon-xl"></span>
					@else
						<span class="glyphicon glyphicon-thumbs-up glyphicon-xl"></span>
					@endif
				</div>
			@endforeach
		</div>
	</div>
	@endif

@endsection

@section('image-height')
	1.15
@endsection

@section('chef-scripts')

@stop
