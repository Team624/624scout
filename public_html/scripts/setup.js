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
  });
})();