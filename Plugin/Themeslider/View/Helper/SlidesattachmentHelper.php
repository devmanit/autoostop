<?php

App::uses('AppHelper', 'View/Helper');

/**
 * FileManager Helper
 *
 * @category Helper
 * @package  Croogo.FileManager.View.Helper
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */

class SlidesattachmentHelper extends AppHelper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
	public $helpers = array('Html', 'Form');

        public function addSlides($slides)
        {
            $output='';
            $thumbslides='';
            foreach ($slides as $index => $Node) {
                if ($Node['Slidesattachment']['custom_url']!=null)
                {
                    $url = $Node['Slidesattachment']['custom_url'];
                }
                else
                {
                    $url = '#';
                }
                $url_h2 = $this->Html->link($Node['Slidesattachment']['title'],
                                $url,array('escape' => false));
                
                $content = "<li>".
                              $this->Html->image($Node['Slidesattachment']['path'], array('alt' => '','url'=>$url)).
                              "<div class='ei-title'>".
                                  "<h2>".$url_h2."</h2>".
                                  "<h3>".$Node['Slidesattachment']['body']."</h3>".
                              "</div>
                            </li>";
                $output .= $content;
                
                $thumbslides .= "<li>".
                                $this->Html->image($Node['Slidesattachment']['path'], array('alt' => '','class' => 'attachment-tie-medium')).
                               "</li>";
                
            }
            $slidesarray['slides']=$output;
            $slidesarray['thumbs']=$thumbslides;
            return $slidesarray;
        }
}
