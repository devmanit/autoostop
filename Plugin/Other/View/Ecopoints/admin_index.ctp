
<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Avantage éco-point');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Avantage éco-point'), array('action' => 'index'));
 
?> 
 
<div class="propertyCars index">
    <div class="span12">
	<table class="table table-striped"> 
            <tr style="color: #08c">
		<th style="width: 300px">Cadeau</th>
               
                <th style="width: 500px">Nombre d'éco-points pour obtenir un cadeau</th>
           
                <th style="width: 300px">Echanger Vos Eco-points</th>
              
	</tr>
        <tr> 
            <th>Abonnement d'un an gratuit</th>
            <th style="padding-left: 10%;">21000</th>
            <th><?= $this->Html->link('Echanger',array('action' => 'admin_echange',$sess),array('tooltip' => __d('croogo', 'Evaluer ce membre')),__d('croogo', 'Vous ètes sure?'));?></th>
        </tr> 
        <tr>
            <th>Carte de crédit prépayé de 10$ </th>
            <th style="padding-left: 10%;">39000</th>
            <th><?= $this->Html->link('Echanger',array('action' => 'admin_echangeadr',1,$sess));?></th> 
        </tr>
        <tr>
            <th>Carte de crédit prépayé de 25$ </th>
            <th style="padding-left: 10%;">79000</th>
            <th><?= $this->Html->link('Echanger',array('action' => 'admin_echangeadr',2,$sess));?></th>
        </tr>
     
        
        </table>
    </div>
    <div class="span8" style="float:right">
    <?php 
    
        if($role == 1 || $role == 6){
           echo $this->Html->image('arbre-nu-green.png', array('alt' => 'Arbre Evaluation', 'style' => 'height:200px;'));
    }else{
    ?>
    
    <?php if($ecopoint < 50000){ ?>
    <?php echo $this->Html->image('arbre-nu-red.png', array('alt' => 'Arbre Evaluation', 'style' => 'height:200px;')); ?>
    <?php }else if($ecopoint > 50000 && $ecopoint < 100000){ ?>
    <?php echo $this->Html->image('arbre-nu-yellow.png', array('alt' => 'Arbre Evaluation', 'style' => 'height:200px;')); ?>
    <?php } else if($ecopoint > 100000 && $ecopoint < 150000){ ?>
    <?php echo $this->Html->image('arbre-nu-blue.png', array('alt' => 'Arbre Evaluation', 'style' => 'height:200px;')); ?>
    <?php } else if($ecopoint > 150000){ ?>
    <?php echo $this->Html->image('arbre-nu-green.png', array('alt' => 'Arbre Evaluation', 'style' => 'height:200px;')); ?>
    <?php }?>
     <p style="margin-left: 5%" ><b>Eco-point: <?= $ecopoint; ?></b></p>
    <?php
    } ?>    
       
    </div>
</div> 
 
 
