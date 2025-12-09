<?php
/**
 * Plugin Name: Evocative Elements (Uncode/WPBakery)
 * Description: Pack d'éléments personnalisés (Icon Text, Icon List, Badge KPI…) pour Uncode (WPBakery) avec animations & styles unifiés.
 * Author: Evocative Studio
 * Version: 2.0.0
 * License: GPL-2.0-or-later
 * Text Domain: evoe
 */

if (!defined('ABSPATH')) exit;

define('EVOE_BASE', plugin_dir_path(__FILE__));
define('EVOE_URL',  plugin_dir_url(__FILE__));
define('EVOE_VER',  '2.0.0');

// Charger les traductions
add_action('plugins_loaded', 'evoe_load_textdomain');
function evoe_load_textdomain() {
  load_plugin_textdomain('evoe', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

// Vérifier que WPBakery est activé
add_action('admin_notices', 'evoe_check_dependencies');
function evoe_check_dependencies() {
  if (!defined('WPB_VC_VERSION')) {
    echo '<div class="notice notice-error"><p><strong>Evocative Elements:</strong> Ce plugin nécessite WPBakery Page Builder pour fonctionner.</p></div>';
  }
}

// Initialiser l'autoloader
require_once EVOE_BASE . 'inc/Autoload.php';
Evocative\Elements\Autoload::init();

// Enregistrer les assets
add_action('init', 'evoe_register_assets');
function evoe_register_assets() {
  wp_register_style('evoe-elements', EVOE_URL . 'assets/css/elements.css', [], EVOE_VER);
  wp_register_script('evoe-elements', EVOE_URL . 'assets/js/elements.js', [], EVOE_VER, true);
  if (!is_admin()) {
    wp_register_style('evoe-dashicons-front', includes_url('css/dashicons.min.css'), [], null);
  }
}

// Enregistrer les éléments WPBakery
add_action('vc_before_init', 'evoe_register_elements');
function evoe_register_elements() {
  if (!function_exists('vc_map')) return;

  Evocative\Elements\Registry::register_all();
}
