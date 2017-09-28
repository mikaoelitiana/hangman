<?php

/**
 * Create hangman main page
 */
function _hangman_page() {
  _hangman_start_game();

  drupal_add_js(drupal_get_path('module', 'hangman') . '/js/hangman.js');
  drupal_add_css(drupal_get_path('module', 'hangman') . '/css/hangman.css');

  $content = array();

  $word = _hangman_get_guess_word();
  $word_count = strlen($word);

  $content['text_placeholder'] = array(
    '#type' => 'markup',
    '#markup' => '<div class="hangman-placeholders">' .
      str_repeat('<div class="hangman-placeholders--char">?</div>', $word_count) .
    '</div>',
  );

  $content['text_input'] = array(
    '#type' => 'markup',
    '#markup' => '<div class="hangman-inputs">' . _hanman_build_keyboard() . '</div>',
  );

  return $content;
}

/**
 * Start game and store in session
 */
function _hangman_start_game() {
  $_SESSION['hangman_game_started'] = true;
}

/**
 * End game and store in session
  */
function _hangman_end_game() {
  $_SESSION['hangman_game_started'] = false;
}

/**
 * Take the guess word from session if exists
 * otherwise return a random word and store
 * in session
 */
function _hangman_get_guess_word() {
  if (!isset($_SESSION['hangman_word'])) {
    $words = array("3dhubs", "marvin", "print", "filament", "order", "layer");
    $word = $words[rand(0, count($words) - 1)];
    $_SESSION['hangman_word'] = $word;
  } else {
    $word = $_SESSION['hangman_word'];
  }
  return $word;
}

/**
 * Find all positions of a char in a given word
 */
function _hangman_char_positions_in_word($char, $word) {
  $found = array();
  $offset = 0;
  while(($at = strpos($word, $char, $offset)) !== false) {
    $found[] = $at;
    $offset = $at + 1;
  }
  return $found;
}


/**
 * Build a keyboard layout
 */
function _hanman_build_keyboard()
{
  $chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
  $keyboard = '<div class="hangman-keyboard">';
  foreach($chars as $char){
    $keyboard .= '<button data-key="' . $char . '" class="hangman-keyboard--button">' . $char . '</button>';
  }
  $keyboard .= '</div>';
  return $keyboard;
}

/**
 * Check if submited char exists in current guess word
 */
function _hangman_ajax_check_char()
{
  return array();
}
