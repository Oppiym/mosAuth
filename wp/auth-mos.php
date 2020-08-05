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
$auth_mos_client_id = 1;

$path = dirname(__FILE__); 
include($path . '/admin-menu/admin.php');
include($path . '/widget/widget.php');


?>