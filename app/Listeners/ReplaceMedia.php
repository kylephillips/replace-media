<?php
namespace ReplaceMedia\Listeners;

use ReplaceMedia\Services\Validation;

/**
* Handle the media replacement form
*/
class ReplaceMedia
{
	/**
	* Validation
	*/
	private $validator;

	public function __construct()
	{
		$this->validator = new Validation;
		if ( !$this->validator->replacementValidates($_POST) ) return;
		$this->replaceFile();
	}

	private function replaceFile()
	{
		$original_id = $_POST['original_attachment_id'];
		$file = $_FILES['file'];
		$current_path = get_attached_file($original_id);
		$filename = basename($current_path);
		$path = dirname($current_path);
		unlink($current_path);
		move_uploaded_file($file['tmp_name'], $current_path);
		$this->success();
	}

	private function success()
	{
		$url = 'upload.php?page=replace-media&action=replace_media&success=true';
		header('Location:' . $url);
	}
}