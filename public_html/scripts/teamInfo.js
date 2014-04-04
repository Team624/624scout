//teamInfo.js
(function() {
$(document).ready(function() {
  if($('#searchTeam').val() > 0){
    loadTeamInfo();
  }
  $('#searchTeamBut').click(function() {
    loadTeamInfo();
  });
});
function loadTeamInfo(){
var team = $('#searchTeam').val();
    $.get('/?controller=teamInfo&action=getInfo&team='+team, function(res) {
      $('#teamDisplay').html(res);
      swipeifyStuff();
    }).fail(function(res) {
      alertify.error(res);
    });
}
function swipeifyStuff(){
  var hammer_options = {};
  /*$('.info-bar').addClass('section-1');*/
  $('.info-bar')
    .hammer(hammer_options)
    .on("swipe",function(event){
      if($('#auto-gippies').css('display') != "none"){
        console.log(event);
        if(event.gesture.deltaX < -30){
          changeInfoBar(event.currentTarget,2);
        }
        else if(event.gesture.deltaX > 30){
          changeInfoBar(event.currentTarget,1);
        }
      }
    });
}
function changeInfoBar(bar, section){
  if(($(bar).hasClass("onSec2") && section == 1) || (!$(bar).hasClass("onSec2") && section == 2)){ //if not already there
    console.log("dif thing");
    $(bar).addClass('section-transitioning');
    if(section == 2){
      $(bar).addClass('onSec2');
      $(bar).animate({
        left: "-100%"
      }, 200, function() {
          // Animation complete.
          $(bar).removeClass('section-transitioning');
      });
    }
    else{
      console.log("to left");
      $(bar).removeClass('onSec2');
      $(bar).animate({
        left: "0%"
      }, 200, function() {
          // Animation complete.
          $(bar).removeClass('section-transitioning');
      });
    }
  }
}

})();