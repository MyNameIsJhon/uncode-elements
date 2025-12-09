<?php
namespace Evocative\Elements;

class Assets {
  public static function enqueue_common($need_dashicons = false) {
    wp_enqueue_style('evoe-elements');
    wp_enqueue_script('evoe-elements');
    if ($need_dashicons) wp_enqueue_style('evoe-dashicons-front');
  }
}
