<?php
namespace Evocative\Elements\Items\IconList;

use Evocative\Elements\Assets;
use Evocative\Elements\Helpers;
use Evocative\Elements\Traits\Animations;
use Evocative\Elements\Traits\ChipStyle;

class Element {
  use Animations, ChipStyle;

  const SLUG = 'evoe_icon_list';

  public function __construct() {
    add_action('vc_before_init', [$this, 'vc_map']);
    add_shortcode(self::SLUG, [$this, 'render']);
  }

  public function vc_map() {
    if (!function_exists('vc_map')) return;
    vc_map([
      'name'=>__('EE • Icon List','evoe'),
      'base'=>self::SLUG,
      'icon'=>'dashicons-list-view',
      'category'=>__('Evocative Elements','evoe'),
      'description'=>__('Liste verticale de “chips” icône+texte','evoe'),
      'params'=>array_merge([
        ['type'=>'param_group','heading'=>__('Lignes','evoe'),'param_name'=>'rows','params'=>[
          ['type'=>'dropdown','heading'=>__('Source icône','evoe'),'param_name'=>'icon_lib','value'=>['FA/Uncode'=>'fa','Dashicons'=>'dash','SVG'=>'svg','Emoji'=>'emoji'],'std'=>'fa'],
          ['type'=>'iconpicker','heading'=>__('Icône (FA)','evoe'),'param_name'=>'icon_fa','settings'=>['emptyIcon'=>false,'iconsPerPage'=>4000,'type'=>'fontawesome'],'dependency'=>['element'=>'icon_lib','value'=>['fa']]],
          ['type'=>'textfield','heading'=>__('Icône Dashicons','evoe'),'param_name'=>'icon_dash','dependency'=>['element'=>'icon_lib','value'=>['dash']]],
          ['type'=>'attach_image','heading'=>__('SVG','evoe'),'param_name'=>'icon_svg','dependency'=>['element'=>'icon_lib','value'=>['svg']]],
          ['type'=>'textfield','heading'=>__('Emoji','evoe'),'param_name'=>'icon_emoji','dependency'=>['element'=>'icon_lib','value'=>['emoji']]],
          ['type'=>'textfield','heading'=>__('Texte','evoe'),'param_name'=>'text','admin_label'=>true],
          ['type'=>'textfield','heading'=>__('Lien (URL)','evoe'),'param_name'=>'url'],
        ]],
        ['type'=>'textfield','heading'=>__('Gap entre lignes (px)','evoe'),'param_name'=>'row_gap','std'=>'8px'],
      ], $this->chip_params(), $this->anim_params()),
    ]);
  }

  public function render($atts) {
    $a = shortcode_atts([
      'rows'=>'','row_gap'=>'8px',
      'style'=>'soft','text_size'=>'','icon_size'=>'18px','color'=>'','bg'=>'','bd'=>'',
      'py'=>'6px','px'=>'12px','radius'=>'9999px','self'=>'start','reverse'=>'',
      'hover'=>'none','anim'=>'none','anim_dur'=>'600','anim_delay'=>'0',
    ], $atts, self::SLUG);

    Assets::enqueue_common(true); // potentiellement dashicons dans les lignes

    $rows = [];
    if (!empty($a['rows'])) $rows = vc_param_group_parse_atts($a['rows']);
    if (!is_array($rows)) $rows = [];

    $out = [];
    foreach ($rows as $r) {
      $icon_html = '';
      $lib = $r['icon_lib'] ?? 'fa';
      if ($lib==='fa' && !empty($r['icon_fa'])) {
        $icon_html = '<i class="'.esc_attr($r['icon_fa']).'" aria-hidden="true"></i>';
      } elseif ($lib==='dash' && !empty($r['icon_dash'])) {
        $icon_html = '<span class="dashicons '.esc_attr($r['icon_dash']).'" aria-hidden="true"></span>';
      } elseif ($lib==='svg' && !empty($r['icon_svg'])) {
        $icon_html = '<span class="evoe-svg" aria-hidden="true">'.\Evocative\Elements\Helpers::inline_svg(intval($r['icon_svg'])).'</span>';
      } elseif ($lib==='emoji' && !empty($r['icon_emoji'])) {
        $icon_html = '<span class="evoe-emoji" role="img" aria-hidden="true">'.esc_html($r['icon_emoji']).'</span>';
      }
      $text = '<span class="evoe-text">'.wp_kses_post($r['text'] ?? '').'</span>';
      $inner = '<span class="evoe-icon">'.$icon_html.'</span><span class="evoe-content">'.$text.'</span>';
      if (!empty($r['url'])) $inner = '<a class="evoe-link" href="'.esc_url($r['url']).'">'.$inner.'</a>';
      $out[] = '<div class="evoe chip chip-'.esc_attr($a['style']).'" style="'.$this->chip_style_vars($a).'">'.$inner.'</div>';
    }

    $wrap_cls = Helpers::join_classes([
      'evoe-list','self-'.($a['self'] ?: 'start'),
      trim($this->anim_classes($a)),
    ]);
    $wrap_style = '--evoe-row-gap:'.esc_attr($a['row_gap']).';';
    $list = '<div class="'.$wrap_cls.'" style="'.$wrap_style.'"'.$this->anim_data($a).'>'.implode('', $out).'</div>';

    // petit style inline pour l’espacement vertical entre chips
    $list .= '<style>.evoe-list>.chip{display:flex;margin-bottom:var(--evoe-row-gap);} .evoe-list>.chip:last-child{margin-bottom:0}</style>';

    return $list;
  }
}
