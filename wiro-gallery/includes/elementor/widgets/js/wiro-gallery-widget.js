class WiroGalleryWidgetHandler extends elementorModules.frontend.handlers.Base {
  onInit() {
    const $gallery = $(".gallery-images-row");
    const $filters = $(".gallery-filters .filter");

    const exclusive = {
      page: 1,
      selector: "",
    };

    pagination("");

    $gallery.isotope({
      itemSelector: ".gallery-images-el",
    });

    $filters.on("click", function () {
      $(".gallery-filters .filter").removeClass("active");
      $(this).addClass("active");
      const selector = $(this).data("filter");
      exclusive["selector"] = selector;
      exclusive["page"] = 1;

      pagination(selector);
      changeFilters();
    });

    function changeFilters() {
      const selector = `${exclusive.selector}.page-${exclusive.page}`;
      $gallery.isotope({ filter: selector });
    }

    function pagination(elem) {
      $gallery.children().removeClass(function (index, classNames) {
        const classes = classNames.split(" ");
        const filteredClasses = classes.filter(function (className) {
          return className.startsWith("page-");
        });

        return filteredClasses.join(" ");
      });

      if (elem === "") {
        $gallery.children().each(function (idx) {
          const page = Math.ceil((idx + 1) / 20);
          $(this).addClass("page-" + page);
        });
      } else {
        $(elem).each(function (idx) {
          const page = Math.ceil((idx + 1) / 20);
          $(this).addClass("page-" + page);
        });
      }

      recalcPages(elem);
      changeFilters();
    }

    function recalcPages(elem) {
      const elemLength =
        elem === "" ? $gallery.children().length : $(elem).length;

      const pages = Math.ceil(elemLength / 20);

      pagesCount(pages);
    }

    function pagesCount(pages) {
      let pagesHtml = "";

      for (let i = 1; i <= 4; i++) {
        if (i === 1) {
          pagesHtml += `
          <span class="page-number page-first active" data-page="${i}">
            <span>${i}</span>
          </span>
        `;
        } else {
          pagesHtml += `
          <span class="page-number" data-page="${i}">
            <span>${i}</span>
          </span>
        `;
        }
      }

      if (pages > 4) {
        pagesHtml += `
          <span class="page-number page-last" data-page="${pages}">
            <span>${pages}</span>
          </span>
        `;
      }

      $(".pager-list").html(pagesHtml);

      handlePagers();
    }

    function handlePagers() {
      $(".pager-list").on("click", ".page-number", function () {
        if (!$(this).hasClass("active")) {
          $(".page-number").removeClass("active");
          $(this).addClass("active");
          exclusive["page"] = $(this).data("page");
          changeFilters();

          restructingPagination();
        }
      });
    }

    function restructingPagination() {
      const currentPage = $(".page-number.active").data("page");
      const lastPage = $(".page-number.page-last").data("page");

      if (lastPage < 6) return;

      if (
        (currentPage > 3 ||
          (currentPage === 3 && !$(".page-number[data-page=2]").length)) &&
        currentPage < lastPage - 1
      ) {
        $(".page-number:not(.page-last, .page-first, .active)").remove();

        $(".page-number.active").before(`<span class="page-number" data-page="${
          currentPage - 1
        }">
          <span>${currentPage - 1}</span>
        </span>`);

        $(".page-number.active").after(`<span class="page-number" data-page="${
          currentPage + 1
        }">
          <span>${currentPage + 1}</span>
        </span>`);
      }
    }

    lightbox.option({
      resizeDuration: 200,
      wrapAround: true,
      disableScrolling: true,
      alwaysShowNavOnTouchDevices: true,
    });
  }
}

(function ($) {
  $(window).on("elementor/frontend/init", () => {
    const addServicesHandler = ($element) => {
      elementorFrontend.elementsHandler.addHandler(WiroGalleryWidgetHandler, {
        $element,
      });
    };

    elementorFrontend.hooks.addAction(
      "frontend/element_ready/wiro_gallery_widget.default",
      addServicesHandler
    );
  });
})(jQuery);
