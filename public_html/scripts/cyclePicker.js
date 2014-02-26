//cyclePicker.js
$(document).ready(function() {
  var cycleNum = 1;
  if($('#cycleTemplate').length === 0) return;
  var html = $('#cycleTemplate').render([cycleNum]);
  $('.cycle-remove.button').addClass('disabled');
  $('#cycleTemplate').after(html);
  $('.cycle-holder input').iCheck({
    checkboxClass: 'icheckbox_polaris',
    radioClass: 'iradio_polaris',
    increaseArea: '-10%', // optional
    focusClass: 'focus'
  });
  
  /*$(window).on('keydown', function(e) {
    e.keyCode = 9;
    e.which = 9;
    $(window).keydown(e);
  });*/
  
  $('.cycle-add.button').click(function() {
    cycleNum++;
    var html = $('#cycleTemplate').render([cycleNum]);
    
    var elem = $(html).insertAfter($('.cycle-holder').last());
    var scrollTarget = $('html, body').scrollTop() + elem.height();
    $('html, body').animate({scrollTop: scrollTarget}, 300);
    elem.find('input').iCheck({
    checkboxClass: 'icheckbox_polaris',
    radioClass: 'iradio_polaris',
    increaseArea: '-10%', // optional
    focusClass: 'focus'
  });
    elem.find('input').first().focus();
    elem.hide().slideDown();
    if(cycleNum > 1) $('.cycle-remove.button').removeClass('disabled');
  });
  
  $('.cycle-add.button').keyup(function(e) {
    if(e.which === 32) $(this).click();
  });
  
  $('.cycle-remove.button').click(function() {
    if($(this).hasClass('disabled')) return;
    cycleNum--;
    $('.cycle-holder:not(.deleting)').last().addClass('deleting').slideUp(function() {
      $(this).remove();
    });
    if(cycleNum <= 1) {
      $(this).addClass('disabled');
    }
  });
  
  $('.cycle-remove.button').keyup(function(e) {
    if(e.which === 32) $(this).click();
  });
});