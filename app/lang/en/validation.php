<?php

$defaultBeginVal = "<span class='label label-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> ";
$defaultEndVal = "</span>";

return array(
	
	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => $defaultBeginVal . "The :attribute must be accepted." . $defaultEndVal,
	"active_url"           => $defaultBeginVal . "The :attribute is not a valid URL." . $defaultEndVal,
	"after"                => $defaultBeginVal . "The :attribute must be a date after :date." . $defaultEndVal,
	"alpha"                => $defaultBeginVal . "The :attribute may only contain letters." . $defaultEndVal,
	"alpha_dash"           => $defaultBeginVal . "The :attribute may only contain letters, numbers, and dashes." . $defaultEndVal,
	"alpha_num"            => $defaultBeginVal . "The :attribute may only contain letters and numbers." . $defaultEndVal,
	"array"                => $defaultBeginVal . "The :attribute must be an array." . $defaultEndVal,
	"before"               => $defaultBeginVal . "The :attribute must be a date before :date." . $defaultEndVal,
	"between"              => array(
		"numeric" => $defaultBeginVal . "The :attribute must be between :min and :max." . $defaultEndVal,
		"file"    => $defaultBeginVal . "The :attribute must be between :min and :max kilobytes." . $defaultEndVal,
		"string"  => $defaultBeginVal . "The :attribute must be between :min and :max characters." . $defaultEndVal,
		"array"   => $defaultBeginVal . "The :attribute must have between :min and :max items." . $defaultEndVal,
	),
	"confirmed"            => $defaultBeginVal . "The :attribute confirmation does not match." . $defaultEndVal,
	"date"                 => $defaultBeginVal . "The :attribute is not a valid date." . $defaultEndVal,
	"date_format"          => $defaultBeginVal . "The :attribute does not match the format :format." . $defaultEndVal,
	"different"            => $defaultBeginVal . "The :attribute and :other must be different." . $defaultEndVal,
	"digits"               => $defaultBeginVal . "The :attribute must be :digits digits." . $defaultEndVal,
	"digits_between"       => $defaultBeginVal . "The :attribute must be between :min and :max digits." . $defaultEndVal,
	"email"                => $defaultBeginVal . "The :attribute must be a valid email address." . $defaultEndVal,
	"exists"               => $defaultBeginVal . "The selected :attribute is invalid." . $defaultEndVal,
	"image"                => $defaultBeginVal . "The :attribute must be an image." . $defaultEndVal,
	"in"                   => $defaultBeginVal . "The selected :attribute is invalid." . $defaultEndVal,
	"integer"              => $defaultBeginVal . "The :attribute must be an integer." . $defaultEndVal,
	"ip"                   => $defaultBeginVal . "The :attribute must be a valid IP address." . $defaultEndVal,
	"max"                  => array(
		"numeric" => $defaultBeginVal . "The :attribute may not be greater than :max." . $defaultEndVal,
		"file"    => $defaultBeginVal . "The :attribute may not be greater than :max kilobytes." . $defaultEndVal,
		"string"  => $defaultBeginVal . "The :attribute may not be greater than :max characters." . $defaultEndVal,
		"array"   => $defaultBeginVal . "The :attribute may not have more than :max items." . $defaultEndVal,
	),
	"mimes"                => $defaultBeginVal . "The :attribute must be a file of type: :values." . $defaultEndVal,
	"min"                  => array(
		"numeric" => $defaultBeginVal . "The :attribute must be at least :min." . $defaultEndVal,
		"file"    => $defaultBeginVal . "The :attribute must be at least :min kilobytes." . $defaultEndVal,
		"string"  => $defaultBeginVal . "The :attribute must be at least :min characters." . $defaultEndVal,
		"array"   => $defaultBeginVal . "The :attribute must have at least :min items." . $defaultEndVal,
	),
	"not_in"               => $defaultBeginVal . "The selected :attribute is invalid." . $defaultEndVal,
	"numeric"              => $defaultBeginVal . "The :attribute must be a number." . $defaultEndVal,
	"regex"                => $defaultBeginVal . "The :attribute format is invalid." . $defaultEndVal,
	"required"             => $defaultBeginVal . "The :attribute field is required." . $defaultEndVal,
	"required_if"          => $defaultBeginVal . "The :attribute field is required when :other is :value." . $defaultEndVal,
	"required_with"        => $defaultBeginVal . "The :attribute field is required when :values is present." . $defaultEndVal,
	"required_with_all"    => $defaultBeginVal . "The :attribute field is required when :values is present." . $defaultEndVal,
	"required_without"     => $defaultBeginVal . "The :attribute field is required when :values is not present." . $defaultEndVal,
	"required_without_all" => $defaultBeginVal . "The :attribute field is required when none of :values are present." . $defaultEndVal,
	"same"                 => $defaultBeginVal . "The :attribute and :other must match." . $defaultEndVal,
	"size"                 => array(
		"numeric" => $defaultBeginVal . "The :attribute must be :size." . $defaultEndVal,
		"file"    => $defaultBeginVal . "The :attribute must be :size kilobytes." . $defaultEndVal,
		"string"  => $defaultBeginVal . "The :attribute must be :size characters." . $defaultEndVal,
		"array"   => $defaultBeginVal . "The :attribute must contain :size items." . $defaultEndVal,
	),
	"unique"               => $defaultBeginVal . "The :attribute has already been taken." . $defaultEndVal,
	"url"                  => $defaultBeginVal . "The :attribute format is invalid." . $defaultEndVal,
    "recaptcha" => $defaultBeginVal . "The :attribute field is not correct." . $defaultEndVal,
	"alphabet_dash" => $defaultBeginVal . "The :attribute field may only contain letters or dashes." . $defaultEndVal,
	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
		'newpassword' => 'password',
		'aboutme' => 'about me',
		'profilepic' => 'profile picture',
		'cuisineid' => 'cuisine',
		'chefname' => 'chef handler',
		'maxpax' => 'max pax',
		'minpax' => 'min pax',
	),
);