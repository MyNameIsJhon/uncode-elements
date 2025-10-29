<?php
namespace Evocative\Elements;

class Helpers {
  public static function inline_svg($attachment_id) {
    $path = get_attached_file($attachment_id);
    if (!$path || !file_exists($path)) return '';
    if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'svg') return '';
    $svg = file_get_contents($path);
    return preg_replace('#<script[^>]*>.*?</script>#is', '', $svg); // sanit minimal
  }

  public static function build_link($vc_link) {
    $href = $target = $rel = '';
    if (function_exists('vc_build_link')) {
      $o = vc_build_link($vc_link);
      if (!empty($o['url']))    $href = esc_url($o['url']);
      if (!empty($o['target'])) $target = ' target="'.esc_attr($o['target']).'"';
      if (!empty($o['rel']))    $rel    = ' rel="'.esc_attr($o['rel']).'"';
    }
    return [$href, $target, $rel];
  }

  public static function join_classes($arr) {
    $out = [];
    foreach ($arr as $c) {
      if (!empty($c)) $out[] = sanitize_html_class($c);
    }
    return implode(' ', $out);
  }

  public static function is_allowed_tag($tag) {
    return in_array($tag, ['div','p','h1','h2','h3','h4','h5','h6'], true) ? $tag : 'p';
  }
}
