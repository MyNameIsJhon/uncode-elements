<?php
namespace Evocative\Elements\Traits;

trait Animations {
  protected function anim_params() {
    return [
      [
        'type'=>'dropdown','heading'=>__('Animation au scroll','evoe'),'param_name'=>'anim',
        'value'=>['Aucune'=>'none','Fade in'=>'fade','Slide up'=>'slide-up','Slide left'=>'slide-left','Slide right'=>'slide-right','Zoom in'=>'zoom','Rotate in'=>'rotate'],
        'std'=>'none'
      ],
      ['type'=>'textfield','heading'=>__('Durée (ms)','evoe'),'param_name'=>'anim_dur','std'=>'600','dependency'=>['element'=>'anim','value_not_equal_to'=>['none']]],
      ['type'=>'textfield','heading'=>__('Délai (ms)','evoe'),'param_name'=>'anim_delay','std'=>'0','dependency'=>['element'=>'anim','value_not_equal_to'=>['none']]],
    ];
  }

  protected function anim_classes($a) {
    return ($a['anim'] ?? 'none') !== 'none' ? ' es-anim es-anim-'.sanitize_html_class($a['anim']) : '';
  }

  protected function anim_data($a) {
    if (($a['anim'] ?? 'none') === 'none') return '';
    $dur = intval($a['anim_dur'] ?? 600);
    $del = intval($a['anim_delay'] ?? 0);
    return ' data-es-dur="'.$dur.'" data-es-delay="'.$del.'"';
  }
}
