<?php
namespace ReplaceMedia\Services;

class RedirectSave
{
	/**
	* Save the redirect record to the database
	*/
	public function save($attachment_id, $new_name)
	{
		$original_path = get_post_meta($attachment_id, '_wp_attached_file', true);
		$original_name = basename($original_path);
		$new_path = str_replace($original_name, $new_name, $original_path);
		$original_guid = get_the_guid($attachment_id);
		$new_guid = str_replace($original_name, $new_name, $original_guid);

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
		
		// Update the attachment data
		update_post_meta($attachment_id, '_wp_attached_file', $new_path);
		$wpdb->update($wpdb->posts, 
			['guid' => $new_guid],
			['ID' => $attachment_id],
			['%s']
		);
		$this->updateDatabase($original_guid, $new_guid);
	}

	/**
	* Update the WP database instances
	*/
	private function updateDatabase($original_path, $new_path)
	{
		global $wpdb;
		$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts set post_content = replace(post_content, %s, %s)", $original_path, $new_path));
		$wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta set meta_value = replace(meta_value, %s, %s)", $original_path, $new_path));
	}
}