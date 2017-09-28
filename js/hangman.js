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
    jQuery.getJSON("hangman/check-char", function(data){
      console.log(data);
    });
    incrementErrors();
    $(this).attr('disabled', 'true');
    $(this).addClass('hangman-keyboard--button_error');
  });


});
