<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Property Categories'), h($propertyCategory['PropertyCategory']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Property Categories'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Property Category'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Property Category'), array('action' => 'edit', $propertyCategory['PropertyCategory']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Property Category'), array('action' => 'delete', $propertyCategory['PropertyCategory']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $propertyCategory['PropertyCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Property Categories'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Property Category'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Property Categories'), array('controller' => 'property_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Parent Property Category'), array('controller' => 'property_categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="propertyCategories view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Parent Property Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($propertyCategory['ParentPropertyCategory']['name'], array('controller' => 'property_categories', 'action' => 'view', $propertyCategory['ParentPropertyCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Type'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Status'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Updated'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
