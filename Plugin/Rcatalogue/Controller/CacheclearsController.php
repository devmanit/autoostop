<?php
App::uses('RcatalogueAppController', 'Rcatalogue.Controller');
App::uses('FileManagerAppController', 'FileManager.Controller');
/**
 * Properties Controller
 *
 * @property Property $Property
 * @property PaginatorComponent $Paginator
 */
class CacheclearsController extends RcatalogueAppController {

/**
 * Components
 *
 * @var array
 */
      
	public $components = array('Paginator','Security','RequestHandler');
        public $uses = array('Rcatalogue.Property','Rcatalogue.PropertyCategory',
            'Rcatalogue.PropertyAddress','Rcatalogue.Rcatalogueattachment',
            'Contacts.Contact','Contacts.Message','Rcatalogue.Specification','Menus.Link');
       
       public function admin_index()
       {
           clearCache();Cache::delete('cake_model_');
           $this->redirect(array('controller' => 'properties','action' => 'index'));
       }
        
       
}
