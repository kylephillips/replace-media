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

	/**
	* Attached Posts
	*/
	private $posts = [];

	public function __construct()
	{
		$this->validator = new Validation;
		$this->attributes = new MediaAttributes;
		$this->setAttachedPosts();
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

	/**
	* Find posts this attachment is attached to
	*/
	private function setAttachedPosts()
	{
		global $wpdb;
		$attachment_id = intval($_GET['attachment_id']);
		$filename = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = $attachment_id AND meta_key = '_wp_attached_file'");

		$posts = [];
		$posts_content = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_content LIKE '%$filename%' AND post_status != 'revision' AND post_status != 'inherit'");
		if ( $posts_content ) :
			foreach ( $posts_content as $post ) :
				if ( !isset($posts[$post->ID]) ) $posts[$post->ID] = $post->post_title;
			endforeach;
		endif;

		$postmeta_content = $wpdb->get_results("SELECT * FROM $wpdb->postmeta AS pm LEFT JOIN $wpdb->posts AS p ON p.ID = pm.post_id WHERE meta_value LIKE '%$filename%' AND post_status != 'revision' AND post_status != 'inherit'");
		if ( $postmeta_content ) :
			foreach ( $postmeta_content as $post ) :
				if ( !isset($posts[$post->ID]) ) $posts[$post->ID] = $post->post_title;
			endforeach;
		endif;
		$this->posts = $posts;
	}
}