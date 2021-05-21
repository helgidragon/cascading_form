<?php


namespace Drupal\cascading_form\Form;


use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InsertCommand;
use Drupal\Core\Ajax\ReplaceCommand;
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
      '#options' => [1 => 1, 2 => 2, 3 => 3],
      '#title' => $this->t('Seleccionar número'),
      '#description' => $this->t('Seleccionar número de 1 a 5'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::selectText',
//        'wrapper' => 'selection-text',
        'event' => 'change'
      ],
    ];

    $form['cascading']['select_text'] = [
      '#type' => 'select',
      '#options' => [],
      '#title' => $this->t('Seleccionar letra'),
      '#description' => $this->t('Seleccionar letras de A a E'),
      '#required' => TRUE,
      '#prefix' => '<div id="selection-text">',
      '#suffix' => '</div>',
      '#validated' => TRUE,
      '#ajax' => [
        'callback' => '::selectDoubleText',
//        'wrapper' => 'selection-double-text',
        'event' => 'change'
      ],
    ];

    $form['cascading']['select_double_text'] = [
      '#type' => 'select',
      '#options' => [],
      '#title' => $this->t('Seleccionar doble letra'),
      '#description' => $this->t('Seleccionar letras de A a E'),
      '#required' => TRUE,
      '#prefix' => '<div id="selection-double-text">',
      '#suffix' => '</div>',
      '#validated' => TRUE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Enviar formulario'
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addStatus('Valor del campo select_number: '. $form_state->getValue('select_number'));
    \Drupal::messenger()->addStatus('Valor del campo select_text: '. $form_state->getValue('select_text'));
    \Drupal::messenger()->addStatus('Valor del campo select_double_text: '. $form_state->getValue('select_double_text'));
  }

  public function selectText(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $selection = $form_state->getValue('select_number');
    $elements = ['' => '- seleccionar -'];

    if (!empty($selection)) {
      switch ($selection) {
        case 1:
          $elements = ['' => '- seleccionar -', 'A1' => 'A1', 'B1' => 'B1', 'C1' => 'C1'];
          break;
        case 2:
          $elements = ['' => '- seleccionar -', 'A2' => 'A2', 'B2' => 'B2', 'C2' => 'C2'];
          break;
        case 3:
          $elements = ['' => '- seleccionar -', 'A3' => 'A3', 'B3' => 'B3', 'C3' => 'C3'];
          break;
      }

      $form['cascading']['select_text']['#options'] = $elements;

      $response->addCommand(
        new ReplaceCommand(
          '#selection-text', $form['cascading']['select_text']
        ),

      );


      return  $response;
    }

    $form['cascading']['select_double_text']['#options'] = ['' => '- seleccionar -'];
    $form['cascading']['select_text']['#options'] = $elements;

    $response->addCommand(
      new ReplaceCommand(
        '#selection-text', $form['cascading']['select_text']
      ),

    );

    $response->addCommand(
      new ReplaceCommand(
        '#selection-double-text', $form['cascading']['select_double_text']
      ),

    );
    return $response;
  }

  public function selectDoubleText(array &$form, FormStateInterface $form_state) {
    $selection = $form_state->getValue('select_text');
    $response = new AjaxResponse();

    $elements = [];

    switch ($selection) {
      case 'A1':
        $elements = ['' => '- seleccionar -', 'AA1' => 'AA1', 'AAA1' => 'AAA1'];
        break;
      case 'A2':
        $elements = ['' => '- seleccionar -', 'AA2' => 'AA2', 'AAA2' => 'AAA2'];
        break;
      case 'A3':
        $elements = ['' => '- seleccionar -', 'AA3' => 'AA3', 'AAA3' => 'AAA3'];
        break;
      case 'B1':
        $elements = ['' => '- seleccionar -', 'BB1' => 'BB1', 'BBB1' => 'BBB1'];
        break;
      case 'B2':
        $elements = ['' => '- seleccionar -', 'BB2' => 'BB2', 'BBB2' => 'BBB2'];
        break;
      case 'B3':
        $elements = ['' => '- seleccionar -', 'BB3' => 'BB3', 'BBB3' => 'BBB3'];
        break;

    }

    $form['cascading']['select_double_text']['#options'] = $elements;

    $response->addCommand(
      new ReplaceCommand(
        '#selection-double-text', $form['cascading']['select_double_text']
      ),

    );

    return $response;
  }

}
