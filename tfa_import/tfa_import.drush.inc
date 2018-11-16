<?php 

/**
 * Implements hook_drush_command().
 */
function tfa_import_drush_command() {

  $commands['tfa-post-import'] = [
    'description' => 'This is the tfa-post-import command.',
    'aliases' => ['pimport'],
    'arguments' => [
       'arg1' => 'My custom argument 1.',
       'arg2' => 'My custom argument 2.',
     ],
     'options' => [
       'opt1' => 'My custom option.',
     ],
     'examples' => [
       'drush pimport' => 'Print post import command.',
       'drush pimport myargument' => 'Print post import command with an argument "myargument".',
       'drush pimport myargument --opt1=myoption' => 'Print post import command with an argument "myargument" and an option "myoption".',
     ],
  ];

  return $commands;
}

/**
 * Drush command logic.
 * drush_[MODULE_NAME]_[COMMAND_NAME]().
 */
function drush_tfa_import_tfa_post_import_command($arg1 = 'N/A', $arg2 = 'N/A') {
  $opt1 = drush_get_option('opt1', 'N/A');
  $tokens = ['@arg1' => $arg1, '@opt1' => $opt1];
  drush_print(dt('My custom command. Argument: @arg1 Option: @opt1', $tokens));
}
