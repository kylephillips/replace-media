<?php
namespace ReplaceMedia\Entities\Redirect;

/**
* Handle redirects for replaced media
*/ 
class Redirect
{
	public function __construct()
	{
		add_action('template_redirect', [$this, 'redirect']);
	}

	public function redirect()
	{
		if ( !is_404() ) return;
		global $wp;
		global $wp_query;
		global $wpdb;

		$uploads = wp_upload_dir();
		$base_url = rtrim($uploads['baseurl'], '/');

		$base_dir = ltrim(str_replace(get_bloginfo('url'), '', $base_url), '/');
		$search = ltrim(str_replace($base_dir, '', $wp->request), '/');
		$table = $wpdb->prefix . 'replace_media_redirects';

		$redirect = $wpdb->get_row("SELECT * FROM $table WHERE source = '$search' ORDER BY id DESC LIMIT 1");
		if ( !$redirect ) return;
		wp_redirect(get_the_permalink($redirect->attachment_id));
	}
}