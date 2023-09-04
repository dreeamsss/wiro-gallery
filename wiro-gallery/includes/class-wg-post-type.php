
<?php


if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if(!class_exists('WG_Post_Type')) {
  class WG_Post_Type {
    public static $instance;

    public static function instance(){
      if(is_null(self::$instance)) {
        self::$instance = new self();
      }

      return self::$instance;
    }

    public function __construct() {
      add_action('init', [$this, 'wiro_gallery_register_post_type']);
      add_action('template_redirect', [$this, 'wiro_redirect_gallery_single']);
    } 

    public function wiro_gallery_register_post_type() {
      register_post_type('gallery',
        array(
          'labels' => array(
            'name' => __('Галерея'),
            'singular_name' => __('Галерея'),
            'add_new' => __('Добавить новую галерею'),
            'add_new_item' => __('Добавить новую галерею'),
            'edit_item' => __('Редактировать галерею'),
            'new_item' => __('Новая галерея'),
            'view_item' => __('Просмотреть галерею'),
            'search_items' => __('Искать галерею'),
            'not_found' => __('Галереи не найдены'),
            'not_found_in_trash' => __('Галереи в корзине не найдены'),
            'parent_item_colon' => __('Родительская галерея:'),
            'menu_name' => __('Галерея'),
          ),
          'public' => true,           // Позволяет отображать тип записи в админ-панели и на сайте
          'has_archive' => false,     // Отключает страницу архива для этого типа записи
          'menu_icon' => 'dashicons-format-gallery',  // Иконка для меню
          'supports' => array('title'), // Добавляет поддержку заголовка и миниатюры (featured image)
          'rewrite' => array('slug' => 'gallery-item'), // Перезапись URL
          'show_ui' => true,          // Показывать интерфейс редактирования в админ-панели
          'show_in_menu' => true,     // Показывать в меню админ-панели
          'show_in_nav_menus' => true, // Показывать в меню навигации (например, в меню сайта)
          'show_in_rest' => false,     // Показывать в новом блоке редактирования Gutenberg
        )
      );
    }

    public function wiro_redirect_gallery_single() {
    if (is_singular('gallery')) {
      wp_redirect(get_404_template());
      exit();
    }
}

  }

  WG_Post_Type::instance();
}
  