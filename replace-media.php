<?php
/*
Plugin Name: Replace Media
Plugin URI: https://github.com/kylephillips
Description: Replace documents within the media library completely and preserve file names.
Version: 1.0.1
Author: Kyle Phillips
Author URI: https://github.com/kylephillips
License: GPL
*/
$replace_media = require_once('vendor/autoload.php');
require_once('app/Bootstrap.php');
$replace_media = new ReplaceMedia\Bootstrap;