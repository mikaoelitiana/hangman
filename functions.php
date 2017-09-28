<?php

define('ERROR_LIMIT', 5);


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
  $_SESSION['hangman_found'] = 0;
  $_SESSION['hangman_errors'] = 0;
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
  while(($at = stripos($word, $char, $offset)) !== false) {
    $found[] = $at + 1;
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
  $params = drupal_get_query_parameters();
  $word = _hangman_get_guess_word();
  $found = _hangman_char_positions_in_word($params['char'], $word);
  $won = false;
  $game_over = false;

  if (count($found) > 0) {
    $_SESSION['hangman_found'] += count($found);
    if($_SESSION['hangman_found'] == strlen($word)) {
      $won = true;
    }
  } else {
    $_SESSION['hangman_errors'] += 1;
    if ($_SESSION['hangman_errors'] >= ERROR_LIMIT) {
      $game_over = true;
    }
  }

  return array(
    'positions' => $found,
    'char' => $params['char'],
    'won' => $won,
    'game_over' => $game_over,
  );
}
