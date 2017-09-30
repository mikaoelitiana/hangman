<?php

/**
 * @file Admin functions
 * */



/**
 * Display word list in admin
 */
function _hangman_word_sort_with_pager_content() {
  $header = array(
    array('data' => t('Id'), 'field' => 'wid', 'sort' => 'desc'),
    array('data' => t('Word'), 'field' => 'word'),
    array('data' => t('Action')),
  );

  $query = db_select('hangman_word', 'hw');
  $query->fields('hw', array('wid', 'word'));

  $table_sort = $query->extend('TableSort')
    ->orderByHeader($header);
  $pager = $table_sort->extend('PagerDefault')
    ->limit(25);
  $result = $pager->execute();

  $rows = array();
  foreach($result as $res){
    $rows[] = array($res->wid, $res->word, '<a href="' . url('admin/hangman/word/' . $res->wid . '/edit') . '">Edit</a> | <a href="' . url('admin/hangman/word/' . $res->wid . '/delete') . '" onclick="return confirm(\'Are you sure\')">Delete</a>');
  }

  if (!empty($rows)) {
    $output = theme('table', array('header' => $header, 'rows' => $rows, 'attributes' => array('id' => 'sort-table')));
    $output .= theme('pager');
  }
  else {
    $output .= t("No results found.");
  }

  $output .= '<br /><a href="' . url('admin/hangman/word/add') . '">Add new record</a>';
  return $output;
}

/**
 * Delete one word from admin
 */
function _hangman_word_delete(){
  $wid = arg(3);

  $num_updated = db_delete('hangman_word')
    ->condition('wid', $wid, '=')
    ->execute();

  drupal_set_message(t('Record has been deleted!'));
  drupal_goto("admin/hangman/word/");
}


function _hangman_word_form($form, &$form_state, $id = null) {
  // Check if it is an update
  if($id) {
    $word = _hangman_get_word_by_id($id);
  } else {
    $word = array();
  }

  $form['word'] = array(
    '#type' => 'textfield',
    '#title' => t('Word'),
    '#description' => t('One word to guess.'),
    '#default_value' => isset($word['word']) ? $word['word'] : '',
    '#size' => 40,
    '#maxlength' => 9,
    '#required' => TRUE,
  );

  if (isset($word['wid'])) {
    $form['wid'] = array(
      '#type' => 'hidden',
      '#value' => $word['wid'],
    );
  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );

  $form['#submit'][] = '_hangman_word_submit';
  return $form;
}


function _hangman_word_submit($form, $form_state) {
  $error = false;

  if ( !isset($form_state['values']['word']) ) {
    form_set_error('word', t('The word is required.'));
    $error = true ;
  }

  if(!$error){
    $word = $form_state['values']['word'];
    $wid = isset($form_state['values']['wid']) ? $form_state['values']['wid'] : null;

    $wid = db_merge('hangman_word')
      ->key(array('wid' => $wid))
      ->fields(array(
        'word' => $word,
      ))
      ->execute();

    drupal_set_message(t('Record has been saved!'));
  }
}
