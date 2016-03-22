@if (Session::has('error_message'))
	<div class='alert alert-danger'><span class="glyphicon glyphicon-exclamation-sign"></span> {{ Session::get('error_message') }}</div>
@elseif (Session::has('info_message'))
	<div class='alert alert-info'><span class="glyphicon glyphicon-question-sign"></span> {{ Session::get('info_message') }}</div>
@endif