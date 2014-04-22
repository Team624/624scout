//submit.js
(function() { 

$(document).ready(function() {
  $('#password').focus();
  $('#submitPW').click(function() {
    console.log($('#password').val());
    $.post('/?controller=loginer&action=login', $('#password').val(), function(dat) {
      window.setTimeout(function() {
        location.reload(true); 
      }, 500);
    }).fail(function(dat) {
      alertify.error(dat.responseText);
      console.log(dat.responseText);
      $('#password').val('');
      
    });
  });
  $('#password').keydown(function(evt) {
    console.log(evt);
    if(evt.which === 13) {
      $('#submitPW').click();
      
    }
  });
});

})();

