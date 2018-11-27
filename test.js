$(document).ready(function() {
  $("#checkAll").click(function() {
    $(".check").prop("checked", $(this).prop("checked"));
  });


  $(".slider").click(function() {
    $(".switch__desc").toggleClass("active");
  });

  $(".owl-carousel").owlCarousel({
    items: 5,
    nav: true,
    responsive: {
      0: {
        items: 2
      },
      600: {
        items: 3
      },
      1300: {
        items: 3
      }
    }
  });

  $(".arrow-sort").click(function() {
    $(".arrow-icon").toggleClass("rotate");
  });

  // $('input[name="dates"]').daterangepicker({
  //   startDate: moment(),
  //   endDate: moment().add(2, "day")
  // });

  // $(".btn-sm").addClass("primary-button");
  // $(".cancelBtn").addClass("primary-button--outline").text('ОТМЕНА');
  // $(".applyBtn").text('ОК');

});
