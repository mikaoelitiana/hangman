<?php
/**
 * @file
 * Contains functions related to game
 */

define('ERROR_LIMIT', 5);

/**
 * Start game and store in session
 */
function _hangman_start_game() {
  if (isset($_SESSION['hangman_word'])) {
    unset($_SESSION['hangman_word']);
  }
  $_SESSION['hangman_game_started'] = time();
  $_SESSION['hangman_found'] = 0;
  $_SESSION['hangman_errors'] = 0;
  $_SESSION['hangman_word'] = _hangman_get_guess_word();
}

/**
 * End game and store in session
  */
function _hangman_end_game() {
  $_SESSION['hangman_game_ended'] = time();
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
      _hangman_end_game();
      $won = true;
      $score = _hangman_calculate_score($word, $_SESSION['hangman_errors'], $_SESSION['hangman_game_started'], $_SESSION['hangman_game_ended']);
    }
  } else {
    $_SESSION['hangman_errors'] += 1;
    if ($_SESSION['hangman_errors'] >= ERROR_LIMIT) {
      _hangman_end_game();
      $game_over = true;
    }
  }

  return array(
    'positions' => $found,
    'char' => $params['char'],
    'won' => $won,
    'game_over' => $game_over,
    'score' => $score,
  );
}
