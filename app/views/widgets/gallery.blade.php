<?php
		$activeMenus = Menu::where('menus.active', '=', '1')->get();
	
		$items = array();
		$all_tags = array();
		foreach ($activeMenus as $menu) {
			$hist = $menu->getLatestHistory();
			$match = true;
			$tags = explode(',', $hist->tags);

			if (!$menu->getFirstPicture()) {
				$match = false;
			}
			else {
				if (Input::has('cuisine')) {
					$match &= in_array(Cuisine::getCuisine(Input::get('cuisine')), explode(",", $hist->tags));
				}
				if (Input::has('size')) {
					if (Input::get('size') == "25+") {
						$match &= $hist->minpax >= 25;
					} else {
						$match &= Input::get('size') >= $hist->minpax
							&& Input::get('size') <= $hist->maxpax;
					}
				}
				if (Input::has('search')) {
					$search = strtolower(Input::get('search'));
					$match &= strpos(strtolower($hist->description), $search) !== false || strpos(strtolower($hist->title), $search) !== false;
				}
				if (Input::has('state')) {
					$match &= $menu->getProfile()->state == str_replace('+', ' ', Input::get('state'));
				}
				if (Input::has('tag')) {
					$match &= in_array(Input::get('tag'), $tags);
				}
			}

			if ($match) {
				$items[] = $menu;
				if ($hist->tags != "") {
					foreach ($tags as $tag) {
						if (!in_array($tag, $all_tags)) {
							array_push($all_tags, $tag);
						}
					}					
				}
			}
		}
		
		$items = array_reverse($items);
		$perPage = 9;   
		$page = Input::get('page', 1);
		$offset = ($page * $perPage) - $perPage;
		$articles = array_slice($items,$offset,$perPage);
		$paginator = Paginator::make($articles, count($items), $perPage);

		$random = $items;		
		shuffle($random);
		$random = array_slice($random, 0, 12);
?>

@if ($searchBar)
	<script type="text/javascript">
	$(document).ready(function() {
		var open = false;
		
		$('.advToggle').click(function() {
			toggleAdvanced();
		});
		
		function toggleAdvanced() {
			open = !open;
			if (open) {
				$('#mini-adv').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
				$('#large-adv').slideDown();
			} else {
				$('#mini-adv').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
				$('#large-adv').slideUp();
			}
		}
	});
	</script>
	
	<div id="search" class="topPadding">
		{{ Form::open(array('method' => 'GET', 'role' => 'form', 'class' => 'form-inline')) }}

			<div class="row text-center">
				<div class="col-md-3">
					<div class="form-group">
						{{ Form::label('cuisine', 'Cuisine', array('class' => 'control-label')) }}
						<br/>
						{{ Form::select('cuisine', Cuisine::getOrderedArrayWithAny(), Input::get('cuisine'), array('class' => 'form-control form-autosubmit')) }}
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
						{{ Form::label('size', 'Party Size', array('class' => 'control-label')) }}
						<br/>
						{{ Form::select('size', Menu::getNumberArrayWithAny(), Input::get('size'), array('class' => 'form-control form-autosubmit')) }}
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
						{{ Form::label('state', 'State', array('class' => 'control-label')) }}
						<br/>
						{{ Form::select('state', array(
							'' => 'Any',
							'Australian Capital Territory' => 'ACT', 
							'New South Wales' => 'NSW', 
							'Queensland' => 'QLD', 
							'South Australia' => 'SA', 
							'Tasmania' => 'TAS', 
							'Victoria' => 'VIC', 
							'Western Australia' => 'WA'), Input::get('state'), array('class' => 'form-control form-autosubmit')) }}
					</div>
				</div>
				
				<div class="col-md-5">
					<div class="form-group">
						{{ Form::label('search', 'Search', array('class' => 'control-label')) }}
						<br/>
						<div class="input-group">
							
							<?php
							/*
							<span class="input-group-btn">
								<a href="#" class="advToggle btn btn-primary"><i id="mini-adv" style="color:white;" class="glyphicon glyphicon-chevron-down"></i></a>
							</span>
							*/
							?>
							{{ Form::text('search', Input::get('search'), array('class' => 'form-control', 'placeholder' => 'Search menu description')) }}							
							<span class="input-group-btn">
								{{ Form::button('<i class="glyphicon glyphicon-search"></i> Search', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
							</span>							
						</div>
					</div>
				</div>
			</div>
			
			<div id="large-adv" class="row text-center topPadding">
				<input name="tag" id="tag" type="hidden" value="" />

				@foreach ($all_tags as $tag) 
					<input type="button" value="{{$tag}}" class="btn btn-primary bottom-margin tag-value" />
				@endforeach
				
				@if (Input::has('tag'))
				<button id="clear-tag" class="btn btn-primary bottom-margin">
					<i class="glyphicon glyphicon-remove"></i>
				</button>
				@endif 
				
				<script type="text/javascript">
					$('.tag-value').click(function () {
						$('#tag').val($(this).val());
						$('form').submit();
					});
					
					$('#clear-tag').click(function () {
						$('#tag').val('');
						$('form').submit();
					});
					
					$('.form-autosubmit').change(function() {
						$('form').submit();
					});
				</script>
				<a href="#" class="advToggle"><span class="col-sm-12 btn-sm btn-primary radius-bottom"><i style="color:white;" class="glyphicon glyphicon-chevron-up"></i> Advanced <i style="color:white;" class="glyphicon glyphicon-chevron-up"></i></span></a>
				
				
			</div>
			
		{{ Form::close() }}
	</div>
	<hr/>
@endif
<div class="text-center">

@if (count($articles) > 0)
	<div id="masonry">
		@if ($searchBar)
			@foreach ($articles as $item)
			<?php $chefUser = $item->getProfile()->getUser(); ?>
			<div class="pin">
				@if ($item->getFirstPicture())
				<a href='/chef/{{$item->getProfile()->getUser()->chefname}}/{{$item->id}}'>
					{{ HTML::image("/images/" . $item->getProfile()->getUser()->id . "/" . $item->getFirstPicture()->getDocument()->filename, null, array('class' => 'main-img img-responsive no-margin')) }}
				</a>
				@endif
				<div class="col-xs-12">
					<div class="profile-pic">
						@if ($chefUser && $chefUser->getProfilePicture())
							<a href='/chef/{{$item->getProfile()->getUser()->chefname}}'>{{ HTML::image("images/" . $chefUser->id . "/" . $chefUser->getProfilePicture()->filename, null, array('class' => 'img-xs pull-right img-circle')) }}</a>
						@else
							<a href='/chef/{{$item->getProfile()->getUser()->chefname}}'><img src="/images/circle-icons/full-color/profile.png" class="img-xs pull-right img-circle" /></a>
						@endif
					</div>
					<a href='/chef/{{$item->getProfile()->getUser()->chefname}}/{{$item->id}}'><h4>{{ $item->getLatestHistory()->title }}</h4></a>
					<p><span class="cuisine">{{ $item->getLatestHistory()->tags }}</span></p>
					<p>{{ $item->getLatestHistory()->description }}</p>
				</div>
			</div>
			@endforeach		
		@else
			@foreach ($random as $item)
			<?php $chefUser = $item->getProfile()->getUser(); ?>
			<div class="pin">
				@if ($item->getFirstPicture())
				<a href='/chef/{{$item->getProfile()->getUser()->chefname}}/{{$item->id}}'>
					{{ HTML::image("/images/" . $item->getProfile()->getUser()->id . "/" . $item->getFirstPicture()->getDocument()->filename, null, array('class' => 'main-img img-responsive no-margin')) }}
				</a>
				@endif
				<div class="col-xs-12">
					<div class="profile-pic">
						@if ($chefUser && $chefUser->getProfilePicture())
							<a href='/chef/{{$item->getProfile()->getUser()->chefname}}'>{{ HTML::image("images/" . $chefUser->id . "/" . $chefUser->getProfilePicture()->filename, null, array('class' => 'img-xs pull-right img-circle')) }}</a>
						@else
							<a href='/chef/{{$item->getProfile()->getUser()->chefname}}'><img src="/images/circle-icons/full-color/profile.png" class="img-xs pull-right img-circle" /></a>
						@endif
					</div>
					<a href='/chef/{{$item->getProfile()->getUser()->chefname}}/{{$item->id}}'><h4>{{ $item->getLatestHistory()->title }}</h4></a>
					<p><span class="cuisine">{{ $item->getLatestHistory()->tags }}</span></p>
					<p>{{ $item->getLatestHistory()->description }}</p>
				</div>
			</div>
			@endforeach
		@endif		
	</div>
@endif

@if ($searchBar)
{{ $paginator
	->appends(array('cuisine' => Input::get('cuisine'), 'size' => Input::get('size'), 'search' => Input::get('search')))
	->links() }}
@endif
</div>
