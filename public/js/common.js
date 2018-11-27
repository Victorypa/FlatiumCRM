$(document).ready(function() {
  $("#checkAll").click(function() {
    $(".check").prop("checked", $(this).prop("checked"));
  });

  $('#myTab a[href="#profile"]').tab("show"); // Select tab by name
  $("#myTab li:first-child a").tab("show"); // Select first tab
  $("#myTab li:last-child a").tab("show"); // Select last tab
  $("#myTab li:nth-child(3) a").tab("show"); // Select third tab

  $(".Modal").on("shown.bs.modal", function() {
    $("#myInput").trigger("focus");
  });

  $("a.thumb").click(function(event) {
    event.preventDefault();
    var content = $(".modal-body");
    content.empty();
    var title = $(this).attr("title");
    $(".modal-title").html(title);
    content.html($(this).html());
    $(".modal-profile").modal({ show: true });
  });

  $('[data-toggle="tooltip"]').tooltip();

  $(".slider").click(function() {
    $(".switch__desc").toggleClass("active");
  });

  $(".owl-carousel").owlCarousel({
    items:5,
    nav : true,
    responsive:{
      0:{
          items:2
      },
      600:{
          items:3
      },
      1300:{
          items:3
      }
  }
  });
  $('.arrow-icon').click(function(){
    $(this).toggleClass('rotate');
  });
});
