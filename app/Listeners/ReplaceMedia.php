<?php
namespace ReplaceMedia\Listeners;

use ReplaceMedia\Services\Validation;
use ReplaceMedia\Services\RedirectSave;

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

	/**
	* Redirect Save
	* @var obj
	*/
	private $redirect;

	public function __construct($ajax = false)
	{
		$this->ajax = $ajax;
		$this->validator = new Validation;
		$this->redirect = new RedirectSave;
		if ( !$this->ajax && !$this->validator->replacementValidates($_POST) ) return;
		$this->replaceFile();
	}

	private function replaceFile()
	{
		$rename = ( isset($_POST['no_rename']) && $_POST['no_rename'] == '1' ) ? false : true;
		$original_id = intval($_POST['original_attachment_id']);
		$file = $_FILES['file'];
		
		$current_path = get_attached_file($original_id);
		$filename = ( $rename ) ? basename($current_path) : $file['name'];
		$new_path = ( $rename ) ? $current_path : dirname($current_path) . '/' . $file['name'];

		if ( !$rename ) $this->redirect->save($original_id, $filename);

		unlink($current_path);
		move_uploaded_file($file['tmp_name'], $new_path);
		
		$this->regeneratePdfThumbnail($original_id, $new_path);
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