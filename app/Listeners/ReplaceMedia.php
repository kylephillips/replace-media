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

	/**
	* Ajax Request
	* @var bool
	*/
	private $ajax;

	public function __construct($ajax = false)
	{
		$this->ajax = $ajax;
		$this->validator = new Validation;
		if ( !$this->ajax && !$this->validator->replacementValidates($_POST) ) return;
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
		$this->regeneratePdfThumbnail($original_id, $current_path);
		$this->success();
	}

	private function regeneratePdfThumbnail($id, $path)
	{
		$type = get_post_mime_type($id);
		if ( $type !== 'application/pdf' ) return;
		$new_meta = wp_generate_attachment_metadata($id, $path);
		wp_update_attachment_metadata($id, $new_meta);
	}

	private function success()
	{
		if ( $ajax ) return;
		$url = 'upload.php?page=replace-media&action=replace_media&success=true';
		header('Location:' . $url);
	}
}