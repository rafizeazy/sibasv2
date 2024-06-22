$(document).ready(function () {
    $("#menu").click(function () {
      $(this).toggleClass("fa-times");
      $(".navbar").toggleClass("nav-toggle");
    });
  
    $(window).on("scroll load", function () {
      $("#menu").removeClass("fa-times");
      $(".navbar").removeClass("nav-toggle");
    });
  
    $(".amount input").click(function () {
      $(this).addClass("active").siblings().removeClass("active");
    });
  
    // smooth scrolling
  
    $('a[href*="#"]').on("click", function (e) {
      e.preventDefault();
  
      $("html, body").animate(
        {
          scrollTop: $($(this).attr("href")).offset().top,
        },
        500,
        "linear"
      );
    });
  });
  