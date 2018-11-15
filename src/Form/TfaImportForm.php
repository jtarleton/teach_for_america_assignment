<?php 

namespace Drupal\tfa_import\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TfaImportForm extends FormBase {


	/**
	 * @param $form array 
	 * @param $form_state object implementing FormStateInterface
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form['posts_source'] = array(

			'#type' => 'textfield',
			'#title' => $this->t('some form title'),
			'#default_value' => 'https://jsonplaceholder.typicode.com/posts',
			'#required' => true,
		);


		$form[] = array(
			'#type' => 'actions'
		);

		$form['actions']['submit'] = array(

			'#type' => 'submit',
			'#value' => $this->t('Load')
		);
		return $form;
	}

	public function getFormId() {
		return 'tfa_import_form';
	}

        /**
         * @param $form array 
         * @param $form_state object implementing FormStateInterface
         */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		$url = $form_state->getValue('posts_source');
		$begins_with_http = (strpos($url, 'https') === 0) || (strpos($url, 'http') === 0);
		if (strlen($url) < 10) {
			$form_state->setErrorByName('posts_source', $this->t('The source URL must be at least 10 characters long'));
		}
		
		if (!$begins_with_http) {
			$form_state->setErrorByName('posts_source', $this->t('Please enter a URL that begins with http or https.'));
		
		}
		
	}

        /**
         * @param $form array 
         * @param $form_state object implementing FormStateInterface
         */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$source = $form_state->getValue('posts_source');

		$tempstore = \Drupal::service('user.private_tempstore')->get('tfa_import');
		$tempstore->set('my_variable_name', $source);
		$form_state->setRedirect('tfa_import.create');
 		return;

	}

}
