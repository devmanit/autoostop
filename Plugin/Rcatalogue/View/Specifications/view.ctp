<div class="specifications view">
<h2><?php echo __('Specification'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nom'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['nom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($specification['Specification']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Specification'), array('action' => 'edit', $specification['Specification']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Specification'), array('action' => 'delete', $specification['Specification']['id']), null, __('Are you sure you want to delete # %s?', $specification['Specification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Specifications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specification'), array('action' => 'add')); ?> </li>
	</ul>
</div>
