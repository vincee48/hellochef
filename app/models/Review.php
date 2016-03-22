<?php

class Review extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reviews';

	public function getCreatedAt()
	{
		return $this->created_at->format('d/m/Y g:i A');
	}

	public static function getValidationRules()
	{
		return array(
			'summary' => 'required',
			'content' => 'required|min:20',
			'negative' => 'required|boolean',
			'enquiryid' => 'required'
		);
	}

	public static function getRandomReviews($profileid, $max)
	{
		$reviews = Review::where('profileid', '=', $profileid)->get();

		if (count($reviews) > 1) {
			shuffle($reviews);
			return array_slice($reviews, 0, $max);
		}
		else {
			return $reviews;
		}
	}

	public function getUser()
	{
		return User::find($this->fromuser);
	}
}
