<?php 
namespace ReplaceMedia;

/**
* Primary Plugin class
*/
class Bootstrap 
{
	function __construct()
	{
		$this->defineGlobals();
		$this->pluginInit();
		add_action( 'init', [$this, 'init']);
	}

	/**
	* Define Globals
	*/
	public function defineGlobals()
	{
		global $replace_media_plugin_directory;
		$replace_media_plugin_directory = plugins_url() . '/' . basename(dirname(dirname(__FILE__)));

		global $replace_media_version;
		$replace_media_version = '1.0.0';
	}

	/**
	* Initialize the Plugin
	*/
	public function pluginInit()
	{
		$this->addLocalization();
		new Activation\Dependencies;
		new Events\RegisterAdminEvents;
		new Entities\MediaLibrary\FormFields;
		new Entities\Media\ReplacementView;
	}

	/**
	* WordPress Initialized Action
	*/
	public function init()
	{

	}


	/**
	* Localization Domain
	*/
	public function addLocalization()
	{
		load_plugin_textdomain(
			'replace-media', 
			false, 
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
	}
}