<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Property Categories'), h($car['Car']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Property Categories'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Property Category'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Property Category'), array('action' => 'edit', $car['Car']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Property Category'), array('action' => 'delete', $car['Car']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $car['Car']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Property Categories'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Property Category'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Property Categories'), array('controller' => 'cars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Parent Property Category'), array('controller' => 'cars', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="propertyCategories view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($car['Car']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'User'); ?></dt>
		<dd>
			<?php echo h($car['Car']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Marque'); ?></dt>
		<dd>
			<?php echo h($car['Car']['marque']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __d('croogo', 'Matricule'); ?></dt>
		<dd>
			<?php echo h($car['Car']['matricule']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __d('croogo', 'Année'); ?></dt>
		<dd>
			<?php echo h($car['Car']['year']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __d('croogo', 'Coleur'); ?></dt>
		<dd>
			<?php echo h($car['Car']['color']); ?>
			&nbsp;
		</dd>
		
                <dt><?php echo __d('croogo', 'Autres informations'); ?></dt>
		<dd>
			<?php echo h($car['Car']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Updated'); ?></dt>
		<dd>
			<?php echo h($car['Car']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($car['Car']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
