<?php
namespace Evocative\Elements\Traits;

trait ChipStyle {
  protected function chip_params() {
    return [
      ['type'=>'dropdown','heading'=>__('Style','evoe'),'param_name'=>'style','value'=>['Soft'=>'soft','Outline'=>'outline','Solid'=>'solid'],'std'=>'soft'],
      ['type'=>'textfield','heading'=>__('Taille texte','evoe'),'param_name'=>'text_size','description'=>__('px/rem/em','evoe')],
      ['type'=>'textfield','heading'=>__('Taille icône','evoe'),'param_name'=>'icon_size','std'=>'18px'],
      ['type'=>'colorpicker','heading'=>__('Couleur texte','evoe'),'param_name'=>'color'],
      ['type'=>'colorpicker','heading'=>__('Couleur fond','evoe'),'param_name'=>'bg'],
      ['type'=>'colorpicker','heading'=>__('Couleur bordure','evoe'),'param_name'=>'bd'],
      ['type'=>'textfield','heading'=>__('Padding Y','evoe'),'param_name'=>'py','std'=>'6px'],
      ['type'=>'textfield','heading'=>__('Padding X','evoe'),'param_name'=>'px','std'=>'12px'],
      ['type'=>'textfield','heading'=>__('Rayon','evoe'),'param_name'=>'radius','std'=>'9999px'],
      ['type'=>'dropdown','heading'=>__('Alignement colonne','evoe'),'param_name'=>'self','value'=>['Début'=>'start','Centre'=>'center','Fin'=>'end','Étendre'=>'stretch'],'std'=>'start'],
      ['type'=>'dropdown','heading'=>__('Icône à droite','evoe'),'param_name'=>'reverse','value'=>['Non'=>'','Oui'=>'yes'],'std'=>''],
    ];
  }

  protected function chip_style_vars($a) {
    $s = '';
    if (!empty($a['color']))     $s .= '--es-text-color:'.$a['color'].';';
    if (!empty($a['text_size'])) $s .= '--es-text-size:'.$a['text_size'].';';
    if (!empty($a['icon_size'])) $s .= '--es-icon-size:'.$a['icon_size'].';';
    if (!empty($a['bg']))        $s .= '--es-bg:'.$a['bg'].';';
    if (!empty($a['bd']))        $s .= '--es-bd:'.$a['bd'].';';
    $s .= '--es-py:'.($a['py'] ?? '6px').';--es-px:'.($a['px'] ?? '12px').';';
    $s .= '--es-radius:'.($a['radius'] ?? '9999px').';';
    return $s;
  }

  protected function chip_classes($a) {
    $c = ['evoe','chip','chip-'.($a['style'] ?? 'soft'),'self-'.($a['self'] ?? 'start')];
    if (!empty($a['reverse'])) $c[] = 'is-reverse';
    return ' ' . implode(' ', array_map('sanitize_html_class', $c));
  }
}
