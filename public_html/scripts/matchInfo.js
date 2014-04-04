//teamInfo.js
(function() {
$(document).ready(function() {
  if($('#searchMatch').val() > 0){
    loadMatchInfo();
  }
  $('#searchMatchBut').click(function() {
    loadMatchInfo();
  });
  $('#searchMatch').keydown(function(e) {
    if(e.which === 13) {
      loadMatchInfo();
    }
  });
});
function loadMatchInfo(){
var match = $('#searchMatch').val();
    $.get('/?controller=matchInfo&action=getInfo&match='+match, function(res) {
      $('#matchDisplay').html(res);
    }).fail(function(res) {
      alertify.error(res.responseText);
    });
}
})();