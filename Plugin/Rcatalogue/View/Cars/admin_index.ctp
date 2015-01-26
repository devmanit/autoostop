<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Mes voitures');
//add this name to edit the default button name of common view
if(count($propertyCars)<5)
{
 $this->name_button = "Ajouter";   
}else
{
   $this->name_button = "CarFull";  
}

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Mes voitures'), array('action' => 'index'));
?>

<div class="alert alert-info">
    <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Autoostop-Info!</strong>
    Vous ne pouvez ajouter que 5 voitures
</div>
<div class="progress progress-striped">
    <div class="bar" style="width: <?= count($propertyCars)*20 ?>%;"></div>
</div>
<div class="propertyCars index">
	<table class="table table-striped">
	<tr>
		<th></th>
                <?php if($isAdmin == 1):?>
		<th><?php echo $this->Paginator->sort('user_id'); ?></th>
                <?php endif; ?>
                
                <th><?php echo $this->Paginator->sort('marque'); ?></th>
                <th><?php echo $this->Paginator->sort('matricule'); ?></th>
                <th><?php echo $this->Paginator->sort('year'); ?></th>
                <th><?php echo $this->Paginator->sort('color'); ?></th>
                <th><?php echo $this->Paginator->sort('type'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
                 
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
               
	</tr>
        
	<?php foreach ($propertyCars as $key => $car): ?>
	<tr>
		<td><?php echo $key; ?>&nbsp;</td>
                <?php if($isAdmin == 1):?>
		<td><?php echo h($car['Car']['user_id']); ?>&nbsp;</td>
                <?php endif; ?>
		<td><?php echo h($car['Car']['marque']); ?>&nbsp;</td>
                <td><?php echo h($car['Car']['matricule']); ?>&nbsp;</td>
                <td><?php echo h($car['Car']['year']); ?>&nbsp;</td>
                <td><?php echo h($car['Car']['color']); ?>&nbsp;</td>
                <td><?php echo h($car['Car']['type']); ?>&nbsp;</td>
		<td><?php echo h($car['Car']['created']); ?>&nbsp;</td>
                
		<td class="item-actions">
                        <?php if($isAdmin == 1):?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $car['Car']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $car['Car']['id']), array('icon' => 'pencil')); ?>
<?php endif; ?>
                                  <?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $car['Car']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $car['Car']['marque'])); ?>
   
		</td>
                
                    

	</tr>
<?php endforeach; ?>
	</table>
</div>
