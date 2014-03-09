//submit.js
(function() { 
  function valNum(item) {
    var regex = /^[0-9]+$/;
    return regex.test(item.val());
  }
  function valMatch(item) {
    var data = item.val();
    if(!valNum(item)) return false;
    return (typeof(window.schedule[data]) !== 'undefined');
  }
  function valTeam(data) {
    var team = data.val();
    curMatch = window.schedule[$('#match').val()];
    if(typeof(curMatch) === 'undefined') return false;
    if(curMatch.red_1 == team) return true;
    if(curMatch.red_2 == team) return true;
    if(curMatch.red_3 == team) return true;
    if(curMatch.blue_1 == team) return true;
    if(curMatch.blue_2 == team) return true;
    if(curMatch.blue_3 == team) return true;
    return false;
  }
  function valScout(item) {
    var data = item.val();
    if(!valNum(item)) return false;
    return typeof(window.scouts[data]) !== 'undefined';
  }
  function valTime(item) {
    var data = item.val();
    return valNum(data) && parseFloat(data) > 0 && parseFloat(data) < 150;
  }
  function valSubj(item) {
    var regex = /^[0-9]$/;
    return regex.test(item.val());
  }
  function valLocation(item) {
    var regex = /^[1-3]$/;
    return regex.test(item.val());
  }
  var zeroList = [
    '#auton-shots-blocked',
    '#auton-shots-not-blocked',
    '#auton-high-hot',
    '#auton-high-cold',
    '#auton-high-miss',
    '#auton-low-hot',
    '#auton-low-cold',
    '#auton-low-miss',
    '#auton-mobility',
    '#high-score',
    '#high-miss',
    '#low-score',
    '#low-miss',
    '#truss',
    '#truss-miss',
    '#catch',
    '#catch-miss',
    '#human-pass',
    '#human-pass-miss',
    '#robot-pass',
    '#robot-pass-miss',
    '#other-possessions',
    '#dropped-ball',
    '#human-load',
    '#human-load-miss',
    '#floor-load',
    '#floor-load-miss',
    '#balls-blocked',
    '#fouls',
    '#tech-fouls',
    '#driving',
    '#pushing',
    '#defense'
  ];
  function autoZero() {
    for(var i=0; i<zeroList.length; i++) {
      $(zeroList[i]).each(function(item) {
        if ($(this).val() === '') $(this).val(0);
      });
    }
  }
  
  function validateOneMap(map) {
    var valid = true;
    for(var key in map) {
      if (map.hasOwnProperty(key)) {
        $(key).each(function(q) {
          console.log(key);
          console.log(map[key]);
          var itemValid = map[key]($(this));
          if (!itemValid) {
            valid = false;
            $(this).addClass('invalid');
          }
        });
      }
    }
    return valid;
  }
  //add auton too
  var valMap = {
    '#match':valMatch,
    '#team':valTeam,
    '#scout':valScout
  };
  var teleopMap = {
    '#balls-blocked': valNum,
    '#fouls': valNum,
    '#tech-fouls': valNum,
    '#high-score': valNum,
    '#high-miss': valNum,
    '#low-score': valNum,
    '#low-miss': valNum,
    '#truss': valNum,
    '#truss-miss': valNum,
    '#catch': valNum,
    '#catch-miss': valNum,
    '#human-pass': valNum,
    '#human-pass-miss': valNum,
    '#robot-pass': valNum,
    '#robot-pass-miss,other-possessions,dropped-ball,human-load,human-load-miss,floor-load,floor-load-miss': valNum,
    '#driving,#pushing,#defense' : valSubj
  };
  var normalAutonMap = {
    '#auton-normal-start' : valLocation,
    '#auton-high-hot,#auton-high-cold,#auton-high-miss,#auton-low-hot,#auton-low-cold,#auton-low-miss' : valNum,
    '#high-score,#high-miss,#low-score,#low-miss,#truss,#truss-miss,#catch,#catch-miss,#human-pass,#human-pass-miss,#robot-pass,#robot-pass-miss' : valNum,
    '#other-possessions,#dropped-ball,#human-load,#human-load-miss,#floor-load,#floor-load-miss' : valNum
  };
  var goalieAutonMap = {
    '#auton-shots-blocked,#auton-shots-not-blocked' : valNum,
    '#auton-goalie-start' : valLocation
  };
  function validate() {
    valid = true;
    if (!validateOneMap(valMap)) valid = false;
    if ($('#no-show').prop('checked')) {
      return valid;
    } else if ($('#goalie').prop('checked')) {
      if (!validateOneMap(goalieAutonMap)) valid = false;
      if(!validateOneMap(teleopMap)) valid = false;
    } else if ($('#normal-auton').prop('checked')) {
      if (!validateOneMap(normalAutonMap)) valid = false;
      if(!validateOneMap(teleopMap)) valid = false;
    }
    return valid;
  }
function prepSubmit() {
  $('.invalid').removeClass('invalid');
  autoZero();
  if (!validate()) {
    alertify.error('Invalid Data');
    return;
  }
  var red = false;
  curMatch = window.schedule[$('#match').val()];
  if(typeof(curMatch) === 'undefined')  {
    alertify.error('Match curMatch team finding broke');
  }
  var team = parseInt($('#team').val());
  if(curMatch.red_1 == team || curMatch.red_2 == team || curMatch.red_3 == team) red = true;
  var post = {};
  post.match_number = parseInt($('#match').val());
  post.team_number = team;
  post.scout_id = parseInt($('#scout').val());
  
  post.no_show = $('#no-show').prop('checked')?true:false;
  if(!(post.no_show)) {
    post.auto_goalie = $('#goalie').prop('checked') ? true:false;
    if(post.auto_goalie) {
      post.auto_location = $('#auton-goalie-start').val();              
      post.auto_block = parseInt($('#auton-shots-blocked').val());
      post.auto_block_miss = parseInt($('#auton-shots-not-blocked').val());
    } else {
      post.auto_location = $('#auton-normal-start').val();  
      post.auto_high_hot = parseInt($('#auton-high-hot').val());
      post.auto_high_cold = parseInt($('#auton-high-cold').val());
      post.auto_high_miss = parseInt($('#auton-high-miss').val());
      post.auto_low_hot = parseInt($('#auton-low-hot').val());
      post.auto_low_cold = parseInt($('#auton-low-cold').val());
      post.auto_low_miss = parseInt($('#auton-low-miss').val());
      post.auto_mobility = $('#auton-mobility').prop('checked') ? true:false;
    }
    
    if($('#defense-75').prop('checked')) {
      post.tele_defense_time = 3;
    } else if($('#defense-50').prop('checked')) {
      post.tele_defense_time = 2;
    } else if($('#defense-25').prop('checked')) {
      post.tele_defense_time = 1;
    } else {
      post.tele_defense_time = 0;
    }
    post.tele_high_score = parseInt($('#high-score').val());
    post.tele_high_miss = parseInt($('#high-miss').val());
    post.tele_low_score = parseInt($('#low-score').val());
    post.tele_low_miss = parseInt($('#low-miss').val());
    
    post.truss = parseInt($('#truss').val());
    post.truss_miss = parseInt($('#truss-miss').val());
    post.catch = parseInt($('#catch').val());
    post.catch_miss = parseInt($('#catch-miss').val());
    
    post.human_pass = parseInt($('#human-pass').val());
    post.human_pass_miss = parseInt($('#human-pass-miss').val());
    post.robot_pass = parseInt($('#robot-pass').val());
    post.robot_pass_miss = parseInt($('#robot-pass-miss').val());
    
    post.human_load = parseInt($('#human-load').val());
    post.human_load_miss = parseInt($('#human-load-miss').val());
    post.floor_load = parseInt($('#floor-load').val());
    post.floor_load_miss = parseInt($('#floor-load-miss').val());
    
    post.other_possess = parseInt($('#other-possessions').val());
    post.dropped_balls = parseInt($('#dropped-ball').val());
    
    post.tele_block = parseInt($('#balls-blocked').val());
    post.tipped = $('#tipped').prop('checked')?true:false;
    post.lost_comms = $('#lost-comms').prop('checked')?true:false;
    post.broke_down = $('#broke-down').prop('checked')?true:false;
    post.fouls = parseInt($('#fouls').val());
    post.tech_fouls = parseInt($('#tech-fouls').val()); //NaN??
    
    post.driving_rating = parseInt($('#driving').val());
    post.pushing_rating = parseInt($('#pushing').val());
    post.defense_rating = parseInt($('#defense').val());
   
  }
  return post;
} 
  
$(document).ready(function() {
  $('#match').focus();
  $('#submit').click(function() {
    var post = prepSubmit();
    if(!post) return;
    $.post('/?controller=submit&action=submit', JSON.stringify(post), function(dat) {
      alertify.success('Data submitted :)');
      /*window.setTimeout(function() {
        location.reload(true); 
      }, 1000);*/
    }).fail(function(dat) {
      alertify.error(dat.responseText);
      console.log(dat.responseText);
    });
  });
  $('#update').click(function() {
    var post = prepSubmit();
    if(!post) return;
    $.post('/?controller=submit&action=update', JSON.stringify(post), function(dat) {
      alertify.success('Data updated :/');
      /*window.setTimeout(function() {
        location.reload(true); 
      }, 1000);*/
    }).fail(function(dat) {
      alertify.error(dat.responseText);
      console.log(dat.responseText);
    });
  });
});

})();

//end submit.js