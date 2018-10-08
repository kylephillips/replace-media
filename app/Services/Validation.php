<?php
namespace ReplaceMedia\Services;

class Validation
{
	public function getError($error_code)
	{
		if ( $error_code == '1' ) return __('The original file could not be located.', 'replace-media') . ' <a href="'. admin_url('upload.php') . '">' . __('Back to the Media Library', 'replace_media') . '</a>';
		if ( $error_code == '2' ) return __('Please provide a replacement file.', 'replace-media');
		if ( $error_code == '3' ) return __('The replacement file type must match the file to be replaced.', 'replace-media');
		return __('There was an error replacing the file.', 'replace-media');
	}

	public function hasFile()
	{
		if ( !isset($_GET['action']) && $_GET['action'] !== 'replace_media' ) return false;
		if ( !isset($_GET['attachment_id']) && !is_numeric($_GET['attachment_id']) ) return false;
		return true;
	}

	/**
	* Validation for replace media form
	*/
	public function replacementValidates($request)
	{
		if ( !isset($request['original_attachment_id']) ) return $this->redirect(1, $request);
		if ( !isset($_FILES['file']) || $_FILES['file']['name'] == '' ) return $this->redirect(2, $request);
		if ( !isset($_FILES['file']['type']) || !$this->matchesMimeType($request['original_attachment_id'], $_FILES['file']['type']) ) return $this->redirect(3, $request);
		return true;
	}

	/**
	* Redirect with error
	*/
	private function redirect($error, $request)
	{
		$url = 'upload.php?page=replace-media&action=replace_media&replace_error=' . $error;
		if ( isset($request['original_attachment_id']) ) $url .= '&attachment_id=' . $request['original_attachment_id'];
		header('Location:' . $url);
	}

	/**
	* 
	*/
	private function matchesMimeType($original_attachment_id, $new_type)
	{
		$type = get_post_mime_type($original_attachment_id);
		if ( !$type || $type !== $new_type ) return false;
		return true;
	}
}