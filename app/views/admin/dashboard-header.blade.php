@if (!Auth::user()->hasCompletedAccount())
<p></p>
<div class="row">
	<div class="col-md-12">
		<p>You have not completed your account details yet! {{HTML::link('/my/settings/account', 'Click here to get started.')}}</p>
	</div>
</div>
@endif
