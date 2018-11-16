<?php

namespace Drupal\tfa_import\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TfaImportController {
  
  // Implementation of ControllerInterface::create method.
  public static function create(ContainerInterface $container) {
    return new static($container->get('module_handler'));
  }

  // public welcome page callback
  public function welcome() {
    $build = array(
      '#type' => 'markup',
      '#markup' => t('Teach for America Import Utility'),
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
