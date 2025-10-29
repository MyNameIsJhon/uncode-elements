<?php
namespace Evocative\Elements;

class Registry {
  // Liste des items à charger (ajoute simplement ta classe ici)
  protected static $items = [
    '\\Evocative\\Elements\\Items\\IconText\\Element',
    '\\Evocative\\Elements\\Items\\IconList\\Element',
    '\\Evocative\\Elements\\Items\\BadgeKPI\\Element',
  ];

  public static function register_all() {
    // Sécurité : WPBakery nécessaire
    if (!function_exists('vc_map')) return;

    foreach (self::$items as $class) {
      if (class_exists($class)) {
        new $class(); // chaque item s’enregistre tout seul (vc_map + shortcode)
      }
    }
  }
}
