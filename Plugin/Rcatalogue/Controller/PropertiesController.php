<?php

App::uses('RcatalogueAppController', 'Rcatalogue.Controller');
App::uses('FileManagerAppController', 'FileManager.Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Users');

/**
 * Properties Controller
 *
 * @property Property $Property
 * @property PaginatorComponent $Paginator
 */
class PropertiesController extends RcatalogueAppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Security', 'RequestHandler');
    public $uses = array('Rcatalogue.Property', 'Rcatalogue.Car',
        'Rcatalogue.PropertyAddress', 'Rcatalogue.Rcatalogueattachment',
        'Contacts.Contact', 'Contacts.Message', 'Rcatalogue.Specification', 'Menus.Link', 'Users.User', 'Users.Userinfo');
    public $helpers = array('Cache');

    /*
     * Cache : Methods
     */
    public $cacheAction = array(
        'promoted' => 3600,
        'view' => 3600
    );

    /**


      /**
     * Before executing controller actions
     *
     * @return void
     * @access public
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions[] = 'admin_add';
        $this->Security->unlockedActions[] = 'admin_edit';
        $this->Security->unlockedActions[] = 'search';
        $this->Security->unlockedActions[] = 'listing';
        $this->Security->unlockedActions[] = 'downpdf';
    }

    public function beforeRender() {
        parent::beforeRender();
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Property->recursive = 0;
        $this->set('properties', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Property->exists($id)) {
            throw new NotFoundException(__d('croogo', 'Invalid property'));
        }
        $options = array('conditions' => array('Property.' . $this->Property->primaryKey => $id));
        $this->set('property', $this->Property->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Property->create();
            if ($this->Property->save($this->request->data)) {
                $this->Session->setFlash(__d('croogo', 'The property has been saved'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('croogo', 'The property could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
        }
        $propertyCategories = $this->Property->PropertyCategory->find('list');
        $this->set(compact('propertyCategories'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Property->exists($id)) {
            throw new NotFoundException(__d('croogo', 'Invalid property'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Property->save($this->request->data)) {
                $this->Session->setFlash(__d('croogo', 'The property has been saved'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('croogo', 'The property could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
        } else {
            $options = array('conditions' => array('Property.' . $this->Property->primaryKey => $id));
            $this->request->data = $this->Property->find('first', $options);
        }
        $propertyCategories = $this->Property->PropertyCategory->find('list');
        $this->set(compact('propertyCategories'));
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
        $this->Property->id = $id;
        if (!$this->Property->exists()) {
            throw new NotFoundException(__d('croogo', 'Invalid property'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Property->delete()) {
            $this->Session->setFlash(__d('croogo', 'Property deleted'), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('croogo', 'Property was not deleted'), 'default', array('class' => 'error'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function _mailtempl($emailuser, $subjectformail, $userinfofortemplate,$templatename)
    {
        $success = false;
        try {
            $email = new CakeEmail('default');
            $email->to($emailuser);
            $email->subject($subjectformail);
            $email->emailFormat('html');
            $email->viewVars($userinfofortemplate);
            $email->template($templatename);
            $success = $email->send();
        } catch (SocketException $e) {
            $this->log(sprintf('Error sending email - cancel departure'));
        }

        return $success;
    }
    public function admin_index($iscatalogue = null,$mespassagers = null) {

        //delete sessionn when accessing by catalogue menu
        if ($iscatalogue == 1) {
            if ($this->Session->check('criteria')) {
                $this->Session->delete('criteria');
            }
        }
        $user = $this->Session->read('Auth.User');
        if ($user['role_id'] == 1) {
            //admin can view everything
            $this->Paginator->settings = array(
                'contain' => array('Car', 'PropertyAddress'),
                'joins' => array(
                    array(
                        'table' => 'property_addresses',
                        'alias' => 'PropertyAddress',
                        'conditions' => array(
                            'PropertyAddress.property_id = Property.id',
                        )
                    )
                ),
                'group' => 'Property.id',
                'order' => array('Property.datedepart' => 'DESC'),
                'limit' => 10
            );
        } else {
            //only view user departures
            $this->Paginator->settings = array(
                'contain' => array('Car', 'PropertyAddress'),
                'joins' => array(
                    array(
                        'table' => 'property_addresses',
                        'alias' => 'PropertyAddress',
                        'conditions' => array(
                            'PropertyAddress.property_id = Property.id',
                        )
                    )
                ),
                'group' => 'Property.id',
                'conditions' => array(
                    'Car.user_id' => $user['id'],
                    ),
                'order' => array('Property.datedepart' => 'DESC'),
                'limit' => 10
            );
        }

        //paginate all properties
        if (empty($this->request->data)) {
            if ($this->Session->check('criteria')) {
                $critecond = (array) $this->Session->read('criteria');
               $properties = $this->Paginator->paginate($critecond);
            } else {
               $properties = $this->Paginator->paginate();
            }
        }
        //paginate properties with some conditions
        else {
            if ($this->Session->check('criteria')) {
                $this->Session->delete('criteria');
            }
            $criteria = $this->Properties->paginateAdminProperties($this->request->data);
            $this->Session->write('criteria', $criteria);
            $properties = $this->Paginator->paginate($criteria);
        }
        $jour_semaine = array(1=>"lundi", 2=>"mardi", 3=>"mercredi", 4=>"jeudi", 5=>"vendredi", 6=>"samedi", 7=>"dimanche");

        //add passager to properties
        if(!empty($properties))
        {
            foreach ($properties as $key => $propinfo) {
                if($propinfo['Property']['useres'] != '')
                {
                    //This departure has passagers reserved
                    $passagerres = $this->User->find('all',array(
                            'contain' => array('Userinfo'),
                            'conditions' => array('User.id' => explode(',', $propinfo['Property']['useres'])),
                    ));
                    $properties[$key]['Property']['passagersinfo'] = $passagerres;
                }
                //add jour depart
                list($annee, $mois, $jour) = explode ("-", $propinfo['Property']['datedepart']);
 
                    $timestamp = mktime(0,0,0, date($mois), date($jour), date($annee));
                    $njour = date("N",$timestamp);
                    $properties[$key]['Property']['jourdepart'] = $jour_semaine[$njour];
            }
        }
        
        
        //set prop to view
        $this->set('properties',$properties);
        if($mespassagers != null)
        {
            $this->Session->setFlash(__d('croogo', 'Pour voir les passagers inscrits dans votre départ cliquer sur le lien contenant les places réservés'), 'default', array('class' => 'alert alert-info'));
        }
        
        /*
         * save properties state to get it when delete (cancel dep)
         * and avoid another request to database
         */
        if ($this->Session->check('propsession')) {
            $this->Session->delete('propsession');
            $this->Session->write('propsession', $properties);
        } else {
            $this->Session->write('propsession', $properties);
        }
    }

    public function admin_cancel($image_id = null) {
        $this->Rcatalogueattachment->delete($image_id);
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Property->exists($id)) {
            throw new NotFoundException(__d('croogo', 'Invalid property'));
        }
        $options = array('conditions' => array('Property.' . $this->Property->primaryKey => $id));
        $this->set('property', $this->Property->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {

        //get session user
        $user = $this->Session->read('Auth.User');
        if ($user['role_id'] == 1) {
            $this->Session->setFlash(__d('croogo', 'L\'administrateur ne peut pas ahouter des départs'), 'flash', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
        $error = array();
        if ($this->request->is('post')) {
            //create conditions
            $cond = '';
            foreach ($this->request->data['Conditions'] as $key => $array_value) {
                if ($key != 5) {
                    $cond .= $array_value['id'] . ',';
                } else {
                    $cond .= $array_value['id'];
                }
            }
            $this->request->data['Property']['spec'] = $cond;
            $this->request->data['Property']['user_id'] = $user['id'];
            //create conditions
            
            $datdep = new DateTime($this->request->data['Property']['datedepart']);
            $datdep->setTime($this->request->data['Property']['heuredepart']['hour'],
                $this->request->data['Property']['heuredepart']['min']);
           
            
            $array_test = $this->request->data['PropertyAddress'];
            unset($array_test['id']);
           
            if(in_array('', $array_test)){
            if($this->request->data['PropertyAddress']['line_address'] == '' ){
                $error[0]= 'Veuillez remplir l\'adresse de départ SVP !';
            }
            if($this->request->data['PropertyAddress']['city'] == '' ){
                $error[1]= 'Veuillez remplir la ville de départ SVP !';
            }
            if($this->request->data['PropertyAddress']['line_address_des'] == '' ){
                $error[2]= 'Veuillez remplir l\'adresse d\'arrivé SVP !';
            }
            if($this->request->data['PropertyAddress']['city_des'] == '' ){
                $error[3]= 'Veuillez remplir la ville d\'arrivé SVP !';
            }
            if($this->request->data['PropertyAddress']['latitude'] == '' ){
                $error[4]= 'Veuillez remplir les coordonnées de rendez-vous SVP !';
            }
            if($this->request->data['PropertyAddress']['latitude_des'] == '' ){
                $error[5]= 'Veuillez remplir les coordonnées de point de chute SVP !';
            }
            if($this->request->data['PropertyAddress']['longitude'] == '' ){
                $error[6]= 'Veuillez remplir les coordonnées de rendez-vous SVP !';
            }
            if($this->request->data['PropertyAddress']['longitude_des'] == '' ){
                $error[7]= 'Veuillez remplir les coordonnées de point de chute SVP !';
            }
            }
            $datdep = new DateTime($this->request->data['Property']['datedepart']);
            
            $datdep->setTime($this->request->data['Property']['heuredepart']['hour'],
                $this->request->data['Property']['heuredepart']['min']);
            
             if($datdep <= new DateTime("now"))
            {
                $error[]= 'Veuillez choisir une heure de départ supérieur à l\'heure actuelle';
            }
            if($this->request->data['Property']['pricedt'] <= 0)
            {
                $error[]= 'Le prix doit être supérieur strictement à 0';
            }
            if($this->request->data['Property']['rooms'] <= 0)
            {
                $error[]= 'Le nombre de places doit être supérieur strictement à 0';
            }
            if(empty($error)){
                     
            $datatosave['Property'] = $this->request->data['Property'];
            $datatosave['PropertyAddress'] = $this->request->data['PropertyAddress'];
            
            //save all data
            
            $this->Property->create();
            if ($this->Property->save($datatosave)) {
                
                //1- add the id of the last property
                $datatosave['PropertyAddress']['property_id'] = $this->Property->id;

                //2- save the address of this property
                //$this->loadModel('PropertyAddress');
                $this->PropertyAddress->create();
                $this->PropertyAddress->save($datatosave);
                
                //Add 100 ecopiont to the user
                 $userinf = $this->Userinfo->findByUserId($user['id']);
                 $eval = $userinf['Userinfo']['ecopoint'] + 100;
                 $this->Userinfo->id = $userinf['Userinfo']['id'];
                 $this->Userinfo->saveField('ecopoint', $eval);
                 
                $this->Session->setFlash(__d('croogo', 'Votre départ a étais enregistrer.Vous avez reçue 100 éco-point'), 'default', array('class' => 'success'));
                //$this->redirect(array('action' => 'edit',$this->Property->id));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('croogo', 'The property could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
            }
            
        }
        $cars = $this->Property->Car->find('list', array(
            'conditions' => array('Car.user_id' => $user['id'])));
        $this->set(compact('cars'));
        $this->set('error',$error);
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        
        if($id == null || !$this->Property->exists($id))
        {
           $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'default', array('class' => 'success'));
           $this->redirect(array('action' => 'index'));  
        }
        
        $user = $this->Session->read('Auth.User');
        $userprop =  $this->User->findById($user['id']);
        $prop = $this->Property->findById($id);

        if($user['role_id'] == 1)
        {
            $this->set('editable','');
        }
        else
        {
           $this->set('editable','disabled')  ;
        }
        $error = array();
        $idsprop = explode(',', $userprop['User']['property_id']);
        if (in_array($id, $idsprop) || ($prop['Property']['user_id'] == $user['id']) || $user['role_id'] == 1) {
            if ($this->request->is('post') || $this->request->is('put')) {
//                debug($this->request->data);
//            die("data1");
                //edit is just for admin user
                if ($user['role_id'] == 1) {
            //create conditions
            $cond = '';
            foreach ($this->request->data['Conditions'] as $key => $array_value) {
                if ($key != 5) {
                    $cond .= $array_value['id'] . ',';
                } else {
                    $cond .= $array_value['id'];
                }
            }
            $this->request->data['Property']['spec'] = $cond;
            //create conditions
            
            
            $array_test = $this->request->data['PropertyAddress'];
            unset($array_test['id']);
           
            if(in_array('', $array_test)){
            if($this->request->data['PropertyAddress']['line_address'] == '' ){
                $error[0]= 'Veuillez remplir l\'adresse de départ SVP !';
            }
            if($this->request->data['PropertyAddress']['city'] == '' ){
                $error[1]= 'Veuillez remplir la ville de départ SVP !';
            }
            if($this->request->data['PropertyAddress']['line_address_des'] == '' ){
                $error[2]= 'Veuillez remplir l\'adresse d\'arrivé SVP !';
            }
            if($this->request->data['PropertyAddress']['city_des'] == '' ){
                $error[3]= 'Veuillez remplir la ville d\'arrivé SVP !';
            }
            if($this->request->data['PropertyAddress']['latitude'] == '' ){
                $error[4]= 'Veuillez remplir les coordonnées de rendez-vous SVP !';
            }
            if($this->request->data['PropertyAddress']['latitude_des'] == '' ){
                $error[5]= 'Veuillez remplir les coordonnées de point de chute SVP !';
            }
            if($this->request->data['PropertyAddress']['longitude'] == '' ){
                $error[6]= 'Veuillez remplir les coordonnées de rendez-vous SVP !';
            }
            if($this->request->data['PropertyAddress']['longitude_des'] == '' ){
                $error[7]= 'Veuillez remplir les coordonnées de point de chute SVP !';
            }
            
            
            }
             
            $datdep = new DateTime($this->request->data['Property']['datedepart']['year'].'-'.
                    $this->request->data['Property']['datedepart']['month'].'-'.
                    $this->request->data['Property']['datedepart']['day']);
            
            $datdep->setTime($this->request->data['Property']['heuredepart']['hour'],
                $this->request->data['Property']['heuredepart']['min']);
            
             if($datdep <= new DateTime("now"))
            {
                $error[]= 'Veuillez choisir une heure de départ supérieur à l\'heure actuelle';
            }
            
            if($this->request->data['Property']['pricedt'] <= 0)
            {
                $error[]= 'Le prix doit être supérieur strictement à 0';
            }
            if($this->request->data['Property']['rooms'] <= 0)
            {
                $error[]= 'Le nombre de places doit être supérieur strictement à 0';
            }
            $this->set('error',$error);
           
            if(empty($error)){
                
                    
            $datatosave['Property'] = $this->request->data['Property'];
            $datatosave['PropertyAddress'] = $this->request->data['PropertyAddress'];
            
            //save all data
            $this->Property->create();
            if ($this->Property->save($datatosave)) {
                
                //1- add the id of the last property
                $datatosave['PropertyAddress']['property_id'] = $this->Property->id;

                //2- save the address of this property
                //$this->loadModel('PropertyAddress');
                $this->PropertyAddress->create();
                $this->PropertyAddress->save($datatosave);
                
                 
                $this->Session->setFlash(__d('croogo', 'Départ modifié avec success'), 'default', array('class' => 'success'));
                //$this->redirect(array('action' => 'edit',$this->Property->id));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('croogo', 'The property could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
            }
            
        } else {
                    //redirect user and inform him that he can not edit departure
                    $this->Session->setFlash(__d('croogo', 'Vous n\'avez pas les droits pour modifier ce départ'), 'default', array('class' => 'error'));
                    //$this->redirect(array('action' => 'edit',$this->Property->id));
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->request->data = $this->Property->findById($id);

                //get session user (cars) - admin can view all
                $cars = $this->Property->Car->find('list', array(
                    'conditions' => array('Car.user_id' => $this->request->data['Property']['user_id'])));
                $this->set(compact('cars'));
            }
        }
        else {
           $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'default', array('class' => 'success'));
           $this->redirect(array('action' => 'index'));
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
        
        $this->Property->id = $id;
        if (!$this->Property->exists()) {
            throw new NotFoundException(__d('croogo', 'Invalid property'));
        }
        $this->request->onlyAllow('post', 'delete');
        
        /*
         * send email to users and credits
         */
        $continuedelete = false;
        $stateprocess ['mail'] = false;
        $stateprocess ['message'] = false;
        $stateprocess ['credit'] = false;
        $stateprocess ['deleting'] = false;
        $properties = (array) $this->Session->read('propsession');
        
        $propspecific = array();
        foreach ($properties as $key => $value) {
            if($value['Property']['id'] == $id)
            {
                //condition - can't delete if datedepart is passed
                if(new DateTime($value['Property']['datedepart'])<= new DateTime("now"))
                {
                    $this->Session->setFlash(__d('croogo', 'Vous ne pouvez pas annuler le départ'), 'default', array('class' => 'error'));
                    $this->Croogo->redirect(array('action' => 'index')); 
                    break;
                }
                //if departure does not have any passager reserved
                if(!isset($value['Property']['passagersinfo']))
                {
                    if ($this->Property->delete()) {
                      $this->Session->setFlash(__d('croogo', 'Départ annulé avec succés'), 'default', array('class' => 'success'));
                      $this->redirect(array('action' => 'index'));  
                    }
                    else
                    {
                      $this->Session->setFlash(__d('croogo', 'Echec d\'annulation de départ, essayer une autre fois, si le problème persiste contacter l\'administrateur'), 'default', array('class' => 'error'));  
                      $this->redirect(array('action' => 'index'));  
                    }
                }
                //1- get the specified dep from session
                $propspecific = $value['Property']['passagersinfo'];
                
                //!! becarful if functionality add another address is done , this source code
                //sould be changed
                $departureinfo = $value['PropertyAddress'][0];
                $departureinfo['iddep']= $value['Property']['id'];
                $departureinfo['datedepart']= $value['Property']['datedepart'];
                break;
            }
        }
        //2- continue the process if data is not empty or null
        if(!empty($propspecific))
        {
            foreach ($propspecific as $key => $value) {
               $departureinfo = array_merge($departureinfo,$value['User']);
               $array_places = array_combine(explode(',',$departureinfo['property_id']), explode(',',$departureinfo['nbrplace']));
               $departureinfo['nbrplacesindep'] = $array_places[$id];
               $sucess = $this->_mailtempl($value['User']['email'], 'Depart '.$id.' est annulé', $departureinfo,'canceldep');
               if($sucess == false)
               {
                   //problem in sending mail
                   $continuedelete = false;
                   $this->Session->setFlash(__d('croogo', 'Echec d\'annulation de départ, essayer une autre fois ou contacter l\'administrateur'), 'default', array('class' => 'error'));
                   break;
               }
               else
               {
                   $stateprocess ['mail'] = true;
                   //send message admin
                   $this->request->data['Message']['contact_id'] = $value['User']['id'];
                   $this->request->data['Message']['name'] = 'Administration';
                   $this->request->data['Message']['email'] = 'contact@autoostop.com';
                   $this->request->data['Message']['title'] = 'Annulation départ REF-'.$id;
                   $this->request->data['Message']['body'] = 'Bonjour ' . $value['User']['name'] . ',Autostop vous informe que le depart REF'.$id.' est annulé, un mail de confirmation a été envoyé à votre boite mail';
                   $this->Message->create();
                   if($this->Message->save($this->request->data))
                   {
                      //message sent to admin ok
                       $stateprocess ['message'] = true;
                      $this->Session->setFlash(__d('croogo', 'Tous les passagers qui sont inscrit dans ce départ sont informé, par mail et par notification, que le départ a été annulé'), 'default', array('class' => 'success'));
                      //$this->redirect(array('action' => 'index'));
                   }
                   else
                   {
                       $this->Session->setFlash(__d('croogo', 'Tous les passagers qui sont inscrit dans ce départ sont informé, par mail seulement que le départ a été annulé'), 'default', array('class' => 'alert alert-info'));
                       //$this->redirect(array('action' => 'index'));
                   }
                   //3- send credits to passagers
                   $this->Userinfo->id = $value['Userinfo'][0]['id'];
                   if($this->Userinfo->saveField('credit', $value['Userinfo'][0]['credit']+$value['User']['nbrplace']))
                   {
                      $stateprocess ['credit'] = true;
                      $continuedelete = true; 
                      
                      //update user field properties and places
                      unset($array_places[$id]);
                      $this->User->id = $value['User']['id'];
                      
                      if($this->User->saveField('property_id',  implode(',',array_keys($array_places))));
                      {
                         $this->User->saveField('nbrplace',  implode(',',array_values($array_places))); 
                      }
                   }
                   else
                   {
                       $continuedelete = false;
                       $this->Session->setFlash(__d('croogo', 'Echec d\'annulation de départ, problème dans le transfer de credits reservation , si le problème persiste contacter l\'administrateur'), 'default', array('class' => 'error'));
                       //$this->redirect(array('action' => 'index'));
                   }
               }
            }
        }
        /*
         * send email to users and credits
         */
        
        if($continuedelete == true)
        {
            if ($this->Property->delete()) {
                $stateprocess ['deleting'] = true;
                
                //check if there are some problems
                if(!in_array(false, $stateprocess))
                {
                $this->Session->setFlash(__d('croogo', 'Départ annulé avec succés et tous les passagers sont informé'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
                }
                else
                {
                  $this->Session->setFlash(__d('croogo', 'Départ annulé'), 'default', array('class' => 'alert alert-info'));
                  //$this->redirect(array('action' => 'index'));  
                }
            }
        }
        $this->Session->setFlash(__d('croogo', 'Echec d\'annulation de départ, essayer une autre fois, si le problème persiste contacter l\'administrateur'), 'default', array('class' => 'error'));
        $this->redirect(array('action' => 'index'));
    }

    /*
     * Clean all related tables that contain reference to this prop
     */

    public function cleanprop($prop_address) {

        foreach ($prop_address as $key => $array_padress) {
            if ($this->PropertyAddress->delete($array_padress['PropertyAddress']['id'])) {
                $this->Session->setFlash(__d('croogo', 'Adress deleted'), 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash(__d('croogo', 'Invalid id for Address'), 'default', array('class' => 'error'));
                return $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function admin_deleteimg($id = null, $actionsource = null, $sourceid = null) {
        if (!$id) {
            $this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
            return $this->redirect(array('action' => 'index'));
        }

        if ($this->Rcatalogueattachment->delete($id)) {
            $this->Session->setFlash(__d('croogo', 'Rcatalogueattachment deleted'), 'default', array('class' => 'success'));
            if ($actionsource == 'actionedit')
                return $this->redirect(array('action' => 'edit', $sourceid));
            else {
                return $this->redirect(array('action' => 'add'));
            }
        } else {
            $this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
            return $this->redirect(array('action' => 'index'));
        }
    }

    public function deleteimages($imagesarray, $actionsource = null, $sourceid = null) {

        foreach ($imagesarray as $id => $ischecked) {

            if ($ischecked['id'] == 1) {
                if (!$id) {
                    $this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
                    return $this->redirect(array('action' => 'index'));
                }

                if ($this->Rcatalogueattachment->delete($id)) {
                    $this->Session->setFlash(__d('croogo', 'Rcatalogueattachment deleted'), 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
                    return $this->redirect(array('action' => 'index'));
                }
            }
        }

        if ($actionsource == 'actionedit')
            return $this->redirect(array('action' => 'edit', $sourceid));
        else {
            return $this->redirect(array('action' => 'add'));
        }
    }

    public function updateimages($imagesarray, $actionsource = null, $sourceid = null) {

        foreach ($imagesarray as $id => $ischecked) {

            if ($ischecked['id'] == 1) {
                if (!$id) {
                    $this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
                    return $this->redirect(array('action' => 'index'));
                }
                $data_updated = array('Rcatalogueattachment' => array(
                        'id' => $id,
                        'imgdefault' => 1,
                ));
                if ($this->Rcatalogueattachment->save($data_updated)) {
                    $this->Session->setFlash(__d('croogo', 'Rcatalogueattachment updated'), 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
                    return $this->redirect(array('action' => 'index'));
                }
            } else {
                $data_updated = array('Rcatalogueattachment' => array(
                        'id' => $id,
                        'imgdefault' => 0,
                ));
                if ($this->Rcatalogueattachment->save($data_updated)) {
                    $this->Session->setFlash(__d('croogo', 'Rcatalogueattachment updated'), 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash(__d('croogo', 'Invalid id for Rcatalogueattachment'), 'default', array('class' => 'error'));
                    return $this->redirect(array('action' => 'index'));
                }
            }
        }
    }

    /*
     * Listing methods
     */

    public function listing() {
        
        /*
         * seo values of this Link
         */
        $attr_text = 'plugin:rcatalogue/controller:properties/action:listing';
        $this->Link->recursive = -1;
        $linkvalue = $this->Link->findByLink($attr_text);
        $node['Node']['seotitle'] = $linkvalue['Link']['seotitle'];
        $node['Node']['seoh1'] = $linkvalue['Link']['seoh1'];
        $node['Node']['seoh2'] = $linkvalue['Link']['seoh2'];
        $node['Node']['seocanonical'] = $linkvalue['Link']['seocanonical'];
        $node['Node']['seofootertext'] = $linkvalue['Link']['seofootertext'];
        $node['Node']['seodescription'] = $linkvalue['Link']['seodescription'];
        $node['Node']['seoogimage'] = $linkvalue['Link']['seoogimage'];
        $node['Node']['bodytext'] = $linkvalue['Link']['body'];

        //send values to view
        $this->set(compact('node'));
        /*
         * seo values of this Link
         */
        
        if (isset($this->request->data['PropertyAdvanced'])) {
            $this->Paginator->settings = array(
                'contain' => array('Car', 'PropertyAddress', 'User' => array('Userinfo')),
                'joins' => array(
                    array(
                        'table' => 'property_addresses',
                        'alias' => 'PropertyAddress',
                        'conditions' => array(
                            'PropertyAddress.property_id = Property.id',
                        )
                    )
                ),
                'limit' => 8,
                'order' => array('PropertyAddress.city' => 'ASC')
            );
            //advanced search
            $criteria = $this->Properties->advancedSearch($this->request->data['PropertyAdvanced']);
            $this->set('properties', $this->Paginator->paginate($criteria));
        } else {
            $this->Paginator->settings = array(
                'contain' => array('Car', 'PropertyAddress', 'User' => array('Userinfo')),
                'limit' => 8,
                'order' => array('Property.datedepart' => 'DESC')
            );
            //paginate all properties related to the specific category
            $properties = $this->Paginator->paginate('Property');
            $this->set(compact('properties'));
            //paginate all properties related to the specific category  
        }
    }

    public function propertydetails($property_id = null) {
        if ($property_id != null) {
            if (!$this->Property->exists($property_id)) {
                throw new NotFoundException(__d('croogo', 'Départ introuvable'));
            }
            
            $property = $this->Property->find('first', array(
                'contain' => array('PropertyAddress', 'Car', 'User' => array('Userinfo')),
                'conditions' => array('Property.id' => $property_id)
                    )
            );
            
            //404 if date passed or complet
            if(new DateTime($property['Property']['datedepart'])<= new DateTime("now") ||
               ($property['Property']['reserved'] == $property['Property']['rooms']))
            {
               $this->set('passed',true);
            }

            $userinfodata = $this->Userinfo->findByUserId($property['Property']['user_id']);
            if (!empty($userinfodata)) {
                $this->set(compact('userinfodata'));
            }

            $this->set(compact('property'));
        } else {
            throw new NotFoundException();
        }
    }

    public function search() {
        if (!empty($this->request->params['named'])) {
            debug("paramssss entering");
            $this->request->data['PropertyAdvanced']['places_field'] = '';
            $this->request->data['PropertyAdvanced']['type_field'] = '';
            $this->request->data['PropertyAdvanced']['prop_field'] = '';
            $this->request->data['PropertyAdvanced']['specifications_field'] = '';
            $this->request->data['PropertyAdvanced']['rstate_field'] = '';
            $this->request->data['PropertyAdvanced']['price_field'] = '';

            foreach ($this->request->params['named'] as $key => $value) {
                $this->request->data['PropertyAdvanced'][$key] = $value;
            }
        }

        //$Property = $this->{$this->modelClass};
        $this->Paginator->settings = array(
            'contain' => array('Node' => array('imgdefault = 1', 'limit' => 1), 'PropertyCategory'),
            'limit' => 8
        );

        if (isset($this->request->data['PropertyAdvanced'])) {
            //advanced search
            $criteria = $this->Properties->advancedSearch($this->request->data['PropertyAdvanced']);

            $this->set('properties', $this->Paginator->paginate($criteria));
        } else {
            //simple search
            if (!isset($this->request->data['Property']) || $this->request->data['Property']['filter'] == '') {
                $this->set('properties', $this->Paginator->paginate());
            } else {
                //search for one or many keywords in the same field
                $criteria = $this->Properties->searchKeyWords($this->request->data['Property']['filter']);
//                      debug($criteria);
//                      die('criteria');
                $this->set('properties', $this->Paginator->paginate($criteria));
            }
        }
        //find last 8 properties
        $lastproperties = $this->Property->lastProperties(8);
        $this->set(compact('lastproperties'));
        //find last 8 properties
    }

    ///telechargement PDF


    public function downpdf() {

        $propdata = $this->Property->findById($this->request->data['Property']['id']);
        require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
        $dompdf = new DOMPDF();
        $htm = $this->Pdf->renderPdf($propdata);
        $dompdf->load_html($htm);
        $dompdf->render();
        $dompdf->stream("Offre_" . $this->request->data['Property']['id'] . ".pdf");
    }

}
