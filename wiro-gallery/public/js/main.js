jQuery(document).ready(function ($) {
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
        const page = Math.ceil((idx + 1) / 24);
        $(this).addClass("page-" + page);
      });
    } else {
      $(elem).each(function (idx) {
        const page = Math.ceil((idx + 1) / 24);
        $(this).addClass("page-" + page);
      });
    }

    recalcPages(elem);
    changeFilters();
  }

  function recalcPages(elem) {
    const elemLength =
      elem === "" ? $gallery.children().length : $(elem).length;

    const pages = Math.ceil(elemLength / 24);

    pagesCount(pages);
  }

  function pagesCount(pages) {
    let pagesHtml = "";

    const maxLimit = Math.min(4, pages);

    // выводим сначала до 4 (включительно) элементов
    for (let i = 1; i <= maxLimit; i++) {
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

    // если элементов меньше 4, то ничего не делаем, потому что перестраивать структуру пагинации в таком случае тоже незачем
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

    if (!lastPage || lastPage < 6) return;

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
});

jQuery(window).on("load", function () {
  lightbox.option({
    resizeDuration: 200,
    wrapAround: true,
    disableScrolling: true,
    alwaysShowNavOnTouchDevices: true,
  });
});
