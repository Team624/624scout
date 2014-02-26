//teamInfo.js
(function() {
$(document).ready(function() {
  $('#searchTeamBut').click(function() {
    var team = $('#searchTeam').val();
    $.get('/?controller=teamInfo&action=getInfo&team='+team, function(res) {
      $('#teamDisplay').html(res);
    }).fail(function(res) {
      alertify.error(res);
    });
  });
});
})();