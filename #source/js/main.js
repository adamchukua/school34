$(document).ready(function(){
  $(".header-toggle").click(function() {
    $(".header-mobile").slideToggle(400, function() {});
    $("body").toggleClass('overflow');
    $(".header-toggle").toggleClass('header-toggle_active');
  });
});