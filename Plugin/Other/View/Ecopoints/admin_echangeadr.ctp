<div class="box">
    
<div class="row-fluid" >
		
                  
    <div class="span12" style="float: right">

            <?= $this->Form->create('Other', 
                array('url' => array('plugin' => 'other',
                                     'controller' => 'ecopoints',
                                     'action' => 'admin_echangesuccess',
                                        $adrtype,$echorand))); ?> 
        <?= $this->Form->input('adresse', array('required' => true,'label' => false,'placeholder' => __d('croogo', 'Entrer votre adresse pour recevoir le cadeau'),)); ?>                    
       
                             
    </div>

                    <div class="span8" style="float: right">
 <?php echo $this->Form->end('Soumettre ma demande',array('div' => false ,'class' => 'btn btn-primary')); ?>
                    </div>
                 

</div>    

</div>