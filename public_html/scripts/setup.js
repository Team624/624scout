//setup.js -----
(function() {
  $(document).ready(function() {
    $('#load-schedule').click(function() {
      $.post('/?controller=setup&action=loadSchedule', {eventCode:$('#event-code').val()}, function(data) {
        alertify.success('Match data loaded!');
      }).fail(function (dat) {
      window.console.log(dat);
        alertify.error(dat.responseText);
      });
    });
    $('#load-teams').click(function() {
      $.post('/?controller=setup&action=loadTeams', {eventCode:$('#event-code').val()}, function(data) {
        alertify.success('Team List loaded!');
        window.console.log(data);
      }).fail(function (dat) {
      window.console.log(dat);
        alertify.error(dat.responseText);
      });
    });
    $('#obliterate-dialog-show').click(function() {
      $('#obliterate-dialog').slideDown(1000);
    });
    $('#obliterate').click(function() {
      $.post('/?controller=setup&action=obliterate', {password:$('#oblit-pass').val()}, function(data) {
        alertify.success('Obliteration complete!');
        window.console.log(data);
      }).fail(function (dat) {
      window.console.log(dat);
        alertify.error(dat.responseText);
      });
    });
  });
})();