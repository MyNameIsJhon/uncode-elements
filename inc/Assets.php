<?php
namespace Evocative\Elements;

class Assets {
  public static function register() {
    add_action('init', function(){
      wp_register_style('evoe-elements', EVOE_URL . 'assets/css/elements.css', [], EVOE_VER);
      wp_register_script('evoe-elements', EVOE_URL . 'assets/js/elements.js', [], EVOE_VER, true);
      if (!is_admin()) {
        wp_register_style('evoe-dashicons-front', includes_url('css/dashicons.min.css'), [], null);
      }
    });
  }

  public static function enqueue_common($need_dashicons = false) {
    wp_enqueue_style('evoe-elements');
    wp_enqueue_script('evoe-elements');
    if ($need_dashicons) wp_enqueue_style('evoe-dashicons-front');
  }
}
