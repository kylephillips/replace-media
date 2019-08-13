<?php
namespace ReplaceMedia\Migrations;

/**
* Create the necessary DB Tables
*/
class CreateTables
{
	public function __construct()
	{
		$this->redirectsTable();
	}

	/**
	* Create the redirects table if it doesn't exist
	*/
	private function redirectsTable()
	{
		$table_installed = get_option('replace_media_redirects_table_installed');
		if ( $table_installed ) return;

		global $wpdb;
		$tablename = $wpdb->prefix . 'replace_media_redirects';
		if ( $wpdb->get_var('SHOW TABLES LIKE "' . $tablename . '"') != $tablename ) :
			$sql = 'CREATE TABLE ' . $tablename . '(
				id INTEGER(10) UNSIGNED AUTO_INCREMENT,
				time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				attachment_id INTEGER(10),
				source MEDIUMTEXT,
				destination MEDIUMTEXT,
				user_id INTEGER(10),
				PRIMARY KEY  (id) )';
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			update_option('replace_media_redirects_table_installed', true);
		endif;
	}
}