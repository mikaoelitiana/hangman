<?php
/**
 * @file functions related to word
 */

 /**
 * Take the guess word from session if exists
 * otherwise return a random word and store
 * in session
 */
function _hangman_get_guess_word() {
  if (!isset($_SESSION['hangman_word'])) {
    $result = db_select('hangman_word', 'hw')
      ->fields('hw', array('word'))
      ->range(0,1)
      ->orderRandom()
      ->execute()
      ->fetchAssoc();
    $word = $result['word'];
    $_SESSION['hangman_word'] = $word;
  } else {
    $word = $_SESSION['hangman_word'];
  }
  return $word;
}

 /**
  * Fina one word by ID in DB
  */
function _hangman_get_word_by_id($id = 0) {
  return db_select('hangman_word', 'hw')
    ->fields('hw', array('wid', 'word'))
    ->condition('wid', $id)
    ->execute()
    ->fetchAssoc();
}

/**
 * Find all positions of a char in a given word
 *
 * @param string $char One char to find in the word
 * @param string $word The word to guess
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
