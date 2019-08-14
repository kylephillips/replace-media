<?php
namespace ReplaceMedia\Events;

use ReplaceMedia\Listeners\ReplaceMedia;
use ReplaceMedia\Listeners\ModalHtml;
use ReplaceMedia\Listeners\ModalForm;
use ReplaceMedia\Listeners\MediaDelete;

class RegisterAdminEvents
{
	public function __construct()
	{
		new MediaDelete;
		add_action('admin_post_replace_media', [$this, 'mediaReplaced']);
		add_action('wp_ajax_replace_media_modal_html', [$this, 'modalHtml']);
		add_action('wp_ajax_replace_media_modal_form', [$this, 'modalForm']);
	}

	public function mediaReplaced()
	{
		new ReplaceMedia;
	}

	public function modalHtml()
	{
		new ModalHtml;
	}

	public function modalForm()
	{
		new ModalForm;
	}
}