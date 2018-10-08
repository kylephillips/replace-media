<?php 
namespace ReplaceMedia\Activation;

use ReplaceMedia\Helpers;

class Dependencies 
{
	private $version;
	private $plugin_dir;

	public function __construct()
	{
		$this->setVersion();
		add_action( 'admin_enqueue_scripts', [$this, 'adminStyles']);
		add_action( 'admin_enqueue_scripts', [$this, 'adminScripts']);
	}

	/**
	* Set the Plugin version
	*/
	private function setVersion()
	{
		global $replace_media_plugin_directory;
		$this->plugin_dir = $replace_media_plugin_directory;
		$this->version = $replace_media_plugin_directory;
	}

	/**
	* Plugin Scripts
	*/
	public function adminScripts()
	{
		wp_enqueue_script(
			'replace-media',
			$this->plugin_dir . '/assets/js/scripts.min.js', 
			['jquery'], 
			$this->version
		);
	}

	/**
	* Admin Styles
	*/
	public function adminStyles()
	{
		wp_enqueue_style(
			'replace-media', 
			$this->plugin_dir . '/assets/css/style.css', 
			[], 
			$this->version
		);
	}
}