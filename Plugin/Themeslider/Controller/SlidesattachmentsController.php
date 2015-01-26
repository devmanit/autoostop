<?php


/**
 * Slidesattachments Controller
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
class SlidesattachmentsController extends ThemesliderAppController {

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	public $uses = array('Themeslider.Slidesattachment');

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
				return $this->Slidesattachment->{$name};
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
				return $this->Slidesattachment->{$name} = $val;
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
		$this->Slidesattachment->unbindModel(array(
			'hasMany' => array('Comment'),
			'hasAndBelongsToMany' => array('Category', 'Tag'))
		);

		$this->Slidesattachment->type = $this->type;
		$this->Slidesattachment->Behaviors->attach('Tree', array(
			'scope' => array(
				$this->Slidesattachment->alias . '.type' => $this->type,
			)
		));
		$this->set('type', $this->Slidesattachment->type);

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
		$this->set('title_for_layout', __d('croogo', 'Slidesattachments'));
		$this->Slidesattachment->recursive = 0;
		$this->paginate['Slidesattachment']['order'] = 'Slidesattachment.created DESC';
                $this->paginate['Slidesattachment']['limit'] = 8;
		$this->set('attachments', $this->paginate('Slidesattachment',
                array('Slidesattachment.showinslider' => 1)));
	}

/**
 * Admin add
 *
 * @return void
 * @access public
 */
	public function admin_add() {
		$this->set('title_for_layout', __d('croogo', 'Add Slidesattachment'));

		if (isset($this->request->params['named']['editor'])) {
			$this->layout = 'admin_popup';
		}

		if ($this->request->is('post') || !empty($this->request->data)) {

			if (empty($this->data['Slidesattachment'])) {
				$this->Slidesattachment->invalidate('file', __d('croogo', 'Upload failed. Please ensure size does not exceed the server limit.'));
				return;
			}
			
			$this->Slidesattachment->create();
			$this->request->data['Slidesattachment'] = array('file' => $this->request->data['Slidesattachment']['file'],'showinslider' => 1);
			
			if ($this->Slidesattachment->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The Slidesattachment has been saved'), 'default', array('class' => 'success'));

				if (isset($this->request->params['named']['editor'])) {
					return $this->redirect(array('action' => 'browse'));
				} else {
					return $this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__d('croogo', 'The Slidesattachment could not be saved. Please, try again.'), 'default', array('class' => 'error'));
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
	public function admin_edit($id = null) {
		$this->set('title_for_layout', __d('croogo', 'Edit Slidesattachment'));

		if (isset($this->request->params['named']['editor'])) {
			$this->layout = 'admin_popup';
		}

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__d('croogo', 'Invalid Slidesattachment'), 'default', array('class' => 'error'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Slidesattachment->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The Slidesattachment has been saved'), 'default', array('class' => 'success'));
				return $this->Croogo->redirect(array('action' => 'edit', $this->Slidesattachment->id));
			} else {
				$this->Session->setFlash(__d('croogo', 'The Slidesattachment could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Slidesattachment->read(null, $id);
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
			$this->Session->setFlash(__d('croogo', 'Invalid id for Slidesattachment'), 'default', array('class' => 'error'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Slidesattachment->delete($id)) {
			$this->Session->setFlash(__d('croogo', 'Slidesattachment deleted'), 'default', array('class' => 'success'));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__d('croogo', 'Invalid id for Slidesattachment'), 'default', array('class' => 'error'));
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
