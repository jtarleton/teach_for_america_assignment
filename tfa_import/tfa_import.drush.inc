<?php 
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;

/**
 * Implements hook_drush_command().
 */
function tfa_import_drush_command() {

  $commands['tfa-post-import'] = [
    'description' => 'This is the tfa-post-import command.',
    'aliases' => ['pimport'],
    'options' => [
       'batchsize' => 'Optional batch size of the import.',
     ],
     'examples' => [
       'drush pimport' => 'Print post import command.',
       'drush pimport --batchsize=2' => 'Run post import with the batchsize option. Split processing into 2 batches.',
      ],
  ];

  return $commands;
}

/**
 * Drush command logic.
 * drush_[MODULE_NAME]_[COMMAND_NAME]().
 */
function drush_tfa_import_tfa_post_import($arg1 = 'N/A', $arg2 = 'N/A') {
  $batch_size = drush_get_option('batchsize', 1);
  $posts_endpoint = 'https://jsonplaceholder.typicode.com/posts';
  $posts = json_decode(file_get_contents($posts_endpoint), true);
  $i = 0;

  if (empty($batch_size)) {
    $batch_size = 1; 
  }
  $post_chunks = array_chunk($posts, $batch_size);

  foreach ($post_chunks as $posts) {
    foreach ($posts as $post) {
      $node_entity_bundle = array(
      'id' => (int) $post['id'],
      'type' => 'article',
      'created' => REQUEST_TIME,
      'changed' => REQUEST_TIME,
      'uid' => $post['userId'],
      'title' => $post['title'],
      'body' => $post['body']
      );

      $node = Node::create($node_entity_bundle);

      $node->save();
      $slug = str_replace(' ', '-', $post['title']);
      $alias = sprintf('/tfa_import/%s', $slug);
      \Drupal::service('path.alias_storage')->save(sprintf('/node/%s', $node->id()), $alias, 'en');

      $num_imported++;
    } 
  }
  $tokens = array('@num_imported' => $num_imported, '@batch_size' => $batch_size);
  drush_print(dt('Import completed. Processed: @num_imported nodes in @batch_size batches.', $tokens));
}
