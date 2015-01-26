<?php
App::uses('Html', 'View/Helper');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP PropertyHelper
 * @author Ayoub
 */
class PdfComponent extends Component {

    public $controller = false;
    public $components = array('RequestHandler');

    public function __construct(ComponentCollection $collection, $setting) {
        $this->controller = $collection->getController();
    }

    public function renderPdf($data) {
        
        $output = '';
        
        return $output;
    }

}
