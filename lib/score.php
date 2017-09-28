<?php
/**
 * @file
 * Functions related to score calculation and storage
 */

 /**
  * Store one user score to database
  *
  * @param string $username The name to store in DB
  * @param int $score The score to store
  */
 function _hangman_store_score($username, $score)
 {
  global $user;

  if($username != '' && $score){
    $sid = db_insert('hangman_score')
      ->fields(array(
        'uid' => isset($user->uid) ? $user->uid : 0,
        'name' => $username,
        'score' => $score,
      ))
      ->execute();

    return $sid;
  }
  return false;
 }

 /**
  * Calculate user score
  *
  * @param string $word The guess word
  * @param int $errors Errors count
  * @param int $start Game start timestamp
  * @param int $end Game end timestamp
  *
  * @return int the score
  */
 function _hangman_calculate_score($word, $errors, $start, $end) {
   // initial score is 1000
   $score = strlen($word) * 1000;

   // If any error done, remove some points
   if ($errors > 0) {
     $score -= $errors * 35;
   } else {
     // Bonus if no error
     $score += 1500;
   }

  // calculate totla time and ad some score
  $score += (int)(exp(1/($end - $start)) * 1500);

  // temporary store score
  $_SESSION['hangman_latest_score'] = $score;

  return $score;
 }

function _hangman_ajax_save_score() {
  $params = drupal_get_query_parameters();
  $score = $_SESSION['hangman_latest_score'];

  unset($_SESSION['hangman_latest_score']);

  return array(
    'sid' => _hangman_store_score($params['username'], $score),
  );
}

function _hangman_get_high_scores() {
  $query = db_select('hangman_score', 'hs')
    ->fields('hs', array('sid', 'name', 'score'))
    ->groupBy('hs.uid')
    ->orderBy('score', 'DESC')
    ->range(0, 10);

  $query->addExpression('MAX(score)', 'max_score');

  return $query->execute();
}
