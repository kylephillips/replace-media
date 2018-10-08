<?php
namespace ReplaceMedia\Events;

use ReplaceMedia\Listeners\ReplaceMedia;

class RegisterAdminEvents
{
	public function __construct()
	{
		add_action( 'admin_post_replace_media', [$this, 'mediaReplaced']);
	}

	public function mediaReplaced()
	{
		new ReplaceMedia;
	}
}