<?php

class ImageController extends BaseController {

	public function getImage($userid, $file) 
	{
		$user = User::find($userid);
		$image = Document::where('userid', '=', $userid)->where('filename', '=', $file)->first();
		
		$response = Response::make($image->filecontent, 200);
		
		$response->header('content-type', $image->filetype);
		$response->header('content-length', strlen($image->filecontent));
		
		return $response;
	}

	public function deleteImage($userid, $file)
	{
		$image = Document::where('userid', '=', $userid)->where('filename', '=', $file)->first();
		
		if ($userid == Auth::id()) {
			$map = MenuDocument::where('documentid', '=', $image->id)->first();
			if ($map) {
				$map->delete();
			}
			$image->delete();
		}
		
		return Redirect::back()
			->with('info_message', 'An attachment has been deleted');
	}
	
	public function cropImage()
	{
		$file = Input::get('img');
		$olddoc = Auth::user()->getProfilePicture();
		if ($olddoc) {
			$olddoc->delete();
		}
		$doc = new Document;
		$doc->userid = Auth::id();
		$doc->uploadedby = Auth::id();
		$doc->filename = str_random(20) . ".jpg";
		$doc->filetype = "image/jpeg";
		$doc->filesize = strlen($file);
		$doc->filecontent = file_get_contents($file);
		$doc->isprofilepic = 1;
		$doc->save();
	}
	
	public function adminCropImage($userid)
	{
		$user = User::find($userid);
		$file = Input::get('img');
		$olddoc = $user->getProfilePicture();
		if ($olddoc) {
			$olddoc->delete();
		}
		$doc = new Document;
		$doc->userid = $userid;
		$doc->uploadedby = Auth::id();
		$doc->filename = str_random(20) . ".jpg";
		$doc->filetype = "image/jpeg";
		$doc->filesize = strlen($file);
		$doc->filecontent = file_get_contents($file);
		$doc->isprofilepic = 1;
		$doc->save();
	}
}