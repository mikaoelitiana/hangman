<?php
/**
 * @file
 * Contains functions related to displaying thins
 */

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

  $content['text_game_status'] = array(
    '#type' => 'markup',
    '#markup' => '<div class="hangman-game-status"></div>',
  );

  return $content;
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
