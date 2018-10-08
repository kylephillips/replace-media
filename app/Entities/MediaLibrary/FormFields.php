<?php
namespace ReplaceMedia\Entities\MediaLibrary;

use ReplaceMedia\Services\MediaAttributes;

/**
* Add the "Replace Media" form field to the media library
*/
class FormFields
{
	/**
	* MediaAttributes
	*/
	private $attributes;

	public function __construct()
	{
		$this->attributes = new MediaAttributes;
		add_filter('attachment_fields_to_edit', [$this, 'formFields'], 10, 2);
	}

	public function formFields($form_fields, $post)
	{
		if ( !$post ) return $form_fields;
		$type = $this->attributes->fileType($post->ID);
		if ( $type[0] == 'Image' ) return;
		$url = admin_url('upload.php?page=replace-media&action=replace_media&attachment_id=' . $post->ID);
		$url = wp_nonce_url( $url, 'replace_media_nonce' );
		$form_fields['replace-media'] = [
			'label' => __('Replace', "replace-media") . ' ' . strtoupper($type[1]), 
			'input' => 'html', 
			'html' => '<p><a class="button-secondary" href="' . $url . '">' . __('Replace this', 'replace-media') . ' ' . $type[0] . '</a></p>'
		];
		return $form_fields;
	}
}