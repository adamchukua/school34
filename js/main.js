$(document).ready(function(){
  $(".header-toggle").click(function() {
    $(".header-list_mobile").slideToggle("slow", function() {});
    $(".header-toggle").toggleClass('header-toggle_active');
  });
});

