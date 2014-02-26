//startradio.js
(function() {
$(document).ready(function() {
  $("input[name='start']").on('ifChecked', function(e) {
   var sel = $(this).attr('id');
   if(sel === 'no-show') {
    $('.goalie-auton.form-row').slideUp();
    $('.normal-auton.form-row').slideUp();
   } else if (sel === 'goalie') {
    $('.goalie-auton.form-row').slideDown();
    $('.normal-auton.form-row').slideUp();
   } else if (sel === 'normal-auton') {
    $('.goalie-auton.form-row').slideUp();
    $('.normal-auton.form-row').slideDown();
   }
  });
});
})();