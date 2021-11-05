<?php

namespace Drupal\manati_layout_builder\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * TwoColClass Section Layout Form class.
 */
class TwoColClass extends BaseSectionClass implements PluginFormInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $column_proportions = array_keys($this->getColumnProportions());
    $spacing_columns = array_keys($this->getSpacing());
    return parent::defaultConfiguration() + [
      'column_proportions' => array_shift($column_proportions),
      'spacing_columns' => array_shift($spacing_columns),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $form['column_proportions'] = [
      '#type' => 'select',
      '#title' => $this->t('Proporción de las columnas'),
      '#default_value' => $this->configuration['column_proportions'],
      '#options' => $this->getColumnProportions(),
      '#description' => $this->t('Elija la proporción para las columnas de esta sección.'),
    ];
    $form['spacing_columns'] = [
      '#type' => 'select',
      '#title' => $this->t('Espacio entre columnas'),
      '#default_value' => $this->configuration['spacing_columns'],
      '#options' => $this->getSpacing(),
      '#description' => $this->t('Elija el tamaño del espacio entre las columnas de esta sección.'),
    ];
    $form['equal_height'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Igualar la altura del contenido de las columnas'),
      '#default_value' => isset($this->configuration['equal_height']) ? $this->configuration['equal_height'] : TRUE,
      '#description' => $this->t('No aplica si hay más de un elemento por columna.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['column_proportions'] = $form_state->getValue('column_proportions');
    $this->configuration['spacing_columns'] = $form_state->getValue('spacing_columns');
    $this->configuration['equal_height'] = $form_state->getValue('equal_height');
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    $build = parent::build($regions);
    $build['#attributes']['class'][] = 'layout--twocol';
    $build['#attributes']['class'][] = 'layout--twocol-' . $this->configuration['column_proportions'];
    $build['#attributes']['class'][] = 'layout--spacing-cols-' . $this->configuration['spacing_columns'];

    if (isset($this->configuration['equal_height']) && $this->configuration['equal_height'] == TRUE) {
      $build['#attributes']['class'][] = 'layout--content-equal-height';
    }

    return $build;
  }

  /**
   * Return an array with the available column proportions.
   */
  protected function getColumnProportions() {
    return [
      '50-50' => '50% - 50%',
      '30-70' => '30% - 70%',
      '40-60' => '40% - 60%',
      '70-30' => '70% - 30%',
      '60-40' => '60% - 40%',
    ];
  }

}
