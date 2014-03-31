//teamInfo.js
(function() {
$(document).ready(function() {
  if($('#searchTeam').val() > 0){
    loadTeamInfo();
  }
  $('#searchTeamBut').click(function() {
    loadTeamInfo();
  });
  $('#searchTeam').keypress(function(evt) {
    if(evt.which === 13) {
      loadTeamInfo();
    }
  });
});
function loadTeamInfo(){
var team = $('#searchTeam').val();
    $.get('/?controller=teamInfo&action=getInfo&team='+team, function(res) {
      $('#teamDisplay').html(res);
    }).fail(function(res) {
      alertify.error(res);
    });
}
})();