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
      swipeifyStuff();
    }).fail(function(res) {
      alertify.error(res);
    });
}
function swipeifyStuff(){
  /*var hammer_options = {swipe_velocity: 0.4};
  $('.info-bar')
    .hammer(hammer_options)
    .on("swipe",function(event){
      if($('#auto-gippies').css('display') != "none"){
        console.log(event);
        if(event.gesture.deltaX < -10){
          changeInfoBar(event.currentTarget,2);
        }
        else if(event.gesture.deltaX > 10){
          changeInfoBar(event.currentTarget,1);
        }
      }
    });*/
  var hammer_options = {};
  $('.info-bar')
    .hammer(hammer_options)
    .on("dragend",function(event){
      if($('#auto-gippies').css('display') != "none"){
        console.log(event);
        endDragBar(event.currentTarget,event);
      }
    });
  var hammer_options = {};
  $('.info-bar')
    .hammer(hammer_options)
    .on("drag",function(event){
      if($('#auto-gippies').css('display') != "none"){
        console.log(event);
        dragBar(event.currentTarget,event);
      }
    });
}
var barDelta = 0;
function endDragBar(bar,e){
  if(Math.abs(barDelta) > $(bar).width()/5){
    if(!$(bar).hasClass("onSec2")){
      changeInfoBar(bar,2);
    }
    else{
      changeInfoBar(bar,1);
    }
  }
  else{
    if(!$(bar).hasClass("onSec2")){
      $(bar).animate({
          left: "0"
        }, 200, function() {
            // Animation complete.
            $(bar).removeClass('section-transitioning');
        });
    }
    else{
      $(bar).animate({
          left: "-100%"
        }, 200, function() {
            // Animation complete.
            $(bar).removeClass('section-transitioning');
        });
    }
  }
  barDelta = 0;
}
function dragBar(bar,e){
  if($(e.target).attr('class') != 'table-holder' && !$(e.target).is("td") && !$(e.target).is("th")){ //check to make sure not draging table-holder
    var dX = e.gesture.deltaX;
    barDelta = dX;
    if(!$(bar).hasClass("onSec2")){
      if(dX < 0){
        $(bar).css('left',dX + 'px');
      }
    }
    else{
      if(dX > 0){
        $(bar).css('left',$(bar).width()/-2 + dX + 'px');
      }
    }
  }
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