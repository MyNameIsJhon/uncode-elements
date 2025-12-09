<?php
/**
 * Plugin Name: Evocative Elements (Uncode/WPBakery)
 * Description: Pack d’éléments personnalisés (Icon Text, Icon List, Badge KPI…) pour Uncode (WPBakery) avec animations & styles unifiés.
 * Author: Evocative Studio
 * Version: 2.0.0
 * License: GPL-2.0-or-later
 */

if (!defined('ABSPATH')) exit;

define('EVOE_BASE', plugin_dir_path(__FILE__));
define('EVOE_URL',  plugin_dir_url(__FILE__));
define('EVOE_VER',  '2.0.0');

require_once EVOE_BASE . 'inc/Autoload.php';
Evocative\Elements\Autoload::init();

add_action('vc_before_init', function () {
  // assets communs
  Evocative\Elements\Assets::register();
  // enregistre tous les items
  Evocative\Elements\Registry::register_all();
});
