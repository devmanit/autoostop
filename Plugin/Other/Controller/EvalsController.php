<?php

App::uses('OtherAppController', 'Other.Controller');

/**
 * Evaluation Controller 
 *
 */
class EvalsController extends OtherAppController {/**
 * Components
 *
 * @var array
 */

    public $components = array('Paginator', 'Security', 'RequestHandler');
    public $uses = array('Rcatalogue.Property', 'Rcatalogue.Car',
        'Rcatalogue.PropertyAddress', 'Rcatalogue.Rcatalogueattachment',
        'Contacts.Contact', 'Contacts.Message', 'Rcatalogue.Specification', 'Menus.Link', 'Users.User', 'Users.Userinfo');

    /**
     * index method
     *
     * @return void
     */
    public function admin_index() {
        $user = $this->Session->read('Auth.User');
        $userres = $this->User->findById($user['id']);
        $idproperty = explode(',', $userres['User']['property_id']);
        $eval = explode(',', $userres['User']['evaluer']);
        //only for passager
       
        
        $this->Paginator->settings = array(
            'contain' => array('Car', 'PropertyAddress', 'User'),
            'joins' => array(
                array(
                    'table' => 'property_addresses',
                    'alias' => 'PropertyAddress',
                    'conditions' => array(
                        array('Property.id' => $idproperty),
                        
                        'Property.user_id !=' . $user['id'],
                    )
                )
            ),
            'group' => 'Property.id',
            'limit' => 10
        );
        
        $properties = null;
        //paginate all properties
        if (empty($this->request->data)) {
            if ($this->Session->check('criteria')) {
                $critecond = (array) $this->Session->read('criteria');
                $properties = $this->Paginator->paginate($critecond);
            } else {
                $properties = $this->Paginator->paginate();
            }
        }

        //descativation links only after 2hr
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
                if ($inter->h < 2 && $inter->invert == 1) {
                    $active = false;
                } else {
                    $active = true;
                } 
            }
            
            $properties[$key]['Property']['active'] = $active;
            $properties[$key]['Property']['inter'] = $inter;
            $properties[$key]['Property']['eval'] = $eval[$key];
        }
       
        $characters = '0123456789abcdefghijklmnopqrstuvwyzABCDEFGHJKLMOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
             if ($this->Session->check('evalsess')) {
                $this->Session->delete('evalsess');
                $this->Session->write('evalsess', $randomString);
            } else {
                $this->Session->write('evalsess', $randomString);
            }
        $this->set('properties', $properties);
        $this->set('eval', $eval);
         $this->set('evalsess', $randomString);
         $this->set('role', $userres['User']['role_id']);
    }

    /**
     * evaluation memebre method
     *
     * @return void
     */
    public function admin_evaluer($iddep = null,$sess = null) {
        if($iddep != null && $sess != null && $sess = $this->Session->read('evalsess')){
        $user = $this->Session->read('Auth.User');
        //find user of this depart
        if ($this->request->is('post')) {
            $userdepart = $this->Property->findById($iddep);
            if (!empty($userdepart)) {
                $userinfo = $this->Userinfo->findByUserId($userdepart['User']['id']);
                if (!empty($userinfo)) {
                    $ponc = $this->request->data['Other']['scoreponc'];
                    $sec = $this->request->data['Other']['scoresec'];
                    $pol = $this->request->data['Other']['scorepol'];
                    //converting value to float
                    if ($ponc == '0.5' || $sec == '0.5' || $pol == '0.5') {
                        $ponc = floatval($ponc);
                        $sec = floatval($sec);
                        $pol = floatval($pol);
                    }
                    //at list a one evaluation must be cheked
                    if ($ponc == null && $sec == null && $pol == null) {
                        $this->Session->setFlash(__d('croogo', 'Vous devez choisir au moins une evaluation'), 'flash', array('class' => 'alert'));
                        $this->redirect(array('action' => 'index'));
                    } else {

                        $countsec = $userinfo['Userinfo']['countsec'] + 1;
                        $countpol = $userinfo['Userinfo']['countpol'] + 1;
                        $countponc = $userinfo['Userinfo']['countponc'] + 1;
                        $notpol = $userinfo['Userinfo']['notepol'] + $pol;
                        $notponc = $userinfo['Userinfo']['noteponc'] + $ponc;
                        $notsec = $userinfo['Userinfo']['notesec'] + $sec;
                    }
                    
                    $this->Userinfo->id = $userinfo['Userinfo']['id'];
                    $userinfodata['Userinfo'] = array(
                                        'countsec' =>$countsec,
                                        'countpol'=> $countpol,
                                        'countponc'=> $countponc,
                                        'notepol'=> $notpol,
                                        'noteponc'=> $notponc,
                                        'notesec'=> $notsec
                            );
                    if($this->Userinfo->save($userinfodata)){
                  
                    //add eco_point
                    $userinf = $this->Userinfo->findByUserId($user['id']);
                     $eval = $userinf['Userinfo']['ecopoint'] + 75;
                     $this->Userinfo->id = $userinf['Userinfo']['id'];
                    $this->Userinfo->saveField('ecopoint', $eval);
                    //changin stat of the depart to evaluer
                    $tabuser = $this->User->findById($user['id']);
                    $idproperty = explode(',', $tabuser['User']['property_id']);
                    $evaluarray = explode(',', $tabuser['User']['evaluer']);
                    $arraytotaldep = array_combine($idproperty, $evaluarray);
                    if($arraytotaldep[$iddep] == 0){
                        $arraytotaldep[$iddep] = 1;
                    }
                    $neweavl = implode(',', $arraytotaldep);
                    $this->User->id = $user['id'];
                    $this->User->saveField('evaluer',$neweavl);
                     
             $this->Session->setFlash(__d('croogo', 'Merci pour votre évaluation de nos conducteurs.Vous avez recue 75 éco-point'), 'flash', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
                    }
                } else {
                    $this->Session->setFlash(__d('croogo', 'Le départ demandés n\'existe plus'), 'flash', array('class' => 'alert'));
                }
            }
            
          
        }
        }else{
             $this->Session->setFlash(__d('croogo', 'Page introuvable'), 'flash', array('class' => 'error'));
                $this->Croogo->redirect('/admin'); 
        }
    }
    
    /*
     * 
     * change type of compte 
     */
    public function admin_changeaccount(){
    
    $userdata = $this->Userinfo->findByUserId($this->Session->read('Auth.User.id'));
    $this->set('userdata',$userdata);
    }
}
