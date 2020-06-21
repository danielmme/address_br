<?php

namespace Drupal\address_br\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'address_br_field_widget' widget.
 *
 * @FieldWidget(
 *   id = "address_br_field_widget",
 *   module = "address_br",
 *   label = @Translation("Address br widget"),
 *   field_types = {
 *     "address_br_field_type"
 *   }
 * )
 */

class AddressBrFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'size' => 60,
      'placeholder' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['consult_postal_code'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Fill address'),
      '#description' => $this->t('Auto fill address by postal code field.'),
      '#default_value' => $this->getSetting('consult_postal_code'),
      '#required' => FALSE,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = $this->t('Auto fill address: @consult_postal_code', ['@consult_postal_code' => $this->getSetting('consult_postal_code') == 1 ? $this->t('True') : $this->t('False')]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $item = $items[$delta];
    $value = $item->toArray();

    $states = [
      'AC' => 'Acre',
      'AL' => 'Alagoas',
      'AP' => 'Amapá',
      'AM' => 'Amazonas',
      'BA' => 'Bahia',
      'CE' => 'Ceará',
      'DF' => 'Distrito Federal',
      'ES' => 'Espírito Santo',
      'GO' => 'Goiás',
      'MA' => 'Maranhão',
      'MT' => 'Mato Grosso',
      'MS' => 'Mato Grosso do Sul',
      'MG' => 'Minas Gerais',
      'PA' => 'Pará',
      'PB' => 'Paraíba',
      'PR' => 'Paraná',
      'PE' => 'Pernambuco',
      'PI' => 'Piauí',
      'RJ' => 'Rio de Janeiro',
      'RN' => 'Rio Grande do Norte',
      'RS' => 'Rio Grande do Sul',
      'RO' => 'Rondônia',
      'RR' => 'Roraima',
      'SC' => 'Santa Catarina',
      'SP' => 'São Paulo',
      'SE' => 'Sergipe',
      'TO' => 'Tocantins',
    ];

    $element['postal_code'] = [
      '#type' => 'textfield',
      '#default_value' => $value['postal_code'],
      '#required' => TRUE,
      '#title' => $this->t('CEP'),
      '#size' => 4,
      '#attributes' => [
        'id' => 'cep',
         'placeholder' => t('00000-000'),
      ],
    ];

    $element['thoroughfare'] = [
      '#type' => 'textfield',
      '#default_value' => $value['thoroughfare'],
      '#required' => TRUE,
      '#title' => $this->t('Endereco'),
      '#attributes' => [
        'id' => 'thoroughfare',
        'placeholder' => t('Endereco'),
      ],
    ];

    $element['number'] = [
      '#type' => 'textfield',
      '#default_value' => $value['number'],
      '#required' => TRUE,
      '#title' => $this->t('Número'),
      '#attributes' => [
        'id' => 'street-number',
        'placeholder' => t('Número'),
      ],
      '#maxlength' => 10,
      '#size' => 10,
    ];

    $element['street_complement'] = [
      '#type' => 'textfield',
      '#default_value' => $value['street_complement'],
      '#required' => FALSE,
      '#title' => $this->t('Complemento'),
      '#attributes' => [
        'id' => 'street-complement',
        'placeholder' => t('Complemento'),
      ],
    ];

    $element['neighborhood'] = [
      '#type' => 'textfield',
      '#default_value' => $value['neighborhood'],
      '#required' => TRUE,
      '#title' => $this->t('Bairro'),
      '#attributes' => [
        'id' => 'neighborhood',
        'placeholder' => t('Bairro'),
      ],
    ];

    $element['city'] = [
      '#type' => 'textfield',
      '#default_value' => $value['city'],
      '#required' => TRUE,
      '#title' => $this->t('Cidade'),
      '#attributes' => [
        'id' => 'city',
        'placeholder' => t('Cidade'),
      ],
      '#maxlength' => 10,
      '#size' => 10,
    ];

    $element['state'] = [
      '#type' => 'select',
      '#options' => $states,
      '#default_value' => $value['state'],
      '#required' => TRUE,
      '#title' => $this->t('Estado'),
      '#attributes' => [
        'id' => 'state',
        'placeholder' => t('Estado'),
      ],
      '#maxlength' => 10,
      '#size' => 10,
    ];

    $element['telephone'] = [
      '#type' => 'textfield',
      '#options' => $states,
      '#default_value' => $value['telephone'],
      '#required' => TRUE,
      '#title' => $this->t('Telefone'),
      '#attributes' => [
        'id' => 'telefone',
        'placeholder' => t('Telefone'),
      ],
    ];
    $element['#attached']['library'][] = 'address_br/jquery_mask';
    $element['#attached']['library'][] = 'address_br/theme';
    return $element;
  }

}
