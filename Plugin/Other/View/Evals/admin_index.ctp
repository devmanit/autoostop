<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Evaluation des membres');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Evaluation des membres'), array('action' => 'index'));
   if($role == 4){
            //nothing to show
         }else { 
?> 
<div class="properties index">
   
    <table class="table table-striped">
        <tr>
                        <th><?php echo $this->Paginator->sort('datedepart', __d('croogo', 'Date départ')); ?></th>
            <th><?php echo $this->Paginator->sort('heuredepart', __d('croogo', 'Heure départ')); ?></th>
            <th><?php echo $this->Paginator->sort('PropertyAddress.0.province', __d('croogo', 'Lieu de départ')); ?></th>
            <th><?php echo $this->Paginator->sort('PropertyAddress.0.province_des', __d('croogo', 'Lieu d\'arrivé')); ?></th>

            <th><?php echo $this->Paginator->sort('name', __d('croogo', 'Nom du conducteur')); ?></th>
            <th><?php echo $this->Paginator->sort('pricedt', __d('croogo', 'Prix et place')); ?></th>
            <th><?php echo $this->Paginator->sort('bagage', __d('croogo', 'Voiture et Bagage')); ?></th>
            <th>Actions</th>
        </tr>
      
<?php foreach ($properties as $key => $property): ?>
        <?php if($property['Property']['eval'] == 0){ ?>
            <tr>
                                <td><?php echo h($property['Property']['datedepart']); ?>&nbsp;</td>
                <td><?php echo h($property['Property']['heuredepart']); ?>&nbsp;</td>
                <td><?php echo h($property['PropertyAddress'][0]['country']) . ' - ' . h($property['PropertyAddress'][0]['province']); ?>&nbsp;</td>
                <td><?php echo h($property['PropertyAddress'][0]['country_des']) . ' - ' . h($property['PropertyAddress'][0]['province_des']); ?>&nbsp;</td>

                <td><?php echo h($property['User']['name']).' '.h($property['User']['surname']); ?>&nbsp;</td>
                <td><?php echo h($property['Property']['pricedt']).' $<br>'.h($property['Property']['rooms'].' places'); ?>&nbsp;</td>
                <td><?php
        if ($property['Property']['bagage'] == 'petit') {
            echo '<span>' . $property['Car']['marque'] . '</span><br/>' . $this->Html->image('/croogo/img/layout/bagage-petit.png', array('style' => 'height:20px;'));
        } else if ($property['Property']['bagage'] == 'moyen') {
            echo '<span>' . $property['Car']['marque'] . '</span><br/>' . $this->Html->image('/croogo/img/layout/bagage-moyen.png', array('style' => 'height:20px;'));
        } else if ($property['Property']['bagage'] == 'grand') {
            echo '<span>' . $property['Car']['marque'] . '</span><br/>' . $this->Html->image('/croogo/img/layout/bagage-grand.png', array('style' => 'height:20px;'));
        }
    ?>&nbsp;</td>
                <?php if($property['Property']['active']){?>
                <td >
                    
                    <?= $this->Html->link('Evaluer les membres' ,array('action' => 'admin_evaluer',$property['Property']['id'],$evalsess)); ?>	
                    
                </td>
                <?php }else{ ?>
                  <td >
                      <a style="pointer-events: none;cursor: default;">Evaluer les membres</a>
                      <p>Lien disponible aprés <?= $property['Property']['inter']->d ?> jour et <?= $property['Property']['inter']->h ?> heures</p>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
<?php endforeach; ?>
    </table>
    
         <?php } ?>
     
</div>

