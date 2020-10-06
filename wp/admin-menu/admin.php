<?php

add_action('admin_menu', 'auth_mos_plugin_menu');
function auth_mos_plugin_menu() {
	add_options_page('My Options', 'Авторизация через mos.ru', 'manage_options', 'auth-mos-plugin', 'auth_mos_plugin_page');
}

function auth_mos_plugin_page(){
	echo "Введите ващи данные для подключения к внешнему контуру СУДИР";
	global $auth_mos_client_id, $auth_mos_client_secret, $auth_mos_client_scope;
	?> 
		<form action="mos-auth.php" method="post">
		<div>
		<p>Ваш client_id: <input type="text" name="client_id" value="<?php echo $auth_mos_client_id?>" /></p>
		<p>Ваш client_secret: <input type="text" name="age" value="<?php echo $auth_mos_client_secret?>"/></p>
		<p>Ваш scope, через пробел: <input type="text" name="scope" value="<?php echo $auth_mos_client_scope?>"/></p>
		<p><input type="submit" />Сохранить</p>
		</div>
</form>
<?
}
?>