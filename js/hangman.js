jQuery(function($){
  var countErrors = 0;

  function incrementErrors() {
    countErrors++;
    if (countErrors >= 5) {
      // Game over
      disableAllButtons();
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
        incrementErrors();
        key.addClass('hangman-keyboard--button_error');
      } else {
        for (var i = 0; i < data.positions.length; i++) {
          var element = data.positions[i];
          $(`.hangman-placeholders--char:nth-child(${element})`).html(data.char);
        }
        key.addClass('hangman-keyboard--button_found');
      }
    });
    $(this).attr('disabled', 'true');
  });


});
