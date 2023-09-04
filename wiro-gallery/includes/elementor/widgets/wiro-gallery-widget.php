<?php

namespace wiro_gallery_elementor;

class Wiro_Gallery_Widget extends \Elementor\Widget_Base {
  public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'wiro-gallery-widget', plugins_url('/js/wiro-gallery-widget.js', __FILE__ ), [ 'elementor-frontend', 'jquery' ], '1.0', true);
   }

  public function get_script_depends() {
    if(\Elementor\Plugin::$instance->preview->is_preview_mode()) {
      return ['wiro-gallery-widget'];
    }
    return [];
  }

	public function get_name() {
		return 'wiro_gallery_widget';
	}

	public function get_title() {
		return esc_html__( 'Wiro Gallery', 'wiro-gallery' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'about' ];
	}

	protected function register_controls() {

		// Content Tab Start

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Main', 'wiro-gallery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// $this->add_control(
		// 	'title',
		// 	[
		// 		'label' => 'Заголовок',
		// 		'type' => \Elementor\Controls_Manager::TEXT,
		// 		'default' => '',
		// 		'placeholder' => 'Введите заголовок',
		// 	]	
		// );


		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
      <section class="gallery-images">
				<?php
					//if($settings['title']){ ?>
						<!-- <div class="container">
							<h2 class="gallery-images-title"><?php echo esc_html($settings['title']); ?></h2>
						</div> -->
					<?php	
					//}
				?>
        <?php
					$gallery_posts = get_posts(array(
						'post_type' => 'gallery',
						'posts_per_page' => -1,
					));

					if($gallery_posts) { ?>
						<div class="container">
							<ul class="gallery-filters">
								<li class="filter active" data-filter=""> 
									<button>
										Все
									</button>
								</li>
								<?php
									foreach($gallery_posts as $gallery_post) { ?>
										<li class="filter" data-filter="<?php echo ".gallery-".$gallery_post->ID; ?>"> 
											<button>
												<?php echo esc_html($gallery_post->post_title); ?>
											</button>
										</li>
									<?php }
								?>
							</ul>
						</div>
						<div class="gallery-pager">
							<div class="container">
								<div class="pager-list">
									
								</div>
							</div>
						</div>
						<div class="gallery-images-row">
							<?php
								foreach($gallery_posts as $gallery_post) {
									$gallery_images = get_post_meta($gallery_post->ID, 'wiro_gallery_images', true);

									foreach($gallery_images as $image) { ?>
										<div class="gallery-images-el <?php echo "gallery-".$gallery_post->ID; ?>">
											<a href="<?php echo wp_get_attachment_url($image['image_id']); ?>"  data-lightbox="gallery-img" data-title="<?php echo esc_html($image['description']); ?>">
												<?php echo wp_get_attachment_image($image['image_id'], 'medium'); ?>
											</a>
											<?php if($image['description']) { ?>
												<div class="gallery-image-desc">
													<?php echo esc_html($image['description']); ?>
												</div>
											<?php } ?>
										</div>
									<?php
									}
								} ?>
						</div>
					<?php
					}
				?>
      </section>
	  <?php
	}
}