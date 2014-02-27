//entryform.js
(function() {
  function hasTeam(team) {
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
  function checkMatch() {
    var matchData = window.schedule[$('#match').val()];
    if(typeof(matchData) === 'undefined' && $('#match').val().length > 0) {
      $('#match').addClass('invalid');
      $('.schedule-preview td').html('');
    } else {
      $('#match').removeClass('invalid');
      $('.schedule-preview td').removeClass('found');
      if($('#match').val().length === 0) {
        $('.schedule-preview td').html('');
      } else {
        console.log(matchData);
        $('#r1p').html(matchData.red_1);
        if(matchData.has_red_1 === '1') $('#r1p').addClass('found');
        $('#r2p').html(matchData.red_2);
        if(matchData.has_red_2 === '1') $('#r2p').addClass('found');
        $('#r3p').html(matchData.red_3);
        if(matchData.has_red_3 === '1') $('#r3p').addClass('found');
        $('#b1p').html(matchData.blue_1);
        if(matchData.has_blue_1 === '1') $('#b1p').addClass('found');
        $('#b2p').html(matchData.blue_2);
        if(matchData.has_blue_1 === '1') $('#b2p').addClass('found');
        $('#b3p').html(matchData.blue_3);
        if(matchData.has_blue_1 === '1') $('#b3p').addClass('found');
      }
    } 
  }
  
  function checkTeam() {
    var teamBox = $('#team');
    var team = window.teams[teamBox.val()];
    var teamNum = teamBox.val();
    if((typeof(team) === 'undefined' || !hasTeam(teamNum)) && teamBox.val().length > 0) {
      teamBox.addClass('invalid');
    } else {
      teamBox.removeClass('invalid');
    }
  }
$(document).ready(function() {
  $('#team').keyup(function () {
    checkMatch();
    checkTeam();
  });
  $('#match').keyup(function () {
    checkMatch();
    checkTeam();
  });
  
  $('#scout').keyup(function() {
    $(this).removeClass('invalid');
    $('#scout-display').html('');
    var scoutId = $(this).val();
    var scoutName = window.scouts[scoutId];
    if(typeof(scoutName) === 'undefined' && $(this).val() !== '') {
      $(this).addClass('invalid');
    } else {
      if($(this).val() !== '') {
        $('#scout-display').html(scoutName);
      }
    }
  });
});
})();