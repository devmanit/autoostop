<?php
App::uses('RcatalogueAppController', 'Rcatalogue.Controller');
/**
 * Specifications Controller
 *
 * @property Specification $Specification
 * @property PaginatorComponent $Paginator
 */
class SpecificationsController extends RcatalogueAppController {

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
		$this->Specification->recursive = 0;
		$this->set('specifications', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Specification->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid specification'));
		}
		$options = array('conditions' => array('Specification.' . $this->Specification->primaryKey => $id));
		$this->set('specification', $this->Specification->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Specification->create();
			if ($this->Specification->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The specification has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The specification could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Specification->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid specification'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Specification->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The specification has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The specification could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Specification.' . $this->Specification->primaryKey => $id));
			$this->request->data = $this->Specification->find('first', $options);
		}
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
		$this->Specification->id = $id;
		if (!$this->Specification->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid specification'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Specification->delete()) {
			$this->Session->setFlash(__d('croogo', 'Specification deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Specification was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Specification->recursive = 0;
		$this->set('specifications', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Specification->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid specification'));
		}
		$options = array('conditions' => array('Specification.' . $this->Specification->primaryKey => $id));
		$this->set('specification', $this->Specification->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Specification->create();
			if ($this->Specification->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The specification has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The specification could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Specification->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid specification'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Specification->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The specification has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The specification could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Specification.' . $this->Specification->primaryKey => $id));
			$this->request->data = $this->Specification->find('first', $options);
		}
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
		$this->Specification->id = $id;
		if (!$this->Specification->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid specification'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Specification->delete()) {
			$this->Session->setFlash(__d('croogo', 'Specification deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Specification was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
