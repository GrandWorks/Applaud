<?php

/**
 * Fired during plugin activation
 *
 * @link       https://grandworks.co
 * @since      1.0.0
 *
 * @package    Applaud
 * @subpackage Applaud/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Applaud
 * @subpackage Applaud/includes
 * @author     GrandWorks <hello@grandworks.co>
 */
class Applaud_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		global $table_prefix;
		$tablename = $table_prefix . "wp_applaud";
		$database_name = $wpdb->dbname;
		if($wpdb->get_var( "show tables like '$tablename'" ) != $tablename) 
		{

			$sql = "CREATE TABLE $tablename ( `post_id` INT NOT NULL , `number_of_votes` INT UNSIGNED NOT NULL , PRIMARY KEY (`post_id`)) ENGINE = InnoDB;";

			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			dbDelta($sql);
		}

	}

}
