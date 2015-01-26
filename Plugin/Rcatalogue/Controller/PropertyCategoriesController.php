<?php
App::uses('RcatalogueAppController', 'Rcatalogue.Controller');
/**
 * PropertyCategories Controller
 *
 * @property PropertyCategory $PropertyCategory
 * @property PaginatorComponent $Paginator
 */
class PropertyCategoriesController extends RcatalogueAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PropertyCategory->recursive = 0;
		$this->set('propertyCategories', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PropertyCategory->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid property category'));
		}
		$options = array('conditions' => array('PropertyCategory.' . $this->PropertyCategory->primaryKey => $id));
		$this->set('propertyCategory', $this->PropertyCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PropertyCategory->create();
			if ($this->PropertyCategory->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The property category has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The property category could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$parentPropertyCategories = $this->PropertyCategory->ParentPropertyCategory->find('list');
		$this->set(compact('parentPropertyCategories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PropertyCategory->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid property category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PropertyCategory->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The property category has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The property category could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('PropertyCategory.' . $this->PropertyCategory->primaryKey => $id));
			$this->request->data = $this->PropertyCategory->find('first', $options);
		}
		$parentPropertyCategories = $this->PropertyCategory->ParentPropertyCategory->find('list');
		$this->set(compact('parentPropertyCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PropertyCategory->id = $id;
		if (!$this->PropertyCategory->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid property category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PropertyCategory->delete()) {
			$this->Session->setFlash(__d('croogo', 'Property category deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Property category was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->PropertyCategory->recursive = 0;
		$this->set('propertyCategories', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->PropertyCategory->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid property category'));
		}
		$options = array('conditions' => array('PropertyCategory.' . $this->PropertyCategory->primaryKey => $id));
		$this->set('propertyCategory', $this->PropertyCategory->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->PropertyCategory->create();
			if ($this->PropertyCategory->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The property category has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The property category could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$parentPropertyCategories = $this->PropertyCategory->ParentPropertyCategory->find('list');
		$this->set(compact('parentPropertyCategories'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->PropertyCategory->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid property category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PropertyCategory->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The property category has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The property category could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('PropertyCategory.' . $this->PropertyCategory->primaryKey => $id));
			$this->request->data = $this->PropertyCategory->find('first', $options);
		}
		$parentPropertyCategories = $this->PropertyCategory->ParentPropertyCategory->find('list');
		$this->set(compact('parentPropertyCategories'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->PropertyCategory->id = $id;
		if (!$this->PropertyCategory->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid property category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PropertyCategory->delete()) {
			$this->Session->setFlash(__d('croogo', 'Property category deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Property category was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
