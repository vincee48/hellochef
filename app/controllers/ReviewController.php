<?php

class ReviewController extends BaseController {

	public function getReviews()
	{
		$pendingReviews = Enquiry::getPendingReviews(Auth::id());
		return View::make('my.reviews', array('pendingReviews' => $pendingReviews));
	}

	public function postReviews()
	{
		$validator = Validator::make(Input::all(), Review::getValidationRules());

		$enquiry = Enquiry::find(Input::get('enquiryid'));

		if ($validator->fails()) {
			return Redirect::to('/my/reviews')
				->withErrors($validator)
				->withInput(Input::all())
				->with('error_message', 'There has been an error with your input.');
		}
		else if (!$enquiry || $enquiry->userid != Auth::id()) {
			return Redirect::to('/my/reviews')
				->withInput(Input::all())
				->with('error_message', 'Invalid review.');
		}
		else {
			$review = new Review;
			$review->fromuser = Auth::id();
			$review->profileid = $enquiry->getProfile()->id;
			$review->negative = Input::get('negative');
			$review->summary = Input::get('summary');
			$review->content = Input::get('content');
			$review->enquiryid = Input::get('enquiryid');
			$review->save();

			return Redirect::to('/my/reviews')
				->with('info_message', 'Thank you for leaving a review!');
		}
	}
}
