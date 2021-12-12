jQuery.noConflict();
(function ($) {
  $(function () {
    $(".dg2-pib").hide();
    $("input[name$='pib_racun']").click(function() {
      var value = $(this).val();
      if (value == 2) {
        $(".dg2-pib").show();
      }
      else {
        $(".dg2-pib").hide();
      }
    });
    
  
  });
})(jQuery);
