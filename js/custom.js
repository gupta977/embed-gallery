"use strict";

/*!
 * Custom v1.0
 * Contains handlers for the different site functions
 *
 * Copyright (c) 2020 Embed Gallery
 * License: GNU General Public License v2 or later
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

/* global enquire:true */
(function ($) {
  var embedgallery = {
    // Menu
    menuInit: function () {
      // Superfish Menu
      $("ul.sf-menu").superfish({
        delay: 1500,
        animation: { opacity: "show", height: "show" },
        speed: "fast",
        autoArrows: true,
        cssArrows: true,
      });
    },

    // Responsive Videos
    responsiveVideosInit: function () {
      $(".entry-content, .sidebar").fitVids();
    },

    // Responsive Menu
    responsiveMenuInit: function () {
      // Clone the Header Menu and remove classes from clone to prevent css issues
      var $headerMenuClone = $(".header-menu")
        .clone()
        .removeAttr("class")
        .addClass("header-menu-responsive");

      $headerMenuClone
        .removeAttr("style")
        .find("*")
        .each(function (i, e) {
          $(e).removeAttr("style");
        });

      // Responsive Menu Close Button
      var $responsiveMenuClose = $(
        '<a href="#" class="header-menu-responsive-close" id="xclose">&times;</a>'
      );

      // Insert the cloned menu before the site content
      $(
        '<div class="site-header-menu-responsive" id="res_slide" />'
      ).insertBefore(".site-content");
      $headerMenuClone.appendTo(".site-header-menu-responsive");
      $responsiveMenuClose.appendTo(".site-header-menu-responsive");

      // Add dropdown toggle that display child menu items.
      $(
        ".site-header-menu-responsive .page_item_has_children > a, .site-header-menu-responsive .menu-item-has-children > a"
      ).append('<button class="dropdown-toggle" aria-expanded="false"/>');

      $(".site-header-menu-responsive .dropdown-toggle")
        .off("click")
        .on("click", function (e) {
          e.preventDefault();
          $(this).toggleClass("toggle-on");
          $(this)
            .parent()
            .next(".children, .sub-menu")
            .toggleClass("toggle-on");
          $(this).attr(
            "aria-expanded",
            $(this).attr("aria-expanded") === "false" ? "true" : "false"
          );
        });

      $(".site-header-menu-responsive .dropdown-toggle")
        .off("focus")
        .on("focus", function (e) {
          e.preventDefault();
          $(this).toggleClass("toggle-on");
          $(this)
            .parent()
            .next(".children, .sub-menu")
            .toggleClass("toggle-on");
          $(this).attr(
            "aria-expanded",
            $(this).attr("aria-expanded") === "false" ? "true" : "false"
          );
        });
    },

    // Open Slide Panel - Responsive Mobile Menu
    slidePanelInit: function () {
      // Elements
      var menuResponsive = $(".site-header-menu-responsive");
      var overlayEffect = $(".overlay-effect");
      var menuResponsiveClose = $(".header-menu-responsive-close");

      // Responsive Menu Slide
      $(".toggle-menu-control")
        .off("click")
        .on("click", function (e) {
          // Prevent Default
          e.preventDefault();
          e.stopPropagation();

          // ToggleClass
          menuResponsive.toggleClass("show");
          overlayEffect.toggleClass("open");

          // Add Body Class
          if (overlayEffect.hasClass("open")) {
            $("body").addClass("has-responsive-menu");
          }
        });

      // Responsive Menu Close
      menuResponsiveClose.off("click").on("click", function () {
        embedgallery.slidePanelCloseInit();
      });

      // Overlay Slide Close
      overlayEffect.off("click").on("click", function () {
        embedgallery.slidePanelCloseInit();
      });
    },

    // Close Slide Panel
    slidePanelCloseInit: function () {
      // Elements
      var menuResponsive = $(".site-header-menu-responsive");
      var overlayEffect = $(".overlay-effect");

      // Slide Panel Close Logic
      if (overlayEffect.hasClass("open")) {
        // Remove Body Class
        $("body").removeClass("has-responsive-menu");

        // For Menu
        if (menuResponsive.hasClass("show")) {
          menuResponsive.toggleClass("show");
        }

        // Toggle Overlay Slide
        overlayEffect.toggleClass("open");
      }
    },

    // Media Queries
    mqInit: function () {
      enquire.register("screen and ( max-width: 767px )", {
        deferSetup: true,
        setup: function () {
          // Responsive Menu
          embedgallery.responsiveMenuInit();
        },
        match: function () {
          var ele = document.getElementById("res_slide");
          var close = document.getElementById("xclose");
          if (close) {
            //console.log(close);
            close.focus();
          }

          //console.log(document.activeElement);

          $("div").focusout(function () {
            //console.log("lost focust");
            //close.focus();
          });

          embed_trapFocus(ele);

          // Sliding Panels for Menu
          embedgallery.slidePanelInit();
          // Responsive Tables
          $(".entry-content, .sidebar")
            .find("table")
            .wrap('<div class="table-responsive"></div>');
        },
        unmatch: function () {
          // Responsive Menu Close
          embedgallery.slidePanelCloseInit();

          // Responsive Tables Undo
          $(".entry-content, .sidebar")
            .find("table")
            .unwrap('<div class="table-responsive"></div>');
        },
      });
    },
  };

  // Document Ready
  $(document).ready(function () {
    // Menu
    embedgallery.menuInit();

    // Responsive Videos
    embedgallery.responsiveVideosInit();

    // Sliding Panels for Menu and Sidebar
    embedgallery.slidePanelInit();

    // Media Queries
    embedgallery.mqInit();
  });

  // Document Keyup
  $(document).keyup(function (e) {
    // Escape Key
    if (e.keyCode === 27) {
      // Make the escape key to close the slide panel
      embedgallery.slidePanelCloseInit();
    }
  });
})(jQuery);

function embed_trapFocus(element) {
  var focusableEls = element.querySelectorAll(
    'a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])'
  );
  var firstFocusableEl = focusableEls[0];
  var lastFocusableEl = focusableEls[focusableEls.length - 1];
  var KEYCODE_TAB = 9;

  element.addEventListener("keydown", function (e) {
    var isTabPressed = e.key === "Tab" || e.keyCode === KEYCODE_TAB;
    if (!isTabPressed) {
      return;
    }
    if (e.shiftKey) {
      /* shift + tab */ if (document.activeElement === firstFocusableEl) {
        lastFocusableEl.focus();
        e.preventDefault();
      }
    } /* tab */ else {
      if (document.activeElement === lastFocusableEl) {
        firstFocusableEl.focus();
        e.preventDefault();
      }
    }
  });
}
