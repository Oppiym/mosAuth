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
        $blog_title = get_bloginfo( 'name' );
        $tagline = get_bloginfo( 'description' );

        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>
        <a id='mos_button_link' href= "<?php echo get_site_url(); ?>"
		  <div id='mos_button'>Вход через mos.ru</div></a>
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