<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Specifications'), h($specification['Specification']['id']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Specifications'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Specification'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Specification'), array('action' => 'edit', $specification['Specification']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Specification'), array('action' => 'delete', $specification['Specification']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $specification['Specification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Specifications'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Specification'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		</ul>
	</div>
</div>

<div class="specifications view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Nom'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['nom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Updated'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
