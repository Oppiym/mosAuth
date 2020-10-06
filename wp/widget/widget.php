<?
/* Виджет авторизации через mos.ru */

/* Виджет MosAuth Widget */
class mosauth_widget extends WP_Widget {

    // Установка идентификатора, заголовка, имени класса и описания для виджета.
    public function __construct() {
        $widget_options = array(
            'classname' => 'mosauth_widget',
            'description' => 'Виджет авторизации через mos.ru',
        );
        parent::__construct( 'mosauth_widget', 'MosAuth Widget', $widget_options );
    }

    // Вывод виджета в области виджетов на сайте.
   public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance[ 'title' ] );
	
	
	
	$inurl = "https://login-tech.mos.ru/sps/oauth/ae?client_id=wptest.dk-moskvor.ru&amp;scope=openid%20contacts%20profile&amp;redirect_uri=http://wptest.dk-moskvor.ru/&amp;response_type=code";
	$outurl = "https://login-tech.mos.ru/sps/login/logout?post_logout_redirect_uri=http://wptest.dk-moskvor.ru/&?logout=1";

	$client_id = "wptest.dk-moskvor.ru";
	$client_secret = base64_encode("wptest.dk-moskvor.ru:P2poOJ5OXpSlPWK");
   $redirect_uri = "http://wptest.dk-moskvor.ru/";
	$url = "https://login-tech.mos.ru/sps/oauth/te";
   $url2 = "https://login-tech.mos.ru/sps/oauth/me";

	$code = $_GET["code"];
//echo $code;


   $postfield = http_build_query(array(
      'grant_type' => 'authorization_code',
      'code' => "$code",
      'redirect_uri' => "$redirect_uri"
   ));

   $header = array(
      "Authorization: Basic $client_secret",
      'Content-Type: application/x-www-form-urlencoded',
      'Cache-Control: no-cache'
   );

   

   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);

   $response = curl_exec($ch);
//echo $response;
	curl_close($ch);

   $tokens = json_decode($response, true);
   $id_token = $tokens['id_token'];
   $access_token = $tokens['access_token'];
   $expires_in = $tokens['expires_in'];
   $scope = $tokens['scope'];
   $token_type = $tokens['token_type'];

   $ch2 = curl_init($url2);

   curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
   curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
      "Authorization: $token_type $access_token",
      'Cache-Control: no-cache'
   ));
	$response2 = curl_exec($ch2);
echo $response2;
   curl_close($ch2);
$profiledata = json_decode($response2, true);

   $lastname = $profiledata['LastName'];
   $middlename = $profiledata['MiddleName'];
   $guid = $profiledata['guid'];
   $firstname = $profiledata['FirstName'];
	$email = $profiledata['mail'];
	$login = explode("@", $email);

 if ( email_exists($email) ){
	echo "Этот e-mail зарегистрирован на пользователя с ID: " . email_exists($email);
   
$ID = 3;
wp_set_auth_cookie( $ID );}
  else {
	register_new_user( $login[0], $email );}




   echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; 
   if ( is_user_logged_in() ) {
	wp_logout(); 
	echo "<a id='mos_button_link' href='$outurl'><div id='mos_button'>Выйти</div></a>";
}
else {
	echo "<a id='mos_button_link' href='$inurl'><div id='mos_button'>Вход через mos.ru</div></a>";
}?>
  
	<?php echo $args['after_widget'];
   }

    // Параметры виджета, отображаемые в области администрирования WordPress.
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Название:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </><?php
    }

    // Обновление настроек виджета в админ-панели.
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        return $instance;
    }

}

// Регистрация и активация виджета.
function mosauth_register_widget() {
    register_widget( 'mosauth_widget' );
}
add_action( 'widgets_init', 'mosauth_register_widget' );









?>