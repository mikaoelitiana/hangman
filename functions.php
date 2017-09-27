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
      str_repeat('<div class="hangman-placeholders--char">&nbsp;</div>', $word_count) .
    '</div>',
  );

  $content['text_input'] = array(
    '#type' => 'markup',
    '#markup' => '<div class="hangman-inputs"><input type="text" placeholder="Try letter or number ..."/></div>',
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
