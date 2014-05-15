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
      var stateObj = { pageTeam: team };
      history.pushState(stateObj, "loadTeam", "?controller=teamInfo&action=display&team="+team);
      swipeifyStuff();
    }).fail(function(res) {
      alertify.error(res);
    });
}
function swipeifyStuff(){
 /* var hammer_options = {swipe_velocity: 0.4};

    new Hammer($('.info-bar:not(.no-stuff)'), { drag_lock_to_axis: true }).on("dragleft dragright swipeleft swiperight", function(ev){
  //  alert(ev.type);
  //  alert(ev.gesture.deltaX);
      if($('#auto-gippies').css('display') != "none"){
        console.log(ev);
        if(ev.gesture.deltaX < 0){
          changeInfoBar(ev.currentTarget,2);
        }
        else if(ev.gesture.deltaX > 0){
          changeInfoBar(ev.currentTarget,1);
        }
      }
    });*/
    $('.info-bar').click(function() {
      if($('#auto-gippies').css('display') == 'none') return;
      if($(this).hasClass('onSec2')) {
        changeInfoBar(this, 1);
      } else {
        changeInfoBar(this, 2);
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
        left: "0"
      }, 200, function() {
          // Animation complete.
          $(bar).removeClass('section-transitioning');
      });
    }
  }
}

})();