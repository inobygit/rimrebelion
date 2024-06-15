import { InobyModule } from "@lib/inoby-module";
import * as $ from "jquery";

class LooksArchiveModule extends InobyModule {
    run() {

    const currentUrlParams = new URLSearchParams(window.location.search);
    if (currentUrlParams.has("gender")) {
        const genderValue = currentUrlParams.get("gender");
        $(`.filter-wrp-looks input[type=checkbox][value="${genderValue}"]`).siblings('label').addClass("active");
        $(`.filter-wrp-looks input[type=checkbox][value="${genderValue}"]`).attr('checked','true');
    }


    $(".products-filter-init").on("click", () => {
        // toggle active class
        const $sb = $("#shop-sidebar");
        $sb.toggleClass("active");

      if ($sb.hasClass("active")) {
        $("input[name=disable_auto_apply_filter]").val("true");
        $sb.attr("data-top", $sb.css("top"));
        $sb.css("top", "");
      } else {
        $("input[name=disable_auto_apply_filter]").val("false");
        $sb.css("top", $sb.attr("data-top") ? $sb.attr("data-top") : "");
      }

      // toggle body class
      $("body").toggleClass("filter-opened");
    });



    $(".filter-trigger").on("click", function(e) {
        e.preventDefault();
        var checkedBox = $('.filter-wrp-looks input[type=checkbox]:checked');
        const disableAutoApplyFilter = $("input[name=disable_auto_apply_filter]").val() === "true";
        if (disableAutoApplyFilter) {
            const currentUrlParams = new URLSearchParams(window.location.search);
            currentUrlParams.delete("gender");
            if (currentUrlParams.toString() === "") {
                window.location.href = window.location.pathname + `/?gender=${checkedBox.val()}`;
            } else {
                window.location.href = window.location.pathname + '/?' + currentUrlParams + `&gender=${checkedBox.val()}`;
            }
        }
    });

    $(".filter-wrp-looks input[type=checkbox]:checked").on('click', function(e) {
        e.preventDefault();
    });
    $(".filter-wrp-looks input[type=checkbox]").on("change", function(e) {
        e.preventDefault();
        $(".filter-wrp-looks input[type=checkbox]").each(function() {
            $(this).prop("checked", false);
        });
        $(this).prop("checked", true);
        const disableAutoApplyFilter = $("input[name=disable_auto_apply_filter]").val() === "false";
        if (disableAutoApplyFilter) {
            const currentUrlParams = new URLSearchParams(window.location.search);
            currentUrlParams.delete("gender");
            if (currentUrlParams.toString() === "") {
                window.location.href = window.location.pathname + `/?gender=${$(this).val()}`;
            } else {
                window.location.href = window.location.pathname + '/?' + currentUrlParams + `&gender=${$(this).val()}`;
            }
        }
    });
  }
}

new LooksArchiveModule().runOnReady();
