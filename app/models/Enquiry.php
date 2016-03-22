<?php

class Enquiry extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'enquiries';

	public static function getNumberOfMyEnquiries($id)
	{
		return Enquiry::where('userid', '=', $id)->where('paid', '=', '0')->count();
	}

	public static function getNumberOfApprovedUnpaidEnquiries($id)
	{
		return Enquiry::where('chefid', '=', $id)->where('approved', '=', '1')->where('paid', '=', '0')->count();
	}

	public static function getNumberOfPendingEnquiries($id)
	{
		return Enquiry::where('chefid', '=', $id)->where('approved', '=', '0')->count();
	}

	public static function getNumberOfPendingReviews($id)
	{
		$enquiries = Enquiry::where('approved', '=', '1')
			->where('paid', '=', '1')
			->where('userid', '=', $id)
			->get();

		$count = 0;
		foreach ($enquiries as $enquiry)
		{
			$review = Review::where('enquiryid', '=', $enquiry->id)->first();
			if (!$review) {
				$count++;
			}
		}

		return $count;
	}

	public static function getPendingReviews($id)
	{
		$enquiries = Enquiry::where('approved', '=', '1')
			->where('paid', '=', '1')
			->where('userid', '=', $id)
			->get();

		$pendingReviews = array();
		foreach ($enquiries as $enquiry)
		{
			$review = Review::where('enquiryid', '=', $enquiry->id)->first();
			if (!$review) {
				$pendingReviews[] = $enquiry;
			}
		}

		return $pendingReviews;
	}

	public function getMenuUrl()
	{
		$chef = User::find($this->chefid);
		return "/chef/" . $chef->chefname . "/" . $this->menuid;
	}

	public function getProfile()
	{
		return Profile::where('userid', '=', $this->chefid)->first();
	}

	public function getChefName()
	{
		$chef = User::find($this->chefid);
		return $chef->chefname;
	}

	public function getChefFullName()
	{
		$chef = User::find($this->chefid);
		return $chef->getName();
	}

	public function getUserName()
	{
		$user = User::find($this->userid);
		$history = $user->getLatestHistory();
		return $history->firstname . " " . $history->lastname;
	}

	public function getMenu()
	{
		return Menu::find($this->menuid);
	}

	public function getMenuName()
	{
		$menu = $this->getMenu();
		return $menu->getLatestHistory()->title;
	}

	public function getTotalPrice()
	{
		return number_format($this->getPriceLessAdditional() + $this->additionalcost, 2);
	}

	public function getSurcharge()
	{
		return $this->getTotalPrice() * .10;
	}

	public function getTotalPriceLessSurcharge()
	{
		return number_format($this->getTotalPrice() - $this->getSurcharge(), 2);
	}

	public function getTotalPriceInCents()
	{
		return $this->getTotalPrice() * 100;
	}
	
	public function getPrice()
	{
		return number_format($this->price, 2);
	}
	
	public function getAdditionalCost()
	{
		return number_format($this->additionalcost, 2);
	}
	
	public function getPriceLessAdditional()
	{
		return number_format($this->price * $this->quantity, 2);
	}

	public function getEnquiryDate()
	{
		return date('d/m/Y', strtotime($this->enquirydate));
	}

	public function getTime()
	{
		return date('g:i A', strtotime($this->time));
	}

	public function getCreatedAt()
	{
		return $this->created_at->format('d/m/Y g:i A');
	}

	public function getUpdatedAt()
	{
		return $this->updated_at->format('d/m/Y g:i A');
	}

	public static function getValidationRules()
	{
		return array(
			'quantity' => 'required',
			'enquirydate' => 'required|date_format:"d/m/Y"',
			'time' => 'required|date_format:"g:i A"',
			'additionalcost' => 'numeric'
		);
	}
}
