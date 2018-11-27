$(document).ready(function() {

  $("#checkAll").click(function() {
    $(".check").prop("checked", $(this).prop("checked"));
  });

  $(".arrow-sort").click(function() {
    $(".arrow-icon").toggleClass("rotate");
  });
});

$(window).scroll(function() {
        var scroll_top = $(this).scrollTop();
        scroll_top > 316 ? $('#toTop').addClass('active') : $('#toTop').removeClass('active');
    });
