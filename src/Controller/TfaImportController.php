<?php

namespace Drupal\tfa_import\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TfaImportController {
  
  // Implementation of ControllerInterface::create method.
  public static function create(ContainerInterface $container) {
    return new static($container->get('module_handler'));
  }

  // public welcome page callback.
  public function welcome() {

	//drupal_set_message( t('You submitted %source', array('%source' => $source)));
	//$tempstore = \Drupal::service('user.private_tempstore')->get('tfa_import');
	//$some_data = $tempstore->get('my_variable_name');

	$var = \Drupal::request()->query->get('q');

    $build = array(
      '#type' => 'markup',
      '#markup' => t('Welcome! ' . $var),
    );
    return $build;
  }

  // Create node page callback
  public function create_node() {

	//$posts_source_url = $request->query->get('posts_source');
	$output = array(
		'#markup' => tfa_import_create_node()
	);
  	return $output;
  }
}
