<?php
namespace ReplaceMedia\Listeners;

class MediaDelete
{
	public function __construct()
	{
		add_action('delete_post', [$this, 'removeRedirect']);
	}

	/**
	* Remove redirects when a file is deleted permanently
	*/
	public function removeRedirect($attachment_id)
	{
		global $wpdb;
		$table = $wpdb->prefix . 'replace_media_redirects';
		$wpdb->delete($table, ['attachment_id' => $attachment_id], ['%d']);
	}
}