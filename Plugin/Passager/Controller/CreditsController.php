<?php

App::uses('PassagerAppController', 'Passager.Controller');

/**
 * Credit Reservation Controller 
 *
 */
class CreditsController extends PassagerAppController {
 public $components = array('Paginator');
    public $uses = array('Users.User','Users.Userinfo','Users.Transaction','Contacts.Contact', 'Contacts.Message');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions[] = 'admin_buy';
       $this->Security->unlockedActions[] = 'admin_index';
       
       $this->Security->unlockedActions[] = 'admin_addsuccess';
    }
  

    /**
     * index method
     *
     * @return void
     */
    public function admin_index() {

       $user = $this->Session->read('Auth.User');
             $this->Paginator->settings = array(
                'conditions' => array('Userinfo.user_id' => $user['id']),
              
            );
    $data = $this->Paginator->paginate('Userinfo');
   
       $this->set('data' ,$data);
        
    }
    /*
     * 
     * buy credit reservation
     */
     public function admin_buy($link = null) {
         
         $user = $this->Auth->user();
         $id = $user['id'];
         if(!$user){
                     $this->render(array('action' => 'index'));
         }
       $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
          
             //chaek if the session 
//            if ($this->Session->check('charrandom')) {
//                $this->Session->delete('charrandom');
//                $this->Session->write('charrandom', $randomString);
//                //Configure::write('Credits',$randomString);
//            } else {
//                $this->Session->write('charrandom', $randomString);
//               // Configure::write('Credits',$randomString);
//            }
            
        //save random string in dtaabase
             $userinf = $this->User->findById($id); 
            $this->User->id  = $id;
           
     
            if($this->User->saveField('randomverify', $randomString))
            {
                if ($link == 1) {
                    $prix = 3.93;
                } else if ($link == 2) {
                    $prix = 23.58;
                } else if ($link == 3) {
                    $prix = 34.30;
                } else if ($link == 4) {
                    $prix = 74.95;
                } else {
                    $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
                    $this->Croogo->redirect('/admin');
                }
                $url = $this->Transaction->requestPaypal($prix,
                        "Crédit de réservation", 
                        "action=buy&uid=$id&rand=$randomString",
                        1);
                if ($url) {
                    $this->redirect($url);
                }
            }
        
    }
    public function admin_addsuccess(){
         $usercon = $this->Session->read('Auth.User');
         $this->User->recursive = -1;
         $user = $this->User->findById($usercon['id']);
         
        $iscomp = null;
        $i = 0;
        while($iscomp == null || empty($iscomp))
        {
        // Et ceci est la meilleur façon :
        $nano = time_nanosleep(5, 100000);
        
        if($i > 100)
        {
            break;
        }
        if($nano === true)
        {
            $this->Transaction->recursive = -1;
            $iscomp = $this->Transaction->find('first',array('conditions' => array(
                        'Transaction.clientid' => $usercon['id'],
                        'Transaction.status' => 'Completed',
                        'Transaction.action' => 'buy',
                        'Transaction.txnid' => $user['User']['randomverify'],
                    )));
            $this->log($i.' Start- Credits add success','debug');
            $this->log($iscomp,'debug');
            $this->log($i.' Finish- Credits add success','debug');
            
        }
        else
        {
           $this->log($i.'nano sleeping fails','debug'); 
        }
        $i = $i +1;
        }
        
       $this->User->id = $usercon['id'];
       $this->User->saveField('randomverify', '') ;
      $this->set('redirectioncredit','redirectcredits');
      $this->Session->setFlash(__d('croogo', 'Transaction effectué avec succès, redirection dans 5 seconds ... !!'), 'flash', array('class' => 'success'));
        
    }
}
