<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Réserver un départ');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Réserver un départ'), array('action' => 'changeaccount'));
   if($this->Session->read('Auth.User.role_id') == 5){
            //nothing to show
         }else { 
?> 

<div class="box">
    
<div class="row-fluid" >
		
                  
    <div class="span12" style="float: right">
<h3> Bonjour, <?= $this->Session->read('Auth.User.username') ?></h3>
             <h5>Votre compte est de type conducteur. Abonnez vous pour devenir passager.
            Merci.</h5> 
         <table>
                   <th>
                       <label >Votre abonnement:&nbsp;&nbsp;&nbsp;&nbsp; </label>
                   </th>
                   
                   <?php if($userdata['Userinfo']['package'] == 1){ ?>
                   <th>(6 mois)&nbsp;&nbsp;</th>
                   <th >
                       <div class="btn-group">
                       
                       
      <?= $this->Croogo->adminAction(__d('croogo', 'Confirmer'), 
              array('admin' => true,'plugin' => 'passager', 'controller' => 'subscribes','action' => 'changecond',6),
              array('class' => 'btn btn-default')); ?>
        
                      </div>
                       &nbsp;&nbsp;&nbsp;&nbsp;
                   </th>
                 <?php }   else if($userdata['Userinfo']['package'] == 0){  ?>
                       <th>(12 mois)&nbsp;&nbsp;</th>
                   <th>
                          <div class="btn-group">
                          
                   
                      
      <?= $this->Croogo->adminAction(__d('croogo', 'Confirmer'), 
              array('admin' => true,'plugin' => 'passager', 'controller' => 'subscribes','action' => 'changecond',12),
              array('class' => 'btn btn-default')); ?>
                
                      </div>
                       &nbsp;&nbsp;&nbsp;&nbsp;  
                   </th>
                   <?php } ?>
                   <th>
                 <?= $this->Html->image('ajax-loader.gif', array('class' => 'loading')); ?>
                   </th>
               </table>
    </div>

                 

</div>    

</div>

         <?php } ?>















