$(document).ready(function() {
  if (document.location.href.indexOf("u_print=Y") > -1) {
    var $content = $("#wrap");
    var newStyle = "background:#ffffff !important;";
    $content
      .attr("style", newStyle)
      .parents().attr("style", newStyle);
    $content.siblings().css("display", "none");
    $("#panel").css("display", "none");
  }
});

