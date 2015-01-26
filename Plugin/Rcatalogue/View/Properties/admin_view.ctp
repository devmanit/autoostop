<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Properties'), h($property['Property']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Properties'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Property'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Property'), array('action' => 'edit', $property['Property']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Property'), array('action' => 'delete', $property['Property']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $property['Property']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Properties'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Property'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Property Categories'), array('controller' => 'property_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Property Category'), array('controller' => 'property_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Property Addresses'), array('controller' => 'property_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Property Address'), array('controller' => 'property_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Property Images'), array('controller' => 'property_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Property Image'), array('controller' => 'property_images', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="properties view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($property['Property']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Reference'); ?></dt>
		<dd>
			<?php //echo h($property['Property']['reference']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Property Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($property['PropertyCategory']['name'], array('controller' => 'property_categories', 'action' => 'view', $property['PropertyCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($property['Property']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Pstatus'); ?></dt>
		<dd>
			<?php echo h($property['Property']['pstatus']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Size'); ?></dt>
		<dd>
			<?php echo h($property['Property']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Rooms'); ?></dt>
		<dd>
			<?php echo h($property['Property']['rooms']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Pricedt'); ?></dt>
		<dd>
			<?php echo h($property['Property']['pricedt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Priceeuro'); ?></dt>
		<dd>
			<?php echo h($property['Property']['priceeuro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Description'); ?></dt>
		<dd>
			<?php echo h($property['Property']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Status'); ?></dt>
		<dd>
			<?php echo h($property['Property']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Updated'); ?></dt>
		<dd>
			<?php echo h($property['Property']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($property['Property']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
