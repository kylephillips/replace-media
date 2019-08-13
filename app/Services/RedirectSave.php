<?php
namespace ReplaceMedia\Services;

class RedirectSave
{
	public function save($attachment_id, $new_name)
	{
		$url = wp_get_attachment_url( $attachment_id );
		$uploads = wp_upload_dir();
		$original_name = basename($url);
		
		$original_path = str_replace( $uploads['baseurl'], '', $url );
		$new_path = str_replace($original_name, $new_name, $original_path);

		global $wpdb;
		$table = $wpdb->prefix . 'replace_media_redirects';
		$user_id = get_current_user_id();
		$wpdb->insert(
			$table,
			[
				'attachment_id' => $attachment_id,
				'source' => $original_path,
				'destination' => $new_path,
				'user_id' => $user_id
			],[
				'%d',
				'%s',
				'%s',
				'%d'
			]
		);
	}
}