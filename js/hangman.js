jQuery(function($){
  var countErrors = 0;

  function incrementErrors() {
    countErrors++;
    if (countErrors >= 5) {
      // Game over
    }
  }

  $('.hangman-keyboard--button').click(function(){
    incrementErrors();
    $(this).attr('disabled', 'true');
  });


});
