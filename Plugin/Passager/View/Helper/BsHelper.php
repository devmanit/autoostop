<?php

App::uses('Helper', 'View/Helper');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BsHelper extends AppHelper {

	public $helpers = array('Html');
          var $name = 'Bs';
          /**
* Create a Bootstrap Modal
* @param string $id the modal id
* @param string $header the text in the header
* @param string $body the content of the body
* @param array $buttons informations about open, close and save buttons
* @param array $options
* @return string
*/
public function modal($header, $body, $options = array(), $buttons = array()){

	$classes = (isset($options['class'])) ? $options['class'] : '';
	// Is it a form ?
	$form = (isset($options['form']) && $options['form'] == true) ? true : false;
	// If it's a form then there is a submit button
	$type = ($form) ? 'submit' : 'button';

	// Generate a random id if it doesn't exist
	if (isset($options['id'])) {
		$id = $options['id'];
	}else{
		$alphabet = str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		$id = '';
		for($i=0;$i=10;$i++){
                $id .= $alphabet[rand(5,45)];
                
                }
	}

	// Button
		if (!empty($buttons)) {
			if (isset($buttons['open'])  && $buttons['open'] != '') {
				if (is_array(($buttons['open']))){
					$out = $this->btn(__($buttons['open']['name']), null , array('tag' => 'button', 'class' => $buttons['open']['class'], 'data-toggle' => 'modal', 'data-target' => '#'.$id));
				}else{
					$out = $this->btn(__($buttons['open']), null , array('tag' => 'button', 'class' => 'btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#'.$id));
				}
			}else{
				$out = $this->btn(__('Voir'), null , array('tag' => 'button', 'class' => 'btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#'.$id));
			}
		}else{
			$out = $this->btn(__('Voir'), null , array('tag' => 'button', 'class' => 'btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#'.$id));
		}

	// Modal
		$out .= '<div class="modal fade '.$classes.'" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'Label" aria-hidden="true">'.BL;
		$out .= '<div class="modal-dialog">'.BL;

		// Content
			$out .= '<div class="modal-content">'.BL;

			if ($form) {
				$close = strpos($body, '>');
				$out .= substr($body, strpos($body, '<form'), $close+1).BL;
				$body = substr($body, $close+1, strpos($body, '</form>')-($close+1));
			}

			// Header
				$out .= '<div class="modal-header">'.BL;
				$out .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.BL;
				$out .= '<h4 class="modal-title" id="'.$id.'Label">'.$header.'</h4>'.BL;
				$out .= '</div>'.BL;
			// End header

			// Body
				$out .= '<div class="modal-body">'.BL;
				$out .= $body.BL;
				$out .= '</div>'.BL;
			// End body

			// Footer
				$out_footer = '';
				if (!empty($buttons)) {
					if (isset($buttons['close'])) {

						// If the value of 'close' is an array (like 'close' => array('name' => 'Close') )
						if (is_array(($buttons['close']))){
							$out_footer .= $this->btn(__($buttons['close']['name']), null , array('tag' => 'button', 'class' => $buttons['close']['class'], 'data-dismiss' => 'modal'));
					}else{
						$out_footer .= $this->btn(__($buttons['close']), null , array('tag' => 'button', 'class' => 'btn-link', 'data-dismiss' => 'modal'));
					}

				        // If 'close' index exist => create the button
				        }elseif(in_array('close', $buttons)){
						$out_footer .= $this->btn(__('Fermer'), null , array('tag' => 'button', 'class' => 'btn-link', 'data-dismiss' => 'modal'));
					}
					if (isset($buttons['confirm'])) {

						// Check if it's a form
							if ($form) {
							$class = (isset($buttons['confirm']['class'])) ? $buttons['confirm']['class'] : 'btn-success';
							$out_footer .= $this->btn(__($buttons['confirm']['name']), null , array('tag' => 'button', 'class' => $class, 'type' => $type));
						}else{
							$class = (isset($buttons['confirm']['class'])) ? $buttons['confirm']['class'] : 'btn-success';
							$out_footer .= $this->btn(__($buttons['confirm']['name']), $buttons['confirm']['link'] , array('class' => $class));
						}

					// If 'confirm' index exist => create the button
					}elseif(in_array('confirm', $buttons)){
						$out_footer .= $this->btn(__('Confirmer'), null , array('tag' => 'button', 'class' => 'btn-success', 'type' => $type));
					}

					if ($out_footer != '') {
						$out .= '<div class="modal-footer">'.BL;
						$out .= $out_footer.BL;
						$out .= '</div>'.BL;	
					}
				}
				$out .=  ($form) ? '</form>'.BL : '';
			// End footer

			$out .= '</div>'.BL;
		// End Content

		$out .= '</div>'.BL;
		$out .= '</div>'.BL;
				       
	return $out;
}

}