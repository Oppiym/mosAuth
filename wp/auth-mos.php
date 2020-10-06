<?php
/*
 * Plugin Name: Авторизация через mos.ru
 * Description: Данный плагин добавляет виджет в виде кнопки для автризации пользователя на сайте через mos.ru
 * Plugin URI:  Ссылка на инфо о плагине
 * Author URI:  Ссылка на автора
 * Author:      Вячеслав Павлов
 * Version:     0.1 
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
global $auth_mos_client_id, $auth_mos_client_secret, $auth_mos_scope;

$path = dirname(__FILE__); 
include($path . '/admin-menu/admin.php');
include($path . '/widget/widget.php');

$mos_db_version = "1.0";

function mos_install () {
   global $wpdb;
   global $mos_db_version;

   $table_name = $wpdb->prefix . "mosauth";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
   $sql = "CREATE TABLE " . $table_name . " (
   id mediumint(9) NOT NULL AUTO_INCREMENT,
	client_id text DEFAULT '0' ,
	mos_client_secret text ,
	mos_scope text ,
	UNIQUE KEY id (id)
	);";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);

   $auth_mos_client_id = "Mr. WordPress";
   $auth_mos_client_secret = "Congratulations, you just completed the installation!";
	$auth_mos_scope = "La la la";
	$insert = "INSERT INTO " . $table_name .
            " (client_id, mos_client, mos_scope) " .
            "VALUES ('" . $wpdb->escape($auth_mos_client_id) . "','" . $wpdb->escape($auth_mos_client_secret) . "','" . $wpdb->escape($auth_mos_scope) . "')";

      $results = $wpdb->query( $insert );
      add_option("mos_db_version", $mos_db_version);

   }
}
register_activation_hook(__FILE__,'mos_install');
?>