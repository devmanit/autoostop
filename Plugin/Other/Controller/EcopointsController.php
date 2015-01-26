<?php

App::uses('OtherAppController', 'Other.Controller');

/**
 * Ecopoints Controller 
 *
 */
class EcopointsController extends OtherAppController {

    public $uses = array('Users.User','Users.Userinfo','Contacts.Contact', 'Contacts.Message');
   

    /**
     * index method
     *
     * @return void
     */
    public function admin_index() {
         $user = $this->Auth->user();
        if($user['role_id'] == 1 || $user['role_id'] == 6){
            $ecopoint = 0;
        }else{
                    $userinfo = $this->Userinfo->findByUserId($user['id']);
                    $ecopoint = $userinfo['Userinfo']['ecopoint'];
                    $this->set('ecopoint',$ecopoint);
        }
         $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
             if ($this->Session->check('echosess')) {
                $this->Session->delete('echosess');
                $this->Session->write('echosess', $randomString);
            } else {
                $this->Session->write('echosess', $randomString);
            }
    
    $this->set('role',$user['role_id']);
    $this->set('sess',$randomString);
    } 

    /*
     * echange method 
     * change the eco point in gifts 
     */

    public function admin_echange($sess = null) {
        if($sess != null && $sess == $this->Session->read('echosess')){
        $user = $this->Auth->user();
        if($user['role_id'] == 1){
         $this->Session->setFlash(__d('croogo', 'Vous etes connectez comme administrateur'), 'flash', array('class' => 'alert'));

        }else 
        //call userinfo ecopoint
        $userinfo = $this->Userinfo->findByUserId($user['id']);
        //Eco point process
        if ($userinfo['Userinfo']['ecopoint'] < 21000) {
            //Not enaugh eco-point
            $this->Session->setFlash(__d('croogo', 'vous n\'avez pas assez d\'Eco-points'), 'flash', array('class' => 'alert'));
           
        } else {
            //recuperation contact id
            $idcontact = $this->Contact->findByTitle($user['username']);
            //Creating a message to send if the echange successed
            $this->request->data['Message']['contact_id'] = $user['id'];
            $this->request->data['Message']['name'] = 'Administration';
            $this->request->data['Message']['email'] = 'contact@autoostop.com';
            $this->request->data['Message']['title'] = 'Confirmation cadeau';
            $this->request->data['Message']['body'] = 'Bonjour ' . $user['name'] . ' suite a votre fidèlité vous avez reçue une cadeau un an de plus sur votre abonnement';
            $this->Message->create();
            if ($this->Message->save($this->request->data)) {
                $this->Session->setFlash(__d('croogo', 'vous avez reçu un an du validité de votre abonnement. Vous recevez un message de confirmation.'), 'flash', array('class' => 'success'));
                //dicreasing value of eco_point
                $eval = $userinfo['Userinfo']['ecopoint'] - 21000;
                $this->Userinfo->id = $userinfo['Userinfo']['id'];
                $this->Userinfo->saveField('ecopoint', $eval);
                //Add one year abonnement to the package of the user
                    //converting the old package to date format
                    $oldpackage = date('Y-m-d',strtotime($userinfo['Userinfo']['packageenddate']));  
                    //add one year the old package
                    $newpackage = date('Y-m-d', strtotime("+12 months", strtotime($oldpackage)));
                    //formating the new package
                    $array_explode = explode('-', $newpackage);
                    $finalpackage = array('year' => $array_explode[0],
                                                    'month' => $array_explode[1],
                                                    'day' => $array_explode[2]);
                    //saving the new package
                    $this->Userinfo->saveField('packageenddate', $finalpackage);
                }
        }
         $this->redirect(array('action' => 'index'));
        }
        else{
            $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
                $this->Croogo->redirect('/admin'); 
        }
        }
    
    
            
    
    /*
     * Echange cadeau method
     */
    public function admin_echangeadr($adrtype = null,$sess = null){
        $user = $this->Auth->user();
      if($adrtype != null && $sess != null && $sess == $this->Session->read('echosess')){
        if($user['role_id'] == 1){
         $this->Session->setFlash(__d('croogo', 'Vous etes connectez comme administrateur'), 'flash', array('class' => 'alert'));

        }else{
           
          //call userinfo ecopoint
        $userinfo = $this->Userinfo->findByUserId($user['id']);
        //Eco point process
        if ($userinfo['Userinfo']['ecopoint'] < 39000 || $userinfo['Userinfo']['ecopoint'] < 79000) {
                //Not enaugh eco-point
                $this->Session->setFlash(__d('croogo', 'vous n\'avez pas assez d\'Eco-points'), 'flash', array('class' => 'alert'));
                 $this->redirect(array('action' => 'index'));
                
            } 
        }
         $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
             if ($this->Session->check('echochange')) {
                $this->Session->delete('echochange');
                $this->Session->write('echochange', $randomString);
            } else {
                $this->Session->write('echochange', $randomString);
            }
        $this->set('adrtype' , $adrtype);
        $this->set('echorand' , $randomString);
      }else{
          $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
                $this->Croogo->redirect('/admin'); 
      }
     
        
    }
    public function admin_echangesuccess($adrtype = null,$sess = null){
        if($adrtype != null && $sess != null && $sess == $this->Session->read('echochange')){
                $user = $this->Auth->user();
                      //call userinfo ecopoint
                $userinfo = $this->Userinfo->findByUserId($user['id']);
                //Chek type of the cadeau
                if (!empty($adrtype) && $adrtype == 1) {
                    $this->request->data['Message']['body'] = 'Suite a son fidèlité Mr ' . $user['name'] .
                            ' veut echanger ces point en un <b>Carte de crédit prépayé de 10$</b>'
                            . '<br><b>Adresse: <b>'.$this->request->data['Other']['adresse'].'</b>';
                  
                } else if (!empty($adrtype) && $adrtype == 2) {
                    $this->request->data['Message']['body'] = 'Suite a son fidèlité Mr ' . $user['name'] .
                            ' veut echanger ces point en un <b>Carte de crédit prépayé de 25$</b>'
                            . '<br>Adresse: <b>'.$this->request->data['Other']['adresse'].'</b>';
                 

                } 
               // $idcontact = $this->User->find('all',array('conditions' => array('User.role_id' => 6)));
            $this->request->data['Message']['name'] = $user['name'];
            $this->request->data['Message']['email'] = $user['email'];
            $this->request->data['Message']['title'] = 'Demande d\'echange de carte cadeau';
            
                $this->request->data['Message']['contact_id'] = 1;
                 $this->Message->create();
                 $this->Message->save($this->request->data);
            
                 $this->Session->setFlash(__d('croogo', 'Votre message a ete envoyer'), 'flash', array('class' => 'success'));
                //dicreasing value of eco_point
                 if ($adrtype == 1 ) {
                $eval = $userinfo['Userinfo']['ecopoint'] - 39000;
                 }else if ($adrtype == 2){
                     $eval = $userinfo['Userinfo']['ecopoint'] - 79000;
                 }
                $this->Userinfo->id = $userinfo['Userinfo']['id'];
                $this->Userinfo->saveField('ecopoint', $eval);
              
           
        
        $this->redirect(array('action' => 'index'));
        }else{
            $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
                $this->Croogo->redirect('/admin'); 
        }
    }
}
