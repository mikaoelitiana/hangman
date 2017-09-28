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
    var char = $(this).data("key")
    $.getJSON("hangman/check-char", { char: char }, function(data){
      console.log(data);
      incrementErrors();
      $(this).addClass('hangman-keyboard--button_error');
    });
    $(this).attr('disabled', 'true');
  });


});
