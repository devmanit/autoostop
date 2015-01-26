<?php

App::uses('PassagerAppController', 'Passager.Controller');

/**
 * Credit Reservation Controller 
 *
 */
class SubscribesController extends PassagerAppController {

    public $uses = array('Users.User','Users.Userinfo','Users.Transaction','Contacts.Contact', 'Contacts.Message');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions[] = 'admin_subscribe';
        $this->Security->unlockedActions[] = 'admin_subsuccess';
        $this->Security->unlockedActions[] = 'admin_subpass';
        $this->Security->unlockedActions[] = 'admin_newsub';
    }
  
    /*
     * 
     * buy credit reservation
     */
     public function admin_subscribe($abon = null) {
         
         $user = $this->Auth->user();
         //generating new session
           $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
           
               //calcul of price
            if($abon != null)
            {
                  if($abon == 6)
                {
                    $prix = 4.00;
                }
                else if($abon == 12)
                {
                    $prix = 7.00;
                }
            }
            else
            {
            $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
            $this->Croogo->redirect('/admin'); 
            }
         ////abonnemtn user is  connected
            $id = $user['id'];
            $newuser = $this->User->findById($id);
             if($newuser != null )
             {
                $this->User->id = $id;
                if( $this->User->saveField('randomverify', $randomString))
                {
               
                            //redirecting for abonnement passager is connected
                        $url = $this->Transaction->requestPaypal(
                               $prix, 
                               "Abonnement $abon mois", 
                               "action=pass&uid=$id&abon=$abon&rand=$randomString",
                               4
                               );
                
                
                 
                        if ($url) 
                        {
                            $this->redirect($url);
                        }
                }
                else
                {
                  $this->Session->setFlash(__d('croogo', 'Une autre transaction est en cours'), 'flash', array('class' => 'error'));
                  $this->Croogo->redirect('/admin');  
                }
             }
    }
    
    /**
     * 
     * change type of account after abonnemet
     */
     
public function admin_subsuccess() {

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
                        'Transaction.action' => 'sub',
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
        $this->set('redirectioncredit', 'redirectlogout');
        $this->Session->setFlash(__d('croogo', 'Votre demande a été bien effectuer.Merci de se connecter à  votre nouveau compte passager'), 'flash', array('class' => 'success'));
    }

     /*
      * 
      * Subscribe of passager
      */
     
    public function admin_subpass(){
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
                        'Transaction.action' => 'pass',
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
        $this->set('redirectioncredit', 'redirectprofile');
        $this->Session->setFlash(__d('croogo', 'Transaction effectué avec succès, redirection dans quelques secondes ... !!'), 'flash', array('class' => 'success'));
    }

     /*
      * payment user is disconnected
      */
     
public function admin_newsub($uid = null, $randverif = null){
         
        $this->set('title_for_layout', __d('croogo', 'Traitement du transaction'));
        $this->layout = "admin_login";
        
         if($uid == null || !$this->User->exists($uid) || $randverif == null)
        {  
          $this->Session->setFlash(__d('croogo', 'Page introuvable ...'), 'flash', array('class' => 'success'));
          $this->redirect('/admin');
        }
        
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
                        'Transaction.clientid' => $uid,
                        'Transaction.status' => 'Completed',
                        'Transaction.action' => 'newsub',
                        'Transaction.txnid' => $randverif,
                    ),
                    'fields' => array('Transaction.status'),
                ));
            } else {
                $this->log($i . 'nano sleeping fails', 'debug');
            }
            $i = $i + 1;
        }

        $this->User->id = $uid;
        $this->User->saveField('randomverify', '');
        
        $this->set('redirectioncredit','redirectlogin');
        $this->Session->setFlash(__d('croogo', 'Traitement de votre transaction, merci de patientier quelques secondes ...'), 'flash', array('class' => 'success'));
    }     

     /*
      * 
      * 
      */
     public function admin_othersub($abon = null,$rand = null,$name = null){
         
          $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
           
               //calcul of price
            if($abon != null)
            {
                  if($abon == 6)
                {
                    $prix = 4.00;
                }
                else if($abon == 12)
                {
                    $prix = 7.00;
                }
            }
            else
            {
            $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
            $this->Croogo->redirect('/admin'); 
            }
           
            //abonnemtn user is not connected
            if($this->Session->read('abonnement') == $rand && $name !=null)
            {
             $newuser = $this->User->findByUsername($name);
             if($newuser != null )
             {
             $idd = $newuser['User']['id'];
             $this->User->id = $idd;
             
                  if($this->User->saveField('randomverify', $randomString)){
             $url = $this->Transaction->requestPaypal(
                     $prix, 
                     "Abonnement $abon mois", 
                     "action=newsub&uid=$idd&abon=$abon&rand=$randomString",
                     5
                     );  
                if ($url) 
                {
                    $this->redirect($url);
                }
             }
            
             }
             else
             {
            $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
            $this->Croogo->redirect('/admin');   
             }
         }else
             {
             throw new NotFoundException;
         }
         
       
     }
     /*
      * 
      * 
      * 
      */
     public function admin_changecond($abon = null){
         
         $user = $this->Auth->user();
         //generating new session
           $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
           
               //calcul of price
            if($abon != null)
            {
                  if($abon == 6)
                {
                    $prix = 4.00;
                }
                else if($abon == 12)
                {
                    $prix = 7.00;
                }
            }
            else
            {
            $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
            $this->Croogo->redirect('/admin'); 
            }
         ////abonnemtn user is  connected
            $id = $user['id'];
            $newuser = $this->User->findById($id);
             if($newuser != null )
             {
                $this->User->id = $id;
                
               if($this->User->saveField('randomverify', $randomString)){
                     
                    //redirecting for changing conducteur to passager
                        $url = $this->Transaction->requestPaypal(
                                   $prix, 
                                   "Abonnement $abon mois", 
                                   "action=sub&uid=$id&abon=$abon&rand=$randomString",
                                   3
                                   );  
                    if ($url) 
                        {
                            $this->redirect($url);
                        }
                }
               
             }
           
                      
     }
}
