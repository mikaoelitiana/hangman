jQuery(function($){

  function checkGameOver(data) {
    if (data.game_over) {
      // Game over
      disableAllButtons();
      $('.hangman-game-status').html('\
        <div class="hangman-game-status_over">😥 Game Over!</div>\
        <div class="hangman-game-status_restart"><button onclick="window.location.reload()">Retry</button></div>\
        ');
    }
  }

  function checkVictory(data) {
    if (data.won) {
      // You won
      disableAllButtons();

      $('.hangman-game-status').html('\
        <div class="hangman-game-status_won">🌟🌟 You won!!! ' + data.score + 'pts 🌟🌟</div>\
        <div class="hangman-game-status_restart"><button onclick="window.location.reload()">Restart</button></div>\
        ');

      $('.hangman-game-save-score').show();
    }
  }

  function disableAllButtons() {
    $('.hangman-keyboard--button').attr('disabled', true);
  }

  $('.hangman-keyboard--button').click(function(){
    var key = $(this);
    var char = $(this).data("key");
    $.getJSON("hangman/check-char", { char: char }, function(data){
      if (data.positions.length < 1) {
        checkGameOver(data);
        key.addClass('hangman-keyboard--button_error');
      } else {
        checkVictory(data);
        for (var i = 0; i < data.positions.length; i++) {
          var element = data.positions[i];
          $(`.hangman-placeholders--char:nth-child(${element})`).html(data.char);
        }
        key.addClass('hangman-keyboard--button_found');
      }
    });
    $(this).attr('disabled', 'true');
  });

  $('.hangman-game-save-score--button').click(function() {
    $.getJSON("hangman/save-score", { username : $('hangman_score_username').val() }, function(data){

    });
  });

});
