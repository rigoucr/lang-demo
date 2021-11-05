<?php

namespace Drupal\manati_layout_builder\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Base Section Layout Form class.
 */
class BaseSectionClass extends LayoutDefault implements PluginFormInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $backgrounds = array_keys($this->getBackgrounds());
    $spacing_top = array_keys($this->getSpacing());
    $spacing_bottom = array_keys($this->getSpacing());
    return parent::defaultConfiguration() + [
      'background' => array_shift($backgrounds),
      'spacing_top' => array_shift($spacing_top),
      'spacing_bottom' => array_shift($spacing_bottom),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['background'] = [
      '#type' => 'select',
      '#title' => $this->t('Color de fondo'),
      '#default_value' => $this->configuration['background'],
      '#options' => $this->getBackgrounds(),
      '#description' => $this->t('Elija el color de fondo para esta sección.'),
    ];
    $form['spacing_top'] = [
      '#type' => 'select',
      '#title' => $this->t('Espacio superior'),
      '#default_value' => $this->configuration['spacing_top'],
      '#options' => $this->getSpacing(),
      '#description' => $this->t('Elija el tamaño del espacio superior de esta sección.'),
    ];
    $form['spacing_bottom'] = [
      '#type' => 'select',
      '#title' => $this->t('Espacio inferior'),
      '#default_value' => $this->configuration['spacing_bottom'],
      '#options' => $this->getSpacing(),
      '#description' => $this->t('Elija el tamaño del espacio inferior de esta sección.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['background'] = $form_state->getValue('background');
    $this->configuration['spacing_top'] = $form_state->getValue('spacing_top');
    $this->configuration['spacing_bottom'] = $form_state->getValue('spacing_bottom');
    $this->configuration['side_spacing'] = $form_state->getValue('side_spacing');
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    $build = parent::build($regions);
    $build['#attributes']['class'] = [
      'layout',
      'layout--fixed-width',
      isset($this->configuration['background']) ? 'layout--background-' . $this->configuration['background'] : 'layout--background-transparent',
      'layout--spacing-top-' . $this->configuration['spacing_top'],
      'layout--spacing-bottom-' . $this->configuration['spacing_bottom'],
    ];

    return $build;
  }

  /**
   * Return an array with the available background colors.
   */
  protected function getBackgrounds() {
    return [
      'white' => $this->t('Blanco'),
      'gray-extra-light' => $this->t('Gris claro'),
      'bone' => $this->t('Hueso'),
      'blue-light-pastel' => $this->t('Celeste pastel'),
      'gradient-petrols' => $this->t('Gradiente petrols'),
      'gradient-pastel' => $this->t('Gradiente cielo'),
      'gradient-blueWhite' => $this->t('Gradiente azul-blanco'),
    ];
  }

  /**
   * Return an array with the available spacing options.
   */
  protected function getSpacing() {
    return [
      'none' => $this->t('Ninguno'),
      'small' => $this->t('Pequeño'),
      'medium' => $this->t('Mediano'),
      'large' => $this->t('Grande'),
    ];
  }

}
