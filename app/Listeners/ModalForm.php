<?php
namespace ReplaceMedia\Listeners;

use ReplaceMedia\Listeners\ReplaceMedia;
use ReplaceMedia\Services\Validation;

/**
* Process the Modal Form
*/
class ModalForm
{
	/**
	* Validation
	*/
	private $validator;

	public function __construct()
	{
		$this->validator = new Validation;
		$this->process();
	}

	private function process()
	{
		if ( $this->validator->replacementValidates($_POST, true) ) {
			new ReplaceMedia(true);
			return wp_send_json(['status' => 'success']);
		}
	}
}