<?php
/**
 * @file
 * Functions related to score calculation and storage
 */

 /**
  * Store one user score to database
  */
 function _hangman_store_score($user, $score)
 {

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

  return $score;
 }

