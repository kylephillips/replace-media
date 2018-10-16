<?php
namespace ReplaceMedia\Listeners;

use ReplaceMedia\Services\Validation;
use ReplaceMedia\Services\MediaAttributes;

/**
* Returns the HTML for the modal form in ajax request
*/
class ModalHtml
{
	/**
	* The HTML to return
	*/
	private $html; 

	/**
	* Validator
	*/
	private $validator;

	/**
	* Media Attributes
	*/
	private $attributes;

	public function __construct()
	{
		$this->validator = new Validation;
		$this->attributes = new MediaAttributes;
		$this->getForm();
		return wp_send_json(['status' => 'success', 'attachment_id' => $attachment_id, 'html' => $this->html]);
	}

	private function getForm()
	{
		ob_start();
		$in_modal = true;
		include ( \ReplaceMedia\Helpers::view('replace-media') );
		$html = ob_get_contents();
		ob_end_clean();
		$this->html = $html;
	}
}