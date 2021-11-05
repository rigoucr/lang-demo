<?php

namespace Drupal\manati_custom_ui\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Coopeande Blocks settings for this site.
 */
class FrontendSiteSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'manati_frontend_site_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['manati_custom_ui.frontend_site.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['general'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Configuración general'),
    ];
    $form['general']['site_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('URL del sitio público'),
      '#required' => TRUE,
      '#default_value' => $this->config('manati_custom_ui.frontend_site.settings')->get('site_url'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('manati_custom_ui.frontend_site.settings')
      ->set('site_url', $form_state->getValue('site_url'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
