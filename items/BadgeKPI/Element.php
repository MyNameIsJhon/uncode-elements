<?php
namespace Evocative\Elements\Items\BadgeKPI;

use Evocative\Elements\Assets;
use Evocative\Elements\Helpers;
use Evocative\Elements\Traits\Animations;
use Evocative\Elements\Traits\ChipStyle;

class Element {
  use Animations, ChipStyle;

  const SLUG = 'evoe_badge_kpi';

  public function __construct() {
    add_action('vc_before_init', [$this, 'vc_map']);
    add_shortcode(self::SLUG, [$this, 'render']);
  }

  public function vc_map() {
    if (!function_exists('vc_map')) return;
    vc_map([
      'name'=>__('EE • Badge KPI','evoe'),
      'base'=>self::SLUG,
      'icon'=>'dashicons-chart-pie',
      'category'=>__('Evocative Elements','evoe'),
      'description'=>__('KPI (valeur + label) avec icône','evoe'),
      'params'=>array_merge([
        ['type'=>'dropdown','heading'=>__('Source icône','evoe'),'param_name'=>'icon_lib','value'=>['FA/Uncode'=>'fa','Dashicons'=>'dash','SVG'=>'svg','Emoji'=>'emoji'],'std'=>'fa'],
        ['type'=>'iconpicker','heading'=>__('Icône (FA)','evoe'),'param_name'=>'icon_fa','settings'=>['emptyIcon'=>false,'iconsPerPage'=>4000,'type'=>'fontawesome'],'dependency'=>['element'=>'icon_lib','value'=>['fa']]],
        ['type'=>'textfield','heading'=>__('Dashicon','evoe'),'param_name'=>'icon_dash','dependency'=>['element'=>'icon_lib','value'=>['dash']]],
        ['type'=>'attach_image','heading'=>__('SVG','evoe'),'param_name'=>'icon_svg','dependency'=>['element'=>'icon_lib','value'=>['svg']]],
        ['type'=>'textfield','heading'=>__('Emoji','evoe'),'param_name'=>'icon_emoji','dependency'=>['element'=>'icon_lib','value'=>['emoji']]],

        ['type'=>'textfield','heading'=>__('Valeur (ex: 120%)','evoe'),'param_name'=>'value','admin_label'=>true],
        ['type'=>'textfield','heading'=>__('Label (ex: Growth)','evoe'),'param_name'=>'label'],
        ['type'=>'vc_link','heading'=>__('Lien','evoe'),'param_name'=>'link'],
        ['type'=>'dropdown','heading'=>__('Hover','evoe'),'param_name'=>'hover','value'=>['Aucun'=>'none','Lift'=>'lift','Pulse'=>'pulse','Rotate'=>'h-rotate'],'std'=>'none'],
        ['type'=>'textfield','heading'=>__('Classe CSS','evoe'),'param_name'=>'el_class'],
      ], $this->chip_params(), $this->anim_params()),
    ]);
  }

  public function render($atts) {
    $a = shortcode_atts([
      'icon_lib'=>'fa','icon_fa'=>'','icon_dash'=>'','icon_svg'=>'','icon_emoji'=>'',
      'value'=>'','label'=>'','link'=>'','hover'=>'none','el_class'=>'',
      'style'=>'soft','text_size'=>'','icon_size'=>'18px','color'=>'','bg'=>'','bd'=>'',
      'py'=>'6px','px'=>'12px','radius'=>'9999px','self'=>'start','reverse'=>'',
      'anim'=>'none','anim_dur'=>'600','anim_delay'=>'0',
    ], $atts, self::SLUG);

    Assets::enqueue_common($a['icon_lib'] === 'dash');
    list($href,$target,$rel) = Helpers::build_link($a['link']);

    $icon_html = '';
    if ($a['icon_lib']==='fa' && $a['icon_fa'])       $icon_html = '<i class="'.esc_attr($a['icon_fa']).'" aria-hidden="true"></i>';
    elseif ($a['icon_lib']==='dash' && $a['icon_dash']) $icon_html = '<span class="dashicons '.esc_attr($a['icon_dash']).'" aria-hidden="true"></span>';
    elseif ($a['icon_lib']==='svg' && $a['icon_svg'])   $icon_html = '<span class="evoe-svg" aria-hidden="true">'.\Evocative\Elements\Helpers::inline_svg(intval($a['icon_svg'])).'</span>';
    elseif ($a['icon_lib']==='emoji' && $a['icon_emoji']) $icon_html = '<span class="evoe-emoji" role="img" aria-hidden="true">'.esc_html($a['icon_emoji']).'</span>';

    $value = '<strong class="evoe-text">'.wp_kses_post($a['value']).'</strong>';
    $label = $a['label'] ? '<span class="evoe-text">'.wp_kses_post($a['label']).'</span>' : '';

    $cls = Helpers::join_classes([
      'evoe','chip','chip-'.($a['style'] ?: 'soft'),
      'self-'.($a['self'] ?: 'start'),
      $a['reverse'] ? 'is-reverse' : '',
      $a['hover'] && $a['hover']!=='none' ? 'hover-'.$a['hover'] : '',
      trim($this->anim_classes($a)),
      $a['el_class'] ?: '',
    ]);
    $style = $this->chip_style_vars($a);

    $inner = '<span class="evoe-icon">'.$icon_html.'</span><span class="evoe-content">'.$value.' '.$label.'</span>';
    if ($href) $inner = '<a class="evoe-link" href="'.$href.'"'.$target.$rel.'>'.$inner.'</a>';

    return '<div class="'.$cls.'" style="'.$style.'"'.$this->anim_data($a).'>'.$inner.'</div>';
  }
}
