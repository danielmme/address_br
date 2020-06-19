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
 *   module = "address_br"
 *   label = @Translation("Address br field widget"),
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

    $elements['size'] = [
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $elements['placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = t('Textfield size: @size', ['@size' => $this->getSetting('size')]);
    if (!empty($this->getSetting('placeholder'))) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $this->getSetting('placeholder')]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $item = $items[$delta];
    $value = $item->getEntity()->isNew() ? $this->getInitialValues() : $item->toArray();

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

    $element['#attached']['library'][] = 'br_address_field/theme';

    $element['thoroughfare'] = [
      '#type' => 'textfield',
      '#default_value' => $value['thoroughfare'],
      '#required' => $this->fieldDefinition->isRequired(),
      '#title' => $this->t('Endereço'),
      '#attributes' => [
        'id' => 'thoroughfare',
      ],
    ];

    $element['number'] = [
      '#type' => 'textfield',
      '#default_value' => $value['number'],
      '#required' => $this->fieldDefinition->isRequired(),
      '#title' => $this->t('Numero'),
      '#attributes' => [
        'id' => 'street-number',
      ],
    ];

    $element['street_complement'] = [
      '#type' => 'textfield',
      '#default_value' => $value['street_complement'],
      '#required' => FALSE,
      '#title' => $this->t('Complemento'),
      '#attributes' => [
        'id' => 'street-complement',
      ],
    ];

    $element['neighborhood'] = [
      '#type' => 'textfield',
      '#default_value' => $value['neighborhood'],
      '#required' => $this->fieldDefinition->isRequired(),
      '#title' => $this->t('Bairro'),
      '#attributes' => [
        'id' => 'neighborhood',
      ],
    ];

    $element['city'] = [
      '#type' => 'textfield',
      '#default_value' => $value['city'],
      '#required' => $this->fieldDefinition->isRequired(),
      '#title' => $this->t('Cidade'),
      '#attributes' => [
        'id' => 'city',
      ],
    ];

    $element['state'] = [
      '#type' => 'select',
      '#options' => $states,
      '#default_value' => $value['state'],
      '#required' => $this->fieldDefinition->isRequired(),
      '#title' => $this->t('Estado'),
      '#attributes' => [
        'id' => 'state',
      ],
    ];

    return $element;
  }

}
