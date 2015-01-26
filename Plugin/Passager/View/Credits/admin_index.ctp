<?= $this->Session->flash(); ?>
<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Crédit de réservation');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Crédit de réservation'), array('action' => 'index'));
 
?> 
   <div class="box">
        <div class="box-title">
            <p>
                Crédits de réservations : <b><?= $data[0]['Userinfo']['credit']  ?> Réservation(s)</b> 
            </p>  
        </div>
    </div> 
<div class="propertyCars index">
    <div class="span12">
	<table class="table table-striped"> 
        <tr> 
            <th>1 réservation</th>
            <th style="padding-left: 10%;">3.93$</th>
            <th><?= $this->Html->link($this->Html->image("/passager/img/pay.png"),array('admin' => true,'action' => 'buy',1));?></th>
        </tr> 
         <tr> 
            <th>7 réservations</th>
            <th style="padding-left: 10%;">23.58$</th>
            <th><?= $this->Html->link($this->Html->image("/passager/img/pay.png"),array('admin' => true,'action' => 'buy',2));?></th>
        </tr> 
         <tr> 
            <th>10 réservations</th>
            <th style="padding-left: 10%;">34.30$</th>
            <th><?= $this->Html->link($this->Html->image("/passager/img/pay.png"),array('admin' => true,'action' => 'buy',3));?></th>
        </tr>
         <tr> 
            <th>25 réservations</th>
            <th style="padding-left: 10%;">74.95$</th>
            <th><?= $this->Html->link($this->Html->image("/passager/img/pay.png"),array('admin' => true,'action' => 'buy',4));?></th>
        </tr> 
         <tr> 
            <th>Plus de 25 réservations</th>
            <th style="padding-left: 10%;">Appelez-nous</th>
            <th>418 905 2886</th>
        </tr> 
        </table>
    </div>
 
</div> 
 
 
