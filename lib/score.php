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
  * Calculat user score
  */
 function _hangman_calculate_score() {
   // initial score is 1000
   $score = 1000;

   // If any error done, remove some points
   if ($_SESSION['hangman_errors'] > 0) {
     $score -= $_SESSION['hangman_errors'] * 35;
   } else {
     // Bonus if no error
     $score += 1500;
   }

  // calculate totla time and ad some score

   return $score;
 }
