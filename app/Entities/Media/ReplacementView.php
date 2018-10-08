<?php
namespace ReplaceMedia\Entities\Media;

use ReplaceMedia\Helpers;
use ReplaceMedia\Services\Validation;
use ReplaceMedia\Services\MediaAttributes;

/**
* Registers and renders the replace media interface
* @link /wp-admin/upload.php?page=replace-media
*/
class ReplacementView
{
	/**
	* Validation
	* @object ReplaceMedia\Services\Validation
	*/
	private $validator;

	/**
	* Media Attributes
	* @object ReplaceMedia\Services\MediaAttributes
	*/
	private $attributes;	

	public function __construct()
	{
		$this->validator = new Validation;
		$this->attributes = new MediaAttributes;
		add_action( 'admin_menu', [$this, 'registerReplacementPage' ]);
	}

	/**
	* Register the page for media replacement
	* @see admin_menu
	*/
	public function registerReplacementPage()
	{
		add_submenu_page( 
			NULL,
			__('Replace Media', 'replace-media'),
			__('Replace Media', 'replace-media'),
			'upload_files',
			'replace-media', 
			[$this, 'displayPage']
		);
	}

	/**
	* Display the Page
	*/
	public function displayPage()
	{
		include ( Helpers::view('replace-media') );
	}
}