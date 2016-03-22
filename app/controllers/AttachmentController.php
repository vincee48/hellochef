<?php

class AttachmentController extends BaseController {

	public function menuAttachments($id)
	{
		$menu = Menu::find($id);
		$back = '/my/settings/menu/' . $id;

		if ($menu && $menu->belongsToUser()) {
			$docs = $menu->getPictures();
			return View::make('attachment.control', array('back' => $back, 'pics' => $docs));
		}

		return Redirect::to($back)
			->with('error_message', 'Invalid menu.');
	}

	public function postMenuAttachments($id)
	{
		$files = Input::file('pics');
		$menu = Menu::find($id);
		
		foreach ($files as $file) {
			$rules = array(
				'file' => 'image',
			);
			
			$validator = Validator::make(array('file' => $file), $rules);

			if ($validator->fails()) {
				return Redirect::back()
					->withErrors($validator)
					->with('error_message', 'There has been an error with your input');
			}
			if ($file && $file->isValid())
			{
				$doc = new Document;
				$doc->userid = Auth::id();
				$doc->uploadedby = Auth::id();
				$doc->filename = str_random(20) . "." . $file->getClientOriginalExtension();
				$doc->filetype = $file->getMimeType();
				$doc->filesize = $file->getSize();
				$doc->filecontent = file_get_contents($file);
				$doc->save();

				$menudoc = new MenuDocument;
				$menudoc->menuid = $menu->id;
				$menudoc->documentid = $doc->id;
				$menudoc->description = "";
				$menudoc->save();
			}
			else {
				return Redirect::back()
					->with('error_message', 'Image is invalid');
			}					
		}				
		
		return Redirect::back()
			->with('info_message', 'Your images has been added');
	}

	public function chefStep3()
	{
		$lead = Lead::getLeadForUser(Auth::id());
		$menu = $lead->getMenu();
		$docs = $menu->getPictures();
		$back = '/my/become-a-chef/step-3';

		return View::make('attachment.control', array('back' => $back, 'pics' => $docs));
	}

	public function postChefStep3()
	{
		$files = Input::file('pics');

		$lead = Lead::getLeadForUser(Auth::id());
		$menu = $lead->getMenu();
		
		foreach ($files as $file) {
			$rules = array(
				'file' => 'image',
			);
			
			$validator = Validator::make(array('file' => $file), $rules);

			if ($validator->fails()) {
				return Redirect::back()
					->withErrors($validator)
					->with('error_message', 'There has been an error with your input');
			}
			if ($file && $file->isValid())
			{
				$doc = new Document;
				$doc->userid = Auth::id();
				$doc->uploadedby = Auth::id();
				$doc->filename = str_random(20) . "." . $file->getClientOriginalExtension();
				$doc->filetype = $file->getMimeType();
				$doc->filesize = $file->getSize();
				$doc->filecontent = file_get_contents($file);
				$doc->save();

				$menudoc = new MenuDocument;
				$menudoc->menuid = $menu->id;
				$menudoc->documentid = $doc->id;
				$menudoc->description = "";
				$menudoc->save();
			}
			else {
				return Redirect::to('/my/become-a-chef/step-3')
					->with('error_message', 'Image is invalid');
			}					
		}				
		
		return Redirect::to('/my/become-a-chef/step-3')
			->with('info_message', 'Your images has been added');
	}

	public function updateMenuAttachments($id)
	{
		$doc = MenuDocument::find($id);

		$validator = Validator::make(Input::all(), array('description' => 'required'));

		if ($validator->fails()) {
			return Redirect::back()
				->with('error_message', 'There has been an error with your input!');
		}
		else {
			$doc->description = Input::get('description');
			$doc->save();

			return Redirect::back()
				->with('info_message', 'Your image title has been updated!');
		}
	}
}
