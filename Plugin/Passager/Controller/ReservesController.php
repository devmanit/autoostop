<?php

App::uses('CakeEmail', 'Network/Email');
App::uses('PassagerAppController', 'Passager.Controller');

/**
 * Reservation Controller 
 *
 */
class ReservesController extends PassagerAppController {

    public $components = array('Paginator');
    public $uses = array('Rcatalogue.Property', 'Rcatalogue.Car',
        'Rcatalogue.PropertyAddress', 'Rcatalogue.Rcatalogueattachment'
        , 'Rcatalogue.Specification', 'Users.User', 'Users.Userinfo', 'Users.Transaction', 'Contacts.Contact', 'Contacts.Message');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions[] = 'reserve';
        $this->Security->unlockedActions[] = 'admin_otheradr';
        $this->Security->unlockedActions[] = 'admin_deleteres';
        $this->Security->unlockedActions[] = 'admin_index';
        $this->Security->unlockedActions[] = 'endreserve';
         $this->Security->unlockedActions[] = 'admin_successres';
        
    }

    /**
     * index method
     *
     * @return void
     */
    public function admin_index($iscatalogue = null) {

        //delete sessionn when accessing by catalogue menu
        if ($iscatalogue == 1) {
            if ($this->Session->check('criteria')) {
                $this->Session->delete('criteria');
            }
        }
        $user = $this->Session->read('Auth.User');
        $resereveddepart = $this->User->findById($user['id']);
        $idproperty = explode(',', $resereveddepart['User']['property_id']);
        $nbrplaces = explode(',', $resereveddepart['User']['nbrplace']);
        $array_final = array_combine($idproperty, $nbrplaces);
        /////////////////
      
        //admin can view everything
        if ($user['role_id'] == 1 ) {
            $this->Paginator->settings = array(
                'contain' => array('Car', 'PropertyAddress', 'User' => array('Userinfo')),
                'joins' => array(
                    array(
                        'table' => 'property_addresses',
                        'alias' => 'PropertyAddress',
                        'conditions' => array(
                        )
                    )
                ),
                'group' => 'Property.id',
                'limit' => 10
            );
        } else {
            $this->Paginator->settings = array(
                'contain' => array('Car', 'PropertyAddress', 'User' => array('Userinfo')),
                'joins' => array(
                    array(
                        'table' => 'property_addresses',
                        'alias' => 'PropertyAddress',
                        'conditions' => array(
                            array('Property.id' => $idproperty)
                        )
                    )
                ),
                'group' => 'Property.id',
                'limit' => 10,
                'order' => array(
                    'Property.datedepart' => 'DESC')
            );
        }

        $properties = null;
        //paginate all properties
        $jour_semaine = array(1=>"lundi", 2=>"mardi", 3=>"mercredi", 4=>"jeudi", 5=>"vendredi", 6=>"samedi", 7=>"dimanche");

        if ($this->Session->check('criteria')) {
            $critecond = (array) $this->Session->read('criteria');
            $properties = $this->Paginator->paginate($critecond);
        } else {
            $properties = $this->Paginator->paginate();
        }
        if ($user['role_id'] == 1 ) {
            //show all
        }else{
        foreach ($properties as $key => $value) {
            $properties[$key]['Property']['nbp'] = $array_final[$value['Property']['id']];
        }
        }
        //change status depart apres sa fin
        $active = false;
        $now = new DateTime();
        $nowdate = $now->format('Ymd');
        foreach ($properties as $key => $value) {
            $next = new DateTime($value['Property']['datedepart']);
            $nextdate = $next->format('Ymd');
            $inter = $now->diff($next);
            if ($nowdate < $nextdate) {
                $active = false;
            } else {
                if ($inter->d < 1) {
                    $active = false;
                } else {
                    $active = true;
                }
            }
            $properties[$key]['Property']['active'] = $active;
            //add jour depart
                list($annee, $mois, $jour) = explode ("-", $value['Property']['datedepart']);
 
                    $timestamp = mktime(0,0,0, date($mois), date($jour), date($annee));
                    $njour = date("N",$timestamp);
                    $properties[$key]['Property']['jourdepart'] = $jour_semaine[$njour];
        }

        ///////////////

        $this->set('properties', $properties);
    }

    /*
     * Method reservation
     */

    public function reserve($iddep = null) {
        
        if($iddep != null)
        {
            if (!$this->Property->exists($iddep)) {
                throw new NotFoundException(__d('croogo', 'Départ introuvable'));
            }
            
        //user cant reserve in his own depart
        $usersess = $this->Session->read('Auth.User');
        if ($usersess['role_id'] == 1) {
            $this->redirect('/');
        }
        else if ($usersess['role_id'] == 4) {
            $this->Session->setFlash(__d('croogo', 'Vous devez avoir un compte passager pour réserver un départ, Cliquer sur le boutton "Réserver un dpépart" pour devenir passager'), 'flash', array('class' => 'alert-info'));
            $this->redirect('/admin');
        }
       // $userinf = $this->Userinfo->findByUserId($usersess['id']);
        $property = $this->Property->findById($iddep);
        
     
        if ($this->request->is('post')) {
            $nbplace = $this->request->data['Reservation']['places'];
            if ($usersess ) {
                
                if ($property['Property']['user_id'] == $usersess['id']) {
                    $this->Session->setFlash(__d('croogo', 'Opss tu ne peut pas reserver dans cette départ, il vous appartient.'), 'flash', array('class' => 'error'));
                    $this->redirect(array('plugin' => 'rcatalogue', 'controller' => 'properties', 'action' => 'listing'));
                }
            }
            //check number of place reserved
            $nbrplaces = $nbplace + $property['Property']['reserved'];
            $deff = $property['Property']['rooms'] - $property['Property']['reserved'];

            if ($nbrplaces > $property['Property']['rooms']) {
                $this->Session->setFlash(__d('croogo', 'Il reste ' . $deff . ' place dans ce départ'), 'flash', array('class' => 'error'));
                $this->redirect(array('plugin' => 'rcatalogue', 'controller' => 'properties', 'action' => 'listing'));
            }
            ///generating  value for typepay
            $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $randd = substr($randomString, 15, 20);
            $randdd = substr($randomString, 4, 10);
            $randddd = substr($randomString, 10, 15);
            $rand = substr($randomString, 0, 4);
            $rand.=$usersess['id'] . 'x' . $randdd . $iddep . 'x' . $randddd . $nbplace . 'x';
            $rand .= $randd;
            //chaek if the session 
            if ($this->Session->check('charrandom')) {
                $this->Session->delete('charrandom');
                $this->Session->write('charrandom', $rand);
            } else {
                $this->Session->write('charrandom', $rand);
            }
            if(!$usersess){
            $this->redirect(array('action' => 'typepay', $iddep, $this->request->data['Reservation']['places'], $rand,'uiopt'));
                
            }else{
             $this->redirect(array('action' => 'typepay', $iddep, $this->request->data['Reservation']['places'], $rand));

            }
            $this->set('nbplace', $this->request->data['Reservation']['places']);
            $this->set('iddep', $iddep);
        } else {
            throw new NotFoundException(__d('croogo', 'Départ introuvable'));
        }
         }
        else
        {
            throw new NotFoundException(__d('croogo', 'Départ introuvable'));
        }
    }

    /*
     * Method confirmation reservation
     */

    public function endreserve($iddep = null, $nbplace = null, $charrrandom = null,$char = null) {
        
        if( $iddep != null && $nbplace != null && $charrrandom != null ){
          if (!$this->Property->exists($iddep)) {
                throw new NotFoundException(__d('croogo', 'Départ introuvable'));
            }  
        $usersess = $this->Auth->user();
        if ($usersess['role_id'] == 1) {
            $this->redirect('/');
        }
        $property = $this->Property->findById($iddep);
        
        //why 2 request and user and userinfo are linked !!!!
        $user = $this->User->findById($usersess['id']);
        $userinf = $this->Userinfo->findByUserId($usersess['id']);
                //chek value of data with value of session
                $arraychar = explode('v', $charrrandom);
                /* id of user */ $iduser = str_replace(substr($arraychar[0], 0, 4), '', $arraychar[0]);
                /* id of deperture */ $dep = str_replace(substr($arraychar[1], 0, 10), '', $arraychar[1]);
                /* nb of place */ $nb = str_replace(substr($arraychar[2], 0, 10), '', $arraychar[2]);

                if ($usersess['id'] == $iduser && $iddep == $dep && $nbplace == $nb) {
                    if ($this->Session->read('residcharrandom') == $charrrandom) {
                        if ($this->request->is('post')) {
                    
                        /**
                         * deacrese number of credit 
                         */
                        /*
                         * User
                         */
                        $idres = $user['User']['property_id'];
                        $idplace = $user['User']['nbrplace'];
                        $nbevaluer = $user['User']['evaluer'];
                        if ($idres == '') {
                            //first reservation in this departure
                            $idres = $iddep;
                            $idplace = $nbplace;
                            $nbevaluer = '0';
                        } else {
                            //not empty
                            $arrayids = explode(',', $idres);
                            $arrayplaces = explode(',', $idplace);
                            $arrayeval = explode(',', $nbevaluer);

                            if (!in_array($iddep, $arrayids)) {
                                //add normale and simple
                                $arrayids[] = $iddep;
                                $arrayplaces[] = $nbplace;
                                $arrayeval[] = '0';
                            } else {
                                //same reservation
                                $arraytotal = array_combine($arrayids, $arrayplaces);
                                $arraytotal[$iddep] = $arraytotal[$iddep] + $nbplace;

                                $arrayids = array_keys($arraytotal);
                                $arrayplaces = array_values($arraytotal);
                            }
                            $idres = implode(',', $arrayids);
                            $idplace = implode(',', $arrayplaces);
                            $nbevaluer = implode(',', $arrayeval);
                        }
                        /*
                         * User
                         */
                        /*
                         * Proerty
                         */
                        $idresdep = $property['Property']['useres'];
                        $idplacedep = $property['Property']['nbrplace'];

                        if ($idresdep == '') {
                            //first reservation in this departure
                            $idresdep = $usersess['id'];
                            $idplacedep = $nbplace;
                        } else {
                            //not empty
                            $arrayidsdep = explode(',', $idresdep);
                            $arrayplacesdep = explode(',', $idplacedep);


                            if (!in_array($usersess['id'], $arrayidsdep)) {
                                //add normale and simple
                                $arrayidsdep[] = $usersess['id'];
                                $arrayplacesdep[] = $nbplace;
                            } else {
                                //same reservation
                                $arraytotaldep = array_combine($arrayidsdep, $arrayplacesdep);
                                $arraytotaldep[$usersess['id']] = $arraytotaldep[$usersess['id']] + $nbplace;

                                $arrayidsdep = array_keys($arraytotaldep);
                                $arrayplacesdep = array_values($arraytotaldep);
                            }
                            $idresdep = implode(',', $arrayidsdep);
                            $idplacedep = implode(',', $arrayplacesdep);
                        }  
                        /*
                         * Proerty
                         */
                        //save id property and the reservation

                        //debug('first 1');
                        $this->User->id = $usersess['id'];
                        $this->Property->id = $iddep;
                        $this->Userinfo->id = $userinf['Userinfo']['id'];
                        $datatosave['User'] = array('evaluer' =>$nbevaluer,'property_id'=> $idres,'isreserved'=> 1,'nbrplace'=> $idplace);
                        $datatosave['Property'] = array('useres'=> $idresdep,'nbrplace'=>$idplacedep);
                        
                        //debug($datatosave);
                        //die('test data endreserve');
                        if ($this->User->save($datatosave) && 
                           $this->Property->save($datatosave)) {
                            //only with credits
                        if($char != 3){
                        $newcredit = $userinf['Userinfo']['credit'] - $nbplace;
                        $datatosave['Userinfo'] = array('credit'=>$newcredit);
                        $this->Userinfo->saveField('credit', $newcredit);
                        }
                        
                            //adding 100 ecopoint
                        $ecopoint = $userinf['Userinfo']['ecopoint'];
                     
                            $ecopoint += (100 * $nbplace);
                        
                             $this->Userinfo->saveField('ecopoint', $ecopoint);
                            //debug('second 2');
                            //add the number of places requested
                            $property['Property']['reserved'] = $property['Property']['reserved'] + $nbplace;
                            //save the place reserved  
                            $this->Property->id = $iddep;
                            $this->Property->saveField('reserved', $property['Property']['reserved']);
                            //debug('third 3');
                            //deleting sessions
                            $this->Session->delete('residcharrandom');
                            $this->Session->delete('charrandom');
                            $this->Session->setFlash(__d('croogo', 'Votre réservation a été bien enregistrer.'), 'flash', array('class' => 'success'));
                            $this->Croogo->redirect(array('admin' => true,'plugin'=>'passager','controller'=>'reserves', 'action' => 'index'));
                           }
                        }
                        $this->set('nbplace', $nbplace);
                        $this->set('usersess', $usersess);
                        $this->set('property', $property);
                    } else {
                        throw new NotFoundException;
                    }
                } else {

                    throw new NotFoundException;
                }
            
               $this->set('prixrand', $charrrandom); 
                $this->set('char', $char); 
            
        }else{
            throw new NotFoundException;
        }
    }

    /*
     * Methid proposer un autre lieu de depart
     */

    public function admin_otheradr($id_dep = null) {
         if($id_dep != null)
        {
            if (!$this->Property->exists($id_dep)) {
                throw new NotFoundException(__d('croogo', 'Départ introuvable'));
            }
        $view = new View($this);
        $html = $view->loadHelper('Html');
        $usersess = $this->Auth->user();
        if ($usersess['role_id'] == 1) {
            $this->redirect('/admin');
        }
        $property = $this->Property->findById($id_dep);
        //debug($property['User']['email']);die();
        //send mail to conducteur
        $Email = new CakeEmail('default');
        //chekin the adresse
        if ($this->request->is('post')) {
            if (!empty($this->request->data['lieu']['adresse'])) {
                $senmail = $Email->from(array('contact@autoostop.com' => 'autostop'))
                        ->to($property['User']['email'])
                        ->emailFormat('html')
                        ->subject('Demande de partir d\'un autre lieu ')
                        ->send('Bonjour ' . $property['User']['name'] . ' ' . $property['User']['surname'] . '  <br/> le passager  ' .
                        $usersess['name'] . ' ' . $usersess['surname'] . ' souhaite vous propose un endroit proche de '
                        . 'lieu que vous aves indiqué, soit  <b>' . $this->request->data['lieu']['adresse'] . '</b> <br/> Consulter votre compte pour accepter ou refuser sa demande.' .
                        '<b>Ref de départ: ' . $id_dep . '</b><br/>' .
                        $html->link('Connexion', array('admin' => false, 'plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'full_base' => true)));
                //sending message to conducteur account
                //Creating a message to send if
                $this->request->data['Message']['contact_id'] = $property['User']['id'];

                $this->request->data['Message']['name'] = $usersess['name'] . ' ' . $usersess['surname'];
                $this->request->data['Message']['email'] = $usersess['email'];
                $this->request->data['Message']['title'] = 'Demande de ' . $usersess['name'] . ' ' . $usersess['surname'] . '/Départ Num : ' . $id_dep;
                $this->request->data['Message']['isreserved'] = 1;
                $this->request->data['Message']['other'] = $usersess['id'];
                $this->request->data['Message']['property_id'] = $id_dep;
                $this->request->data['Message']['body'] = 'le passager  ' .
                        $usersess['name'] . ' ' . $usersess['surname'] . ' souhaite vous propose un endroit proche de '
                        . 'lieu que vous aves indiqué, soit  <b>' . $this->request->data['lieu']['adresse'] . '.<br/>';

                $this->Message->create();
                if ($senmail && $this->Message->save($this->request->data)) {

                    $this->Session->setFlash(__d('croogo', 'Votre demande a étais envoyer au conducteur'), 'flash', array('class' => 'success'));
                    $this->redirect(array('admin' => true, 'action' => 'index', 1));
                } else {
                    $this->Session->setFlash(__d('croogo', 'Echec'), 'flash', array('class' => 'error'));
                    $this->redirect(array('admin' => true, 'action' => 'index', 1));
                }
            } else {
                $this->Session->setFlash(__d('croogo', 'vous devez écrire une adresse'), 'flash', array('class' => 'error'));
                $this->redirect(array('admin' => true, 'action' => 'index', 1));
            }
        }
        else{
           throw new NotFoundException;
        }
        }else{
           throw new NotFoundException(__d('croogo', 'Départ introuvable'));
        }
    }

    /*
     * Method annuler reservation
     * 
     */

    public function admin_deleteres($idres = null) {
        if($idres != null)
        {
            if (!$this->Property->exists($idres)) {
                throw new NotFoundException(__d('croogo', 'Départ introuvable'));
            }
        $usersess = $this->Auth->user();
        if ($usersess['role_id'] == 1) {
            $this->Session->setFlash(__d('croogo', 'Impossible d\'annuler une réservation en tant que Admin'), 'flash', array('class' => 'error'));
            $this->redirect('/admin');
        }
        $Email = new CakeEmail();
        $property = $this->Property->findById($idres);
        $user = $this->User->findById($usersess['id']);
        
        //forb user
        $idproperty = explode(',', $user['User']['property_id']);
        $idresplace = explode(',', $user['User']['nbrplace']);
        $array_reser_info =  array_combine($idproperty,$idresplace);
        
        //forb property
        $idpropp = explode(',', $property['Property']['useres']);
        $idrespp = explode(',', $property['Property']['nbrplace']);
        $array_prop_info =  array_combine($idpropp,$idrespp);
        
        


            if ($this->request->is('post')) {
            $pass = false;
            if ($array_reser_info[$idres] == $this->request->data['Delete']['nbdel']) {
            
                unset($array_reser_info[$idres]);
                unset($array_prop_info[$usersess['id']]);
                
                $pass = true;
//                unset($idproperty[$idres]);
//                unset($idresplace[$key]);
            } else if($this->request->data['Delete']['nbdel'] < $array_reser_info[$idres]){
                //si nombre de place > 0 update nombre of places  reservation
                $array_reser_info[$idres] = $array_reser_info[$idres] - $this->request->data['Delete']['nbdel'];
                $array_prop_info[$usersess['id']] = $array_prop_info[$usersess['id']] - $this->request->data['Delete']['nbdel'];
              $pass = true;
            }
            
            if($pass === true)
            {
                
            //decombine
            $idproperty = array_keys($array_reser_info);
            $idresplace = array_values($array_reser_info);
            
             $idpropp = array_keys($array_prop_info);
            $idrespp =  array_values($array_prop_info);
            
            
                
                
            //deacrese number reserved in the departure
            $idppropres = $property['Property']['reserved'] - $this->request->data['Delete']['nbdel'];
            //sending mesage to the conducteur*
            $senmail = $Email->from(array('contact@autoostop.com' => 'autostop'))
                    ->to($property['User']['email'])
                    ->emailFormat('html')
                    ->subject('Réservation annuler ')
                    ->send('Bonjour ' . $property['User']['name'] . ' ' . $property['User']['surname'] . '  <br/> le passager  '
                    . $usersess['name'] . ' ' . $usersess['surname'] . ' a annulé sa réservation dans le  départ Num '
                    . $idres . ' avec une nombre de place = ' . $this->request->data['Delete']['nbdel']);
            //sending message
            $datatosend['Message'] = array(
                'contact_id' => $property['User']['id'],
                'name'       => $usersess['name'] . ' ' . $usersess['surname'],
                'email'      => $usersess['email'],
                'title'      => 'Réservation annuler',
                'body'       => 'Bonjour ' . $property['User']['name'] . ' ' . $property['User']['surname'] . '  <br/> le passager  '
                    . $usersess['name'] . ' ' . $usersess['surname'] . ' a annulé sa réservation dans le  départ Num '
                    . $idres . ' avec une nombre de place = ' . $this->request->data['Delete']['nbdel']
            );
               $this->Message->create();
            //add the credit
            $userinf = $this->Userinfo->findByUserId($usersess['id']);
            $newcredit = $userinf['Userinfo']['credit'] + $this->request->data['Delete']['nbdel'];
            
            //update new field
            $idproperty = implode(',', $idproperty);
            $idresplace = implode(',', $idresplace);
            $idpropp = implode(',', $idpropp);
            $idrespp = implode(',', $idrespp);
            
            $propdatatosave['Property'] = array('useres' => $idpropp, 'nbrplace' => $idrespp, 'reserved' => $idppropres);
            $userdatatosave['User'] = array('property_id' => $idproperty, 'nbrplace' => $idresplace);
            
            $this->User->id = $usersess['id'];
            $this->Property->id = $idres;
            $this->Userinfo->id = $userinf['Userinfo']['id'];
            if ($senmail && $this->Message->save($datatosend) && $this->Property->save($propdatatosave) && $this->Userinfo->saveField('credit', $newcredit) &&
                    $this->User->save($userdatatosave)) {
                $this->Session->setFlash(__d('croogo', 'Réservation annuler avec succès.'), 'flash', array('class' => 'success'));
                $this->redirect(array('admin' => true, 'action' => 'index', 1));
            } else {
                $this->Session->setFlash(__d('croogo', 'Voulez vous essayer une autre fois.'), 'flash', array('class' => 'error'));
                $this->redirect(array('admin' => true, 'action' => 'index', 1));
            }
            }
            else
            {
              $this->Session->setFlash(__d('croogo', 'Voulez vous essayer une autre fois.'), 'flash', array('class' => 'error'));
                $this->redirect(array('admin' => true, 'action' => 'index', 1));  
            }
        }//end post
        else{
           throw new NotFoundException;
        }
        }else{
           throw new NotFoundException(__d('croogo', 'Départ introuvable'));
        }
    }

    /*
     * 
     * Method type payment with credit reservation
     * 
     */

    public function typepay($iddep = null, $nbplace = null, $charandom = null,$on = null) {
        if($iddep != null)
        {
            if (!$this->Property->exists($iddep)) {
                throw new NotFoundException(__d('croogo', 'Départ introuvable'));
            }
        $usersess = $this->Auth->user();
        if ($usersess['role_id'] == 1) {
            $this->redirect('/');
        }
        $property = $this->Property->findById($iddep);
        $userinf = $this->Userinfo->findByUserId($usersess['id']);
        //chak random string of the session
        if ($charandom == null || $nbplace == null   ) {
            throw  new NotFoundException;
        } else {
            //check if the reservation is free
            $depuser = $this->User->findById($usersess['id']);
             $array_placeuser = explode(',', $depuser['User']['nbrplace']);
             $som=0;
            //chek value of data with value of session
            $arraychar = explode('x', $charandom);
            /* id of user */ $iduser = str_replace(substr($arraychar[0], 0, 4), '', $arraychar[0]);
            /* id of deperture */ $dep = str_replace(substr($arraychar[1], 0, 10), '', $arraychar[1]);
            /* nb of place */ $nb = str_replace(substr($arraychar[2], 0, 10), '', $arraychar[2]);
            $pass = false;
            if($on == null){
                if ($usersess['id'] == $iduser && $iddep == $dep && $nbplace == $nb) {
                    $pass = true;
                }
            }else{
                if($on == 'uiopt' && $iddep == $dep && $nbplace == $nb) {
                    $pass = true;
                }   
            }
            if ($pass) {
                //chek the hole string
                if ($this->Session->read('charrandom') == $charandom) {
                    //other conditon just to be sure
                    $nbrplaces = $nbplace + $property['Property']['reserved'];
                    $deff = $property['Property']['rooms'] - $property['Property']['reserved'];
                    if ($nbrplaces > $property['Property']['rooms']) {
                        $this->Session->setFlash(__d('croogo', 'Il reste ' . $deff . ' place dans ce départ'), 'flash', array('class' => 'error'));
                        $this->redirect(array('plugin' => 'rcatalogue', 'controller' => 'properties', 'action' => 'listing'));
                    }
                    if ($usersess) {
                        if ($property['Property']['user_id'] == $usersess['id']) {
                            $this->Session->setFlash(__d('croogo', 'Opss tu ne peut pas reserver dans cette départ, il vous appartient.'), 'flash', array('class' => 'error'));
                            $this->redirect(array('plugin' => 'rcatalogue', 'controller' => 'properties', 'action' => 'listing'));
                        }
                    }
                    ////
                    ///generating other value for endreserve
                    $characters = '0123456789abcdefghijklmnopqrsutwxyzABCDEFGHJKLMOPQRSTUVWXYZ';
                    $randomString = '';
                    for ($i = 0; $i < 20; $i++) {
                        $randomString .= $characters[rand(0, strlen($characters) - 1)];
                    }
                    $randd = substr($randomString, 15, 20);
                    $randdd = substr($randomString, 4, 10);
                    $randddd = substr($randomString, 10, 15);
                    $rand = substr($randomString, 0, 4);
                    $rand.=$usersess['id'] . 'v' . $randdd . $iddep . 'v' . $randddd . $nbplace . 'v';
                    $rand .= $randd;
                    if ($this->Session->check('residcharrandom')) {
                        $this->Session->delete('residcharrandom');
                        $this->Session->write('residcharrandom', $rand);
                    } else {
                        $this->Session->write('residcharrandom', $rand);
                    }
                    if ($userinf['Userinfo']['credit'] == 0 || $userinf['Userinfo']['credit'] < $nbplace) {
                        $this->Session->setFlash(__d('croogo', 'Vous n\'avez pas assez de crédit'), 'flash', array('class' => 'error'));
                    } 
                    //
                     foreach($array_placeuser as  $value) {
                              $som += $value;
                              }  
                             
                      if($som == 2 && $nbplace == 1){
                          $this->redirect(array('action' => 'endreserve',$iddep,$nbplace,$rand,3));
                        }
                    //deleting seesion
                    $this->Session->delete('charrandom');
                    $this->set('credit', $userinf['Userinfo']['credit']);
                    $this->set('nbplace', $nbplace);
                    $this->set('property', $property);
                    $this->set('rand', $rand);
                } else {
                throw  new NotFoundException;
                }
            } else {
              throw  new NotFoundException;
            }
        }
        }else{
           throw new NotFoundException(__d('croogo', 'Départ introuvable'));
        }
    }

    /*
     * payement reservation with paypal
     */

    public function buyres($dep = null, $nbplace = null,$rand = null) {
        //debug($rand);die();
        if($dep != null && $nbplace != null && $rand != null)
        {
                if (!$this->Property->exists($dep)) 
                {
                throw new NotFoundException(__d('croogo', 'Départ introuvable'));
                }
                if($rand == $this->Session->read('residcharrandom'))
                {
                    $prix = 3.93;
                    $user = $this->Session->read('Auth.User');
                    if ($user['role_id'] == 1) 
                    {
                        $this->redirect('/');
                    }
                    $id = $user['id'];
                    $this->User->recursive = -1;
                    $depuser = $this->User->findById($id);
                    $array_depuser = explode(',', $depuser['User']['property_id']);
                    $array_placeuser = explode(',', $depuser['User']['nbrplace']);
                    $som = 0;
                    //calcul of  price
                    if($depuser != null)
                    {
                            if(empty($array_depuser))
                            {
                                    if($nbplace >= 3)
                                    {
                                    $gratuit = $nbplace -1 ;
                                    }
                                    else
                                    {
                                        $gratuit =$nbplace;
                                    }
                            }
                            else
                            {
                                    foreach($array_placeuser as  $value) 
                                    {
                                       $som += $value;
                                    }
                                    if($som >= 3)
                                    {
                                        $gratuit = $nbplace;
                                    }
                                    else
                                    {
                                        $som += $nbplace;
                                        if($som >= 3)
                                        {
                                            $gratuit = $nbplace -1 ;  
                                        }
                                        else
                                        {
                                            $gratuit = $nbplace;
                                        }
                                    }

                             }
                            if(in_array($dep,$array_depuser))
                            {
                                  $prixfinale = $gratuit * 3;
                            }
                            else
                            {
                                    if($gratuit == 1)
                                    {
                                    $prixfinale  = 3.93;
                                    }
                                    else
                                    {
                                      $prixfinale = $prix + (($gratuit-1) * 3);
                                    }  
                            }
                             //format the price
                            $prixfinale = number_format($prixfinale,2);
                            //creating random string
                            $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
                            $randomString = '';
                            for ($i = 0; $i < 20; $i++) 
                            {
                            $randomString .= $characters[rand(0, strlen($characters) - 1)];
                            }
                            $this->User->id = $id;
                         
                                 if($this->User->saveField('randomverify', $randomString)){
                                    // debug($id);debug($dep);debug($nbplace);debug($randomString);die();
                                 $url = $this->Transaction->requestPaypal(
                                         $prixfinale,
                                         "Achat de réservation",
                                         "action=buyres&uid=$id&dep=$dep&nb=$nbplace&rand=$randomString",
                                         2);
                               if ($url) 
                               {
                                   $this->redirect($url);
                               }
                            }
                            
                    }
                    else
                    {
                       throw new NotFoundException(__d('croogo', 'Départ introuvable'));
                    }
                }
                else
                {
                   throw new NotFoundException(__d('croogo', 'Une erreur est survenue'));
                }
        }
        else
        {
           throw new NotFoundException(__d('croogo', 'Départ introuvable'));
        }
    }
    /*
     * 
     * 
     * 
     */
     public function admin_successres(){
        $usercon = $this->Session->read('Auth.User');
        $this->User->recursive = -1;
        $user = $this->User->findById($usercon['id']);

        $iscomp = null;
        $i = 0;
        while ($iscomp == null || empty($iscomp)) {
            // Et ceci est la meilleur façon :
            $nano = time_nanosleep(6, 100000);
             $this->log($nano, 'debug');
            if ($i > 8) {
                break;
            }
            if ($nano === true) {
                $this->Transaction->recursive = -1;
                $iscomp = $this->Transaction->find('first', array('conditions' => array(
                        'Transaction.clientid' => $usercon['id'],
                        'Transaction.status' => 'Completed',
                        'Transaction.action' => 'buyres',
                        'Transaction.txnid' => $user['User']['randomverify'],
                ),
                        'fields' => array('Transaction.status'),
                    ));
            } else {
                $this->log($i . 'nano sleeping fails', 'debug');
            }
            $i = $i + 1;
        }

        $this->User->id = $usercon['id'];
        $this->User->saveField('randomverify', '');
        $this->set('redirectioncredit', 'redirectreservation');
        $this->Session->setFlash(__d('croogo', 'Traitement de votre transaction en cours, merci de patienter quelques secondes ...'), 'flash', array('class' => 'success'));
    }
}