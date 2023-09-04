<?php


if ( ! defined( 'ABSPATH' ) ) {
	die;
}


if(!class_exists('WG_Metaboxes')) {
  class WG_Metaboxes {
    public static $instance;

    public static function instance(){
      if(is_null(self::$instance)) {
        self::$instance = new self();
      }

      return self::$instance;
    }

    public function __construct() {
      add_action('add_meta_boxes', [$this, 'wiro_gallery_add_metabox']);
      add_action('wp_footer', [$this, 'wiro_gallery_load_js']);
      add_action('save_post', [$this, 'wiro_gallery_save_images']);
    } 

    // Register custom taxonomy for gallery categories
    public function wiro_gallery_add_metabox() {
      add_meta_box(
        'gallery_images_metabox',
        __('Gallery Images'),
        [$this, 'wiro_gallery_render_metabox'],
        'gallery',
        'normal',
        'default'
      );
    }

    // Render metabox content
    public function wiro_gallery_render_metabox($post) {
      wp_nonce_field('wiro_gallery_nonce', 'wiro_gallery_nonce');
      
      require dirname(__FILE__) . '/meta-template/wcf-metabox-template.php';
    }

    public function wiro_gallery_load_js() {
       ?>
        <script src="<?php echo dirname(__FILE__) . '/templates/wg-metaboxes-scripts.js'; ?>"></script>
      <?php
    }

    public function wiro_gallery_save_images($post_id) {
      if (!isset($_POST['wiro_gallery_nonce']) || !wp_verify_nonce($_POST['wiro_gallery_nonce'], 'wiro_gallery_nonce')) {
        return;
      }

      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
      }

      if (!current_user_can('edit_post', $post_id)) {
        return;
      }

      if (isset($_POST['gallery_images_ids'])) {
        $gallery_images = array();
        
        foreach($_POST['gallery_images_ids'] as $id) {
          $description = isset($_POST['gallery-image-descs'][$id]) ? sanitize_text_field($_POST['gallery-image-descs'][$id]) : false;

          $gallery_images[] = array(
            'image_id' => $id,
            'description' => $description,
          );
        } 

        update_post_meta($post_id, 'wiro_gallery_images', $gallery_images);
      } else {
        delete_post_meta($post_id, 'wiro_gallery_images');
      }
    }

  }

  WG_Metaboxes::instance();
}