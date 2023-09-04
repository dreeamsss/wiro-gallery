jQuery(document).ready(function ($) {
  $("#gallery-images-button").click(function (e) {
    e.preventDefault();
    var mediaUploader = wp.media({
      title: "Choose Images",
      button: {
        text: "Choose Images",
      },
      multiple: true,
    });

    mediaUploader.on("select", function () {
      // console.log(mediaUploader);
      var attachmentIds = [];
      mediaUploader
        .state()
        .get("selection")
        .each(function (attachment) {
          attachmentIds.push(attachment.attributes.id);

          $(".gallery-images-list").prepend(
            `<li class="gallery-images-item">
                  <img src="${attachment.attributes.url}" class="attachment-thumbnail" />
                  <input type="hidden" id="gallery-images-ids" name="gallery_images_ids[]" value="${attachment.attributes.id}">

                  <div class="gallery-images-actions">
                  <input type="text" placeholder="Подписать фото" name="gallery-image-descs[${attachment.attributes.id}]">
                    <button type="button" class="gallery-images-clear">
                      X
                    </button>
                  </div>
                </li>`
          );
        });
    });

    mediaUploader.open();
  });

  $(".gallery-images-list").on("click", ".gallery-images-clear", function (e) {
    e.preventDefault();
    $(this).closest("li").remove();
  });
});
