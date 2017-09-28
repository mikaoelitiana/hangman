<?php
/**
 * @file
 * Contains functions related to displaying thins
 */

 require_once 'gameplay.php';

/**
 * Create hangman main page
 */
function _hangman_page() {
  global $user;
  $username = isset($user->name) ? $user->name : "Anonymous";

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


  $content['text_save_score'] = array(
    '#type' => 'markup',
    '#markup' => '<div class="hangman-game-save-score" style="display:none;">
    <label>Username: </label>
    <input type="text" value="' . $username . '" id="hangman_score_username"/>
    <button class="hangman-game-save-score--button">Save score</button>
    </div>',
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

function _hangman_high_scores_page() {
  $content = array();

  $content['lead_board'] = array(
    '#type' => 'markup',
    '#markup' => '<div>
      ' . _hangman_build_lead_board() . '
    </div>',
  );

  return $content;
}

function _hangman_build_lead_board() {
  $leadboard = '<div class="hangman_leadboard"><table>';
  $result = _hangman_get_high_scores();
  while($record = $result->fetchAssoc()) {
    $leadboard .= '<tr><td>' . $record['name'] . '</td><td>' . $record['max_score'] . '</td>';
  }
  $leadboard .= '</table></div>';

  return $leadboard;
}
