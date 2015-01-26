<?php

App::uses('FileManagerAppController', 'FileManager.Controller');

/**
 * Rcatalogueattachments Controller
 *
 * This file will take care of file uploads (with rich text editor integration).
 *
 * @category FileManager.Controller
 * @package  Croogo.FileManager.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class RcatalogueattachmentsController extends RcatalogueAppController {

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	public $uses = array('Rcatalogue.Rcatalogueattachment','Rcatalogue.Property','Nodes.Node');
        

/**
 * Helpers used by the Controller
 *
 * @var array
 * @access public
 */
	

/**
 * Provides backwards compatibility access to the deprecated properties
 */
	public function __get($name) {
		switch ($name) {
			case 'type':
			case 'uploadsDir':
				return $this->Rcatalogueattachment->{$name};
			break;
			default:
				return parent::__get($name);
		}
	}

/**
 * Provides backwards compatibility access for settings values to deprecated
 * properties
 */
	public function __set($name, $val) {
		switch ($name) {
			case 'type':
			case 'uploadsDir':
				return $this->Rcatalogueattachment->{$name} = $val;
			break;
			default:
				return parent::__set($name, $val);
		}
	}

/**
 * Before executing controller actions
 *
 * @return void
 * @access public
 */
	public function beforeFilter() {
		parent::beforeFilter();

		// Comment, Category, Tag not needed
		$this->Rcatalogueattachment->unbindModel(array(
			'hasMany' => array('Comment'),
			'hasAndBelongsToMany' => array('Category', 'Tag'))
		);

		$this->Rcatalogueattachment->type = $this->type;
		$this->Rcatalogueattachment->Behaviors->attach('Tree', array(
			'scope' => array(
				$this->Rcatalogueattachment->alias . '.type' => $this->type,
			)
		));
		$this->set('type', $this->Rcatalogueattachment->type);

		if ($this->action == 'admin_add') {
			$this->Security->csrfCheck = false;
		}
	}



/**
 * Admin index
 *
 * @return void
 * @access public
 */
	public function admin_index() {
		$this->set('title_for_layout', __d('croogo', 'Rcatalogueattachments'));
		$this->Rcatalogueattachment->recursive = 0;
		$this->paginate['Rcatalogueattachment']['order'] = 'Rcatalogueattachment.created DESC';
                $this->paginate['Rcatalogueattachment']['limit'] = 8;
		$this->set('attachments', $this->paginate('Rcatalogueattachment',
                array('Rcatalogueattachment.showinslider' => 1)));
	}

/**
 * Admin add
 *
 * @return void
 * @access public
 */
	public function admin_add($edit = null) {
		$this->set('title_for_layout', __d('croogo', 'Add Rcatalogueattachment'));
                
		if (isset($this->request->params['named']['editor'])) {
			$this->layout = 'admin_popup';
		}
                
                $this->request->data['edit']=$edit;
                
		if ($this->request->is('post') || sizeof($this->request->data)>1) {

			if (empty($this->data['Rcatalogueattachment'])) {
				$this->Rcatalogueattachment->invalidate('file', __d('croogo', 'Upload failed. Please ensure size does not exceed the server limit.'));
				return;
			}
			
			$this->Rcatalogueattachment->create();
			$this->request->data['Rcatalogueattachment'] = array('file' => $this->request->data['Rcatalogueattachment']['file'],
                            'showinslider' => 0,'property_id' => $edit);
			
                        
			if ($this->Rcatalogueattachment->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The Rcatalogueattachment has been saved'), 'default', array('class' => 'success'));
                                
				return $this->redirect(array('controller' => 'properties','action' => 'edit',$edit,'1',$this->Rcatalogueattachment->id));
			} else {
				$this->Session->setFlash(__d('croogo', 'The Rcatalogueattachment could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * Admin edit
 *
 * @param int $id
 * @return void
 * @access public
 */
	public function admin_edit($id = null,$data_updated = null) {
                
		$this->set('title_for_layout', __d('croogo', 'Edit Rcatalogueattachment'));

		if (isset($this->request->params['named']['editor'])) {
			$this->layout = 'admin_popup';
		}

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__d('croogo', 'Invalid Rcatalogueattachment'), 'default', array('class' => 'error'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
                    
			if ($this->Rcatalogueattachment->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The Rcatalogueattachment has been saved'), 'default', array('class' => 'success'));
				return $this->Croogo->redirect(array('action' => 'edit', $this->Rcatalogueattachment->id));
			} else {
				$this->Session->setFlash(__d('croogo', 'The Rcatalogueattachment could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
                else if (!empty($data_updated)) {
                    
                if ($this->Rcatalogueattachment->save($data_updated)) {
				$this->Session->setFlash(__d('croogo', 'The Rcatalogueattachment has been saved'), 'default', array('class' => 'success'));
				return $this->Croogo->redirect(array('action' => 'edit', $this->Rcatalogueattachment->id));
			} else {
				$this->Session->setFlash(__d('croogo', 'The Rcatalogueattachment could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
                }
		if (empty($this->request->data)) {
			$this->request->data = $this->Rcatalogueattachment->read(null, $id);
		}
	}

        
        
        
        
        public function admin_moveup($id=null, $step = 1) {
            
            if (!$id) {
			$this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment 3'), 'default', array('class' => 'error'));
			return $this->redirect(array('action' => 'index'));
		}

       
		if ($this->Rcatalogueattachment->moveUp($id, $step)) {
			$this->Session->setFlash(__d('croogo', 'Moved up successfully'), 'default', array('class' => 'success'));
                        return $this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__d('croogo', 'Could not move up'), 'default', array('class' => 'error'));
                        return $this->redirect(array('action' => 'index'));
		}

		
	}

        
        
/**
 * Admin delete
 *
 * @param int $id
 * @return void
 * @access public
 */
	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Rcatalogueattachment->delete($id)) {
			$this->Session->setFlash(__d('croogo', 'Rcatalogueattachment deleted'), 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
			return $this->redirect(array('action' => 'index'));
		}
	}

/**
 * Admin browse
 *
 * @return void
 * @access public
 */
	public function admin_browse() {
		$this->layout = 'admin_popup';
		$this->admin_index();
	}
        
        

}
