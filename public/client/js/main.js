(function ($) {
    "use strict";

    /*[ Load page ]
    ===========================================================*/
    $(".animsition").animsition({
        inClass: "fade-in",
        outClass: "fade-out",
        inDuration: 1500,
        outDuration: 800,
        linkElement: ".animsition-link",
        loading: true,
        loadingParentElement: "html",
        loadingClass: "animsition-loading-1",
        loadingInner: '<div class="loader05"></div>',
        timeout: false,
        timeoutCountdown: 5000,
        onLoadEvent: true,
        browser: ["animation-duration", "-webkit-animation-duration"],
        overlay: false,
        overlayClass: "animsition-overlay-slide",
        overlayParentElement: "html",
        transition: function (url) {
            window.location.href = url;
        },
    });

    /*[ Back to top ]
    ===========================================================*/
    var windowH = $(window).height() / 2;

    $(window).on("scroll", function () {
        if ($(this).scrollTop() > windowH) {
            $("#myBtn").css("display", "flex");
        } else {
            $("#myBtn").css("display", "none");
        }
    });

    $("#myBtn").on("click", function () {
        $("html, body").animate({ scrollTop: 0 }, 300);
    });

    /*==================================================================
    [ Fixed Header ]*/
    var headerDesktop = $(".container-menu-desktop");
    var wrapMenu = $(".wrap-menu-desktop");

    if ($(".top-bar").length > 0) {
        var posWrapHeader = $(".top-bar").height();
    } else {
        var posWrapHeader = 0;
    }

    if ($(window).scrollTop() > posWrapHeader) {
        $(headerDesktop).addClass("fix-menu-desktop");
        $(wrapMenu).css("top", 0);
    } else {
        $(headerDesktop).removeClass("fix-menu-desktop");
        $(wrapMenu).css("top", posWrapHeader - $(this).scrollTop());
    }

    $(window).on("scroll", function () {
        if ($(this).scrollTop() > posWrapHeader) {
            $(headerDesktop).addClass("fix-menu-desktop");
            $(wrapMenu).css("top", 0);
        } else {
            $(headerDesktop).removeClass("fix-menu-desktop");
            $(wrapMenu).css("top", posWrapHeader - $(this).scrollTop());
        }
    });

    /*==================================================================
    [ Menu mobile ]*/
    $(".btn-show-menu-mobile").on("click", function () {
        $(this).toggleClass("is-active");
        $(".menu-mobile").slideToggle();
    });

    var arrowMainMenu = $(".arrow-main-menu-m");

    for (var i = 0; i < arrowMainMenu.length; i++) {
        $(arrowMainMenu[i]).on("click", function () {
            $(this).parent().find(".sub-menu-m").slideToggle();
            $(this).toggleClass("turn-arrow-main-menu-m");
        });
    }

    $(window).resize(function () {
        if ($(window).width() >= 992) {
            if ($(".menu-mobile").css("display") == "block") {
                $(".menu-mobile").css("display", "none");
                $(".btn-show-menu-mobile").toggleClass("is-active");
            }

            $(".sub-menu-m").each(function () {
                if ($(this).css("display") == "block") {
                    console.log("hello");
                    $(this).css("display", "none");
                    $(arrowMainMenu).removeClass("turn-arrow-main-menu-m");
                }
            });
        }
    });

    /*==================================================================
    [ Show / hide modal search ]*/
    $(".js-show-modal-search").on("click", function () {
        $(".modal-search-header").addClass("show-modal-search");
        $(this).css("opacity", "0");
    });

    $(".js-hide-modal-search").on("click", function () {
        $(".modal-search-header").removeClass("show-modal-search");
        $(".js-show-modal-search").css("opacity", "1");
    });

    $(".container-search-header").on("click", function (e) {
        e.stopPropagation();
    });

    /*==================================================================
    [ Isotope ]*/
    var $topeContainer = $(".isotope-grid");
    var $filter = $(".filter-tope-group");

    // filter items on button click
    $filter.each(function () {
        $filter.on("click", "button", function () {
            var filterValue = $(this).attr("data-filter");
            $topeContainer.isotope({ filter: filterValue });
        });
    });

    // init Isotope
    $(window).on("load", function () {
        var $grid = $topeContainer.each(function () {
            $(this).isotope({
                itemSelector: ".isotope-item",
                layoutMode: "fitRows",
                percentPosition: true,
                animationEngine: "best-available",
                masonry: {
                    columnWidth: ".isotope-item",
                },
            });
        });
    });

    var isotopeButton = $(".filter-tope-group button");

    $(isotopeButton).each(function () {
        $(this).on("click", function () {
            for (var i = 0; i < isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass("how-active1");
            }

            $(this).addClass("how-active1");
        });
    });

    /*==================================================================
    [ Filter / Search product ]*/
    $('.js-show-filter').on('click',function(){
        $(this).toggleClass('show-filter');
        $('.panel-filter').slideToggle(400);

        // 👉 Khởi tạo Isotope
        var $grid = $(".isotope-grid").isotope({
            itemSelector: ".isotope-item",
            layoutMode: "fitRows",
            getSortData: {
                name: ".product-name",
                price: function (itemElem) {
                    return parseFloat(
                        $(itemElem).find(".product-price").text().replace(/[^\d.]/g, "")
                    );
                },
            },
        });

        // 👉 Hiển thị bộ lọc
        if (filterBtn && panelFilter) {
            filterBtn.addEventListener("click", function () {
                this.classList.toggle("show-filter");
                panelFilter.style.display =
                    panelFilter.style.display === "block" ? "none" : "block";
            });
        }

        // 👉 Lọc sản phẩm theo danh mục
        filterBtns.forEach((button) => {
            button.addEventListener("click", function () {
                let filterValue = this.getAttribute("data-filter");
                console.log("Lọc theo:", filterValue);

                $grid.isotope({ filter: filterValue });
                checkIfEmpty();

                filterBtns.forEach((btn) => btn.classList.remove("how-active1"));
                this.classList.add("how-active1");
            });
        });

        // 👉 Sắp xếp sản phẩm theo tên hoặc giá
        sortButtons.forEach((button) => {
            button.addEventListener("click", function () {
                let sortType = this.getAttribute("data-sort");
                console.log("Sắp xếp theo:", sortType);

                let sortBy = sortType.includes("name") ? "name" : "price";
                let sortAscending = sortType.includes("asc");

                $grid.isotope({
                    sortBy: sortBy,
                    sortAscending: sortAscending,
                });

                sortButtons.forEach((btn) => btn.classList.remove("how-active1"));
                this.classList.add("how-active1");
            });
        });

        // 👉 Lọc theo màu và size
        const colorCheckboxes = document.querySelectorAll('input[name="colors[]"]');
const sizeCheckboxes = document.querySelectorAll('input[name="sizes[]"]');

[colorCheckboxes, sizeCheckboxes].forEach((group) => {
    group.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            filterByColorAndSize();
        });
    });
});

function filterByColorAndSize() {
    let selectedColors = [...colorCheckboxes]
        .filter((cb) => cb.checked)
        .map((cb) => `.color-${cb.value}`);

    let selectedSizes = [...sizeCheckboxes]
        .filter((cb) => cb.checked)
        .map((cb) => `.size-${cb.value}`);

    let filterSelector = "";

    if (selectedColors.length && selectedSizes.length) {
        filterSelector = selectedColors
            .map((c) => selectedSizes.map((s) => `${c}${s}`))
            .flat()
            .join(", ");
    } else if (selectedColors.length) {
        filterSelector = selectedColors.join(", ");
    } else if (selectedSizes.length) {
        filterSelector = selectedSizes.join(", ");
    } else {
        filterSelector = "*";
    }
    console.log("Lọc selector:", filterSelector);
    $grid.isotope({ filter: filterSelector });
    checkIfEmpty();
}

    $('.js-show-search').on('click',function(){
        $(this).toggleClass('show-search');
        $('.panel-search').slideToggle(400);

        if($('.js-show-filter').hasClass('show-filter')) {
            $('.js-show-filter').removeClass('show-filter');
            $('.panel-filter').slideUp(400);
        }
    });

        // 👉 Hàm kiểm tra nếu không có sản phẩm nào khớp
        function checkIfEmpty() {
            $grid.isotope('once', 'arrangeComplete', function (filteredItems) {
                const noProducts = document.getElementById('no-products');
                if (filteredItems.length === 0) {
                    noProducts.style.display = 'block';
                } else {
                    noProducts.style.display = 'none';
                }
            });
        }
    });


    /*==================================================================
    [ Cart ]*/
    $(".js-show-cart").on("click", function () {
        $(".js-panel-cart").addClass("show-header-cart");
    });

    $(".js-hide-cart").on("click", function () {
        $(".js-panel-cart").removeClass("show-header-cart");
    });

    /*==================================================================
    [ Cart ]*/
    $(".js-show-sidebar").on("click", function () {
        $(".js-sidebar").addClass("show-sidebar");
    });

    $(".js-hide-sidebar").on("click", function () {
        $(".js-sidebar").removeClass("show-sidebar");
    });

    /*==================================================================
    [ +/- num product ]*/
    $(".btn-num-product-down").on("click", function () {
        var numProduct = Number($(this).next().val());
        if (numProduct > 0)
            $(this)
                .next()
                .val(numProduct - 1);
    });

    $(".btn-num-product-up").on("click", function () {
        var numProduct = Number($(this).prev().val());
        $(this)
            .prev()
            .val(numProduct + 1);
    });

    /*==================================================================
    [ Rating ]*/
    $(".wrap-rating").each(function () {
        var item = $(this).find(".item-rating");
        var rated = -1;
        var input = $(this).find("input");
        $(input).val(0);

        $(item).on("mouseenter", function () {
            var index = item.index(this);
            var i = 0;
            for (i = 0; i <= index; i++) {
                $(item[i]).removeClass("zmdi-star-outline");
                $(item[i]).addClass("zmdi-star");
            }

            for (var j = i; j < item.length; j++) {
                $(item[j]).addClass("zmdi-star-outline");
                $(item[j]).removeClass("zmdi-star");
            }
        });

        $(item).on("click", function () {
            var index = item.index(this);
            rated = index;
            $(input).val(index + 1);
        });

        $(this).on("mouseleave", function () {
            var i = 0;
            for (i = 0; i <= rated; i++) {
                $(item[i]).removeClass("zmdi-star-outline");
                $(item[i]).addClass("zmdi-star");
            }

            for (var j = i; j < item.length; j++) {
                $(item[j]).addClass("zmdi-star-outline");
                $(item[j]).removeClass("zmdi-star");
            }
        });
    });

    /*==================================================================
    [ Show modal1 ]*/
    $(".js-show-modal1").on("click", function (e) {
        e.preventDefault();
        $(".js-modal1").addClass("show-modal1");
    });

    $(".js-hide-modal1").on("click", function () {
        $(".js-modal1").removeClass("show-modal1");
    });
})(jQuery);
