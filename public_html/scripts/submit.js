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
    return true;
    //IASFHFJALFHKLF
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
    '.miss-low',
    '.miss-high',
    '#balls-blocked',
    '#fouls',
    '#tech-fouls',
    '#driving',
    '#pushing',
    '#defense',
    '#blocking',
    '#posessing',
    '#trussing',
    '#catching',
    '#bad-things'
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
    '#driving,#pushing,#defense,#blocking,#posessing,#trussing,#catching,#bad-things' : valSubj
  };
  var normalAutonMap = {
    '#auton-normal-start' : valLocation,
    '#auton-high-hot,#auton-high-cold,#auton-high-miss,#auton-low-hot,#auton-low-cold,#auton-low-miss' : valNum
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
    
    post.tele_block = parseInt($('#balls-blocked').val());
    post.tipped = $('#tipped').prop('checked')?true:false;
    post.lost_comms = $('#lost-comms').prop('checked')?true:false;
    post.broke_down = $('#broke-down').prop('checked')?true:false;
    post.fouls = parseInt($('#fouls').val());
    post.tech_fouls = parseInt($('#tech-fouls').val()); //NaN??
    
    post.driving_rating = parseInt($('#driving').val());
    post.pushing_rating = parseInt($('#pushing').val());
    post.defense_rating = parseInt($('#defense').val());
    post.blocking_rating = parseInt($('#blocking').val());
    post.control_rating = parseInt($('#posessing').val());
    post.truss_rating = parseInt($('#trussing').val());
    post.catch_rating = parseInt($('#catching').val());
    post.badness_rating = parseInt($('#bad-things').val());
    post.cycles = [];
    $('.cycle-holder').each(function(i) {
      var c = {};
      c.cycle_number = i+1;
      var t = $(this);
      var get_blue = t.find('.get-b').prop('checked')?true:false;
      c.get_mid = t.find('.get-w').prop('checked')?true:false;
      var get_red = t.find('.get-r').prop('checked')?true:false;
      var move_blue = t.find('.move-b').prop('checked')?true:false;
      c.move_mid = t.find('.move-w').prop('checked')?true:false;
      var move_red = t.find('.move-r').prop('checked')?true:false;
      if(red) { //red alliance
        c.get_back = get_blue;
        c.get_front = get_red;
        c.move_back = move_blue;
        c.move_front = move_red;
      } else { //blue alliance
        c.get_back = get_red;
        c.get_front = get_blue;
        c.move_back = move_red;
        c.move_front = move_blue;
      }
      c.truss = t.find('.truss').prop('checked')?true:false;
      c.catch = t.find('.catch').prop('checked')?true:false;
      c.miss_catch = t.find('.catch-miss').prop('checked')?true:false;
      c.human_pass = t.find('.human-pass').prop('checked')?true:false;
      c.score_low = t.find('.score-low').prop('checked')?true:false;
      c.miss_low = parseInt(t.find('.miss-low').val());
      c.score_high = t.find('.score-high').prop('checked')?true:false;
      c.miss_high = parseInt(t.find('.miss-high').val());
      c.possess_time = parseInt(t.find('.possess-time').val());
      post.cycles[i] = c;
    });
  }
  return post;
} 
  
$(document).ready(function() {
  $('#submit').click(function() {
    var post = prepSubmit();
    if(!post) return;
    $.post('/?controller=submit&action=submit', JSON.stringify(post), function(dat) {
      alertify.success('Data submitted :)');
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
    }).fail(function(dat) {
      alertify.error(dat.responseText);
      console.log(dat.responseText);
    });
  });
});

})();

//end submit.js