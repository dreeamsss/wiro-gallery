
<?php
  $gallery_images = get_post_meta($post->ID, 'wiro_gallery_images', true);
?>


<div>
    <label for="gallery-images"><?php _e('Select Images', 'custom-gallery'); ?></label>
    <input type="button" id="gallery-images-button" class="button" value="<?php _e('Upload Images', 'custom-gallery'); ?>">
    <ul class="gallery-images-list">
      <?php
        if (!empty($gallery_images)) {
          foreach ($gallery_images as $image) { ?>
            <li class="gallery-images-item">
              <?php  echo wp_get_attachment_image($image['image_id'], 'wiro-gallery-thumb'); ?>
              <input type="hidden" id="gallery-images-ids" name="gallery_images_ids[]" value="<?php echo $image['image_id']; ?>">
              <div class="gallery-images-actions">
                <input type="text" placeholder="Подписать фото" name="gallery-image-descs[<?php echo $image['image_id']; ?>]" 
                  value="<?php echo isset($image['description']) ? $image['description'] : ""; ?>">
                <button type="button" class="gallery-images-clear">
                  X
                </button>
              </div>
            </li>
          <?php
          }
        }
      ?>
    </ul>
</div>