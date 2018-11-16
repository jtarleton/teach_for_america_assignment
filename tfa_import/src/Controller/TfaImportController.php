<?php

namespace Drupal\tfa_import\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
class TfaImportController {
  
  // Implementation of ControllerInterface::create method.
  public static function create(ContainerInterface $container) {
    return new static($container->get('module_handler'));
  }

  // public welcome page callback
  public function welcome() {
    $form_url  = Url::fromRoute('tfa_import.form')->toString();
    $users_url = Url::fromRoute('tfa_import.users')->toString();
    $build = array(
      '#type' => 'markup',
      '#markup' => t('Teach for America Import Utility <ul><li><a href="' . $form_url .  '">Posts import</a></li><li><a href="' . $users_url .  '">Users import</a></li></ul>'),
    );
    return $build;
  }

  // Create node page callback
  public function create_node() {
	$output = array(
		'#markup' => tfa_import_create_node()
	);
  	return $output;
  }
  // create user page callback
  public function create_user() {
  	$output = array(
		'#markup' => tfa_import_create_user()
	);
	return $output;
  }
}
