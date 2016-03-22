<?php

class EnquiryController extends BaseController {

	public function myEnquiries()
	{
		$myEnquiries = Enquiry::where('userid', '=', Auth::id())->orderBy('created_at', 'desc')->get();

		return View::make('my.enquiries.index', array('myEnquiries' => $myEnquiries));
	}

	public function getConfirmEnquiries()
	{
		return Redirect::to('/my/chef/enquiries')
			->with('tab', '.confirmed');
	}

	public function chefEnquiries()
	{
		$enquiries = Enquiry::where('chefid', '=', Auth::id())->where('approved', '=', '0')->orderBy('created_at', 'desc')->get();
		$approvedEnquiries = Enquiry::where('chefid', '=', Auth::id())->where('approved', '=', '1')->orderBy('created_at', 'desc')->get();

		return View::make('my.enquiries.chef-enquiries', array('enquiries' => $enquiries, 'approvedEnquiries' => $approvedEnquiries));
	}

	public function getEnquiry($id)
	{
		$enquiry = Enquiry::find($id);

		if ($enquiry && ($enquiry->chefid == Auth::id() || $enquiry->userid == Auth::id())) {
			return View::make('my.enquiries.enquiry', array('enquiry' => $enquiry));
		}
		else {
			return Redirect::to('/my/enquiries')
				->with('error_message', 'Invalid enquiry.');
		}
	}

	public function updateEnquiry($enquiryid)
	{
		$enquiry = Enquiry::find($enquiryid);

		$rules = Enquiry::getValidationRules();
		$validator = Validator::make(Input::all(), $rules);

		if (!$validator->fails() && ($enquiry->userid == Auth::id() || $enquiry->chefid == Auth::id())) {		
			$date = DateTime::createFromFormat('d/m/Y', Input::get('enquirydate'));
			
			if ($enquiry->chefid == Auth::id())
			{
				$enquiry->price = Input::get('price');
				$enquiry->additionalcost = Input::get('additionalcost');
			}			
			
			$enquiry->enquirydate = $date->format('Y-m-d');
			$enquiry->time = date('G:i:s', strtotime(Input::get('time')));
			$enquiry->quantity = Input::get('quantity');
			$enquiry->usechefvenue = Input::has('usechefvenue') ? Input::get('usechefvenue') : 0;
			$enquiry->venue = Input::get('venue');
			$enquiry->specialreq = Input::get('specialreq');
			$enquiry->additionalinfo = Input::get('additionalinfo');
			$enquiry->save();

			Email::generateEnquiryUpdateToChef($enquiry);

			return Redirect::back()
				->with('info_message', 'Thank you for your enquiry! The chef will contact you shortly.');
		}
		else {
			return Redirect::back()
				->with('error_message', 'There has been an error with your request.')
				->withErrors($rules);
		}
	}

	public function postEnquiry($chefname, $menuid)
	{
		$chef = User::where('chefname', '=', $chefname)->first();
		$menu = Menu::find($menuid);

		$rules = Enquiry::getValidationRules();
		$validator = Validator::make(Input::all(), $rules);

		if (!$validator->fails() && $chef && $menu) {
			$date = DateTime::createFromFormat('d/m/Y', Input::get('enquirydate'));

			$enquiry = new Enquiry;
			$enquiry->userid = Auth::id();
			$enquiry->chefid = $chef->id;
			$enquiry->menuid = $menu->id;
			$enquiry->enquirydate = $date->format('Y-m-d');
			$enquiry->time = date('G:i:s', strtotime(Input::get('time')));
			$enquiry->quantity = Input::get('quantity');
			$enquiry->usechefvenue = Input::has('usechefvenue') ? Input::get('usechefvenue') : 0;
			$enquiry->venue = Input::get('venue');
			$enquiry->specialreq = Input::get('specialreq');
			$enquiry->additionalinfo = Input::get('additionalinfo');
			$enquiry->price = $menu->getLatestHistory()->price;
			$enquiry->save();

			Email::generateEnquiryEmailToChef($enquiry);
			Email::generateEnquiryEmailToUser($enquiry);

			return Redirect::back()
				->with('info_message', 'Thank you for your enquiry! The chef will contact you shortly.');
		}
		else {
			return Redirect::back()
				->with('error_modal', true)
				->with('error_message', 'There has been an error with your request.')
				->withErrors($rules)
				->withInput(Input::all());
		}
	}

	public function confirmEnquiry($id)
	{
		$enquiry = Enquiry::find($id);

		if ($enquiry && ($enquiry->chefid == Auth::id() || $enquiry->userid == Auth::id()) && !$enquiry->approved) {
			$enquiry->approved = 1;
			$enquiry->save();

			Email::generateEnquiryConfirmationToUser($enquiry);

			return Redirect::to('/my/chef/enquiries/confirm')
				->with('info_message', 'An enquiry has been confirmed.');
		}
		else {
			return Redirect::to('/my/chef/enquiries')
				->with('error_message', 'Invalid enquiry.');
		}
	}

	public function payEnquiry($id)
	{
		$enquiry = Enquiry::find($id);
		Stripe::setApiKey(Config::get('stripe.secret'));
		$token = $_POST['stripeToken'];

		if ($enquiry && $enquiry->userid == Auth::id() && $enquiry->approved && !$enquiry->paid) {
			// Create the charge on Stripe's servers - this will charge the user's card
			try {
				$charge = Stripe_Charge::create(array(
				  "amount" => $enquiry->getTotalPriceInCents(), // amount in cents, again
				  "currency" => "aud",
				  "card" => $token,
				  "description" => $enquiry->getMenuName() . " - " . $enquiry->getChefName())
				);

				$enquiry->paid = 1;
				$enquiry->save();

				Email::generateEnquiryPaidToUser($enquiry);
				Email::generateEnquiryPaidToChef($enquiry);

				return Redirect::to('/my/enquiries/' . $enquiry->id)
					->with('info_message', 'Payment was successful!');

			} catch(Stripe_CardError $e) {
				// The card has been declined
				return Redirect::to('/my/enquiries/' . $enquiry->id)
					->with('error_message', 'Credit card has been declined.');
			}
		}
		else {
			return Redirect::to('/my/enquiries')
				->with('error_message', 'Invalid enquiry.');
		}
	}

	public function amend($id)
	{
		$enquiry = Enquiry::find($id);

		$validator = Validator::make(Input::all(), Amendment::getValidationRules());

		if ($validator->fails()) {
			return Redirect::back()
				->with('error_message', 'Menu description is required for all menu items!');
		}
		else {
			if ($enquiry->chefid == Auth::id())
			{
				$menuitemid = Input::get('menuitemid');

				$amendment = Amendment::getAmendment($id, $menuitemid);
				if (!$amendment)
				{
					$amendment = new Amendment;
				}

				$amendment->enquiryid = $enquiry->id;
				$amendment->menuitemid = $menuitemid;
				$amendment->description = Input::get('description');
				$amendment->save();

				return Redirect::back()
					->with('info_message', 'Your menu item has been amended!');
			}
		}
	}
}
