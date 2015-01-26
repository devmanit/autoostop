   <?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Evaluation des membres');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Evaluation des membres'), array('action' => 'index'));
?> 
  <?= $this->Form->create('Other'); ?>
<div class="span8">
        <div id="welcomeDiv" class="box" style="margin-left:350px;width:500px"> 
            <div class="box-content">
                <div class="input text">
                    <div class="properties index">
                        <table class="table table-striped">
                            <tr style="color: #08c">
                                <th>Evaluation</th>
                                <th><?php echo $this->Html->image('Sad.png', array('alt' => 'Triste','style' => 'height:50px')); ?></th>
                                <th><?php echo $this->Html->image('Glad.png', array('alt' => 'Heureux','style' => 'height:50px')); ?></th>
                                <th><?php echo $this->Html->image('Satisfied.png', array('alt' => 'Joyeux','style' => 'height:50px')); ?></th>
                            </tr>
                            <tr style="color: #08c">
                                <th> Ponctualité</th>
                                <th>
                            <?= $this->Form->radio('scoreponc', array(0 => ''), array('required' => true ,'legend' => false,'style' => 'margin-left: 20px;')); ?>  
                                </th>
                                <th>
                                    <?= $this->Form->radio('scoreponc', array('0.5' => ''), array('required' => true, 'hiddenField' => false,'legend' => false,'style' => 'margin-left: 20px;')); ?>
                                </th>
                                 <th>
                                    <?= $this->Form->radio('scoreponc', array(1 => ''), array('required' => true , 'hiddenField' => false,'legend' => false,'style' => 'margin-left: 20px;')); ?>
                                </th>
                            </tr>
                            
                            <tr style="color: #08c">
                                <th>Sécurité</th>
                                 <th>
                            <?= $this->Form->radio('scoresec', array(0 => ''), array('required' => true , 'legend' => false,'style' => 'margin-left: 20px;')); ?>  
                                </th>
                                <th>
                                    <?= $this->Form->radio('scoresec', array('0.5' => ''), array('required' => true , 'hiddenField' => false,'legend' => false,'style' => 'margin-left: 20px;')); ?>
                                </th>
                                 <th>
                                    <?= $this->Form->radio('scoresec', array(1 => ''), array('required' => true , 'hiddenField' => false,'legend' => false,'style' => 'margin-left: 20px;')); ?>
                                </th>
                            </tr>
                            <tr style="color: #08c">
                                <th>Politesse</th>
                                <th>
                            <?= $this->Form->radio('scorepol', array(0 => ''), array('required' => true , 'hiddenField' => false,'legend' => false,'style' => 'margin-left: 20px;')); ?>  
                                </th>
                                <th>
                                    <?= $this->Form->radio('scorepol', array('0.5' => ''), array('required' => true , 'hiddenField' => false,'legend' => false,'style' => 'margin-left: 20px;')); ?>
                                </th>
                                 <th>
                                    <?= $this->Form->radio('scorepol', array(1 => ''), array('required' => true , 'hiddenField' => false,'legend' => false,'style' => 'margin-left: 20px;')); ?>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
              	
           <?php echo $this->Form->end('Evaluer'); ?>
         
            </div>
        </div>
   
	
			
</div>
 
