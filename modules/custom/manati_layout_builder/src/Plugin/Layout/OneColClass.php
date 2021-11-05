<?php

namespace Drupal\manati_layout_builder\Plugin\Layout;

/**
 * OneColClass Section Layout Form class.
 */
class OneColClass extends BaseSectionClass {

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    $build = parent::build($regions);
    $build['#attributes']['class'][] = 'layout--onecol';

    return $build;
  }

}
