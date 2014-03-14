//teamInfo.js
(function() {
$(document).ready(function() {
  if($('#searchTeam').val() > 0){
    loadMatchInfo();
  }
  if($('#searchMatch').val() > 0){
    loadMatchInfo();
  }
  $('#searchMatchBut').click(function() {
    loadMatchInfo();
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