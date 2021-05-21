<?php


namespace Drupal\cascading_form\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CascadingFormController extends FormBase {

  public function getFormId() {
    return "cascading_form_1";
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['cascading'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Elementos de formulario')
    ];
    $form['cascading']['select_number'] = [
      '#type' => 'select',
      '#options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
      '#title' => $this->t('Seleccionar número'),
      '#description' => $this->t('Seleccionar número de 1 a 5'),
      '#required' => TRUE,
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}
