<?php
App::uses('RcatalogueAppController', 'Rcatalogue.Controller');
/**
 * Cars Controller
 *
 * @property Car $Car
 * @property PaginatorComponent $Paginator
 */
class CarsController extends RcatalogueAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        
         public $uses = array('Rcatalogue.Car');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Car->recursive = 0;
		$this->set('propertyCars', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__d('croogo', 'voiture introuvable'));
		}
		$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
		$this->set('car', $this->Car->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Car->create();
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'Votre voiture est ajouté avec succès'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'Votre voiture n\' est pas ajouté '), 'default', array('class' => 'error'));
			}
		}
		$parentCars = $this->Car->ParentCar->find('list');
		$this->set(compact('parentCars'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__d('croogo', 'voiture introuvable'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'Votre voiture est ajouté avec succès'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'Votre voiture n\' est pas ajouté'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
			$this->request->data = $this->Car->find('first', $options);
		}
		$parentCars = $this->Car->ParentCar->find('list');
		$this->set(compact('parentCars'));
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
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			throw new NotFoundException(__d('croogo', 'voiture introuvable'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Car->delete()) {
			$this->Session->setFlash(__d('croogo', 'Voiture supprimé avec succès'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Voiture n\'est pas supprimé'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
                $user = $this->Session->read('Auth.User');
		$this->Car->recursive = 0;
                
                //if admin then view everything
                if($user['role_id'] == 1)
                {
                   $this->set('propertyCars', $this->paginate());
                   $this->set('isAdmin',1);
                }
                else
                {
                    $this->set('propertyCars', $this->paginate(array('Car.user_id' =>$user['id'])));
                    $this->set('isAdmin',0);
                }
		
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__d('croogo', 'voiture introuvable'));
		}
		$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
		$this->set('car', $this->Car->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
            //get user session
            $user = $this->Session->read('Auth.User');
        if ($user['role_id'] == 1) {
            $this->Session->setFlash(__d('croogo', 'L\'administrateur ne peut pas ajouter des voitures'), 'flash', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
            $this->set('useridsession',$user['id']);
            
            $nbcars = $this->Car->find('count',array(
                'conditions' => array('Car.user_id' => $user['id'])));
            
            if($nbcars<5)
            {
		if ($this->request->is('post')) {
               
                    
                    if($this->request->data['Car']['type'] == 0){
                        $this->request->data['Car']['type'] ='Votre véhicule';
                    }else if($this->request->data['Car']['type'] == 1){
                      $this->request->data['Car']['type'] ='Une véhicule de location';  
                    }
                        $this->request->data['Car']['name'] = $this->request->data['Car']['marque'].' '.$this->request->data['Car']['year'];
			$this->Car->create();
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'Votre voiture est ajouté avec succès'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'Votre voiture n\' est pas ajouté'), 'default', array('class' => 'error'));
			}
		}
            }
            else {
                $this->Session->setFlash(__d('croogo', 'Vous ne pouvez plus ajouter d\'autres voitures'), 'default', array('class' => 'error'));
                $this->redirect(array('action' => 'index'));
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
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__d('croogo', 'voiture introuvable'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['Car']['name'] = $this->request->data['Car']['marque'].' '.$this->request->data['Car']['year'];
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'Votre voiture est ajouté avec succès'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'Votre voiture n\' est pas ajouté'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
			$this->request->data = $this->Car->find('first', $options);
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
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			throw new NotFoundException(__d('croogo', 'voiture introuvable'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Car->delete()) {
			$this->Session->setFlash(__d('croogo', 'Voiture supprimé avec succès'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Voiture n\'est pas supprimé'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
