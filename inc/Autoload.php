<?php
namespace Evocative\Elements;

class Autoload {
  public static function init() {
    spl_autoload_register(function($class){
      $prefix = __NAMESPACE__ . '\\';
      $len = strlen($prefix);
      if (strncmp($prefix, $class, $len) !== 0) return;
      $rel = substr($class, $len); // ex: "Assets" ou "Items\IconText\Element"
      $rel = str_replace('\\', DIRECTORY_SEPARATOR, $rel);
      $file = EVOE_BASE . 'inc/' . $rel . '.php';
      // fallback: items namespace
      if (!file_exists($file)) {
        $file = EVOE_BASE . 'items/' . $rel . '.php';
      }
      if (file_exists($file)) require_once $file;
    });
  }
}
