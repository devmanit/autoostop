<div class="propertyCategories view">
<h2><?php echo __('Property Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Property Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($propertyCategory['ParentPropertyCategory']['name'], array('controller' => 'property_categories', 'action' => 'view', $propertyCategory['ParentPropertyCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($propertyCategory['PropertyCategory']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Property Category'), array('action' => 'edit', $propertyCategory['PropertyCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Property Category'), array('action' => 'delete', $propertyCategory['PropertyCategory']['id']), null, __('Are you sure you want to delete # %s?', $propertyCategory['PropertyCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Categories'), array('controller' => 'property_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Property Category'), array('controller' => 'property_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Property Categories'); ?></h3>
	<?php if (!empty($propertyCategory['ChildPropertyCategory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($propertyCategory['ChildPropertyCategory'] as $childPropertyCategory): ?>
		<tr>
			<td><?php echo $childPropertyCategory['id']; ?></td>
			<td><?php echo $childPropertyCategory['parent_id']; ?></td>
			<td><?php echo $childPropertyCategory['name']; ?></td>
			<td><?php echo $childPropertyCategory['type']; ?></td>
			<td><?php echo $childPropertyCategory['status']; ?></td>
			<td><?php echo $childPropertyCategory['updated']; ?></td>
			<td><?php echo $childPropertyCategory['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'property_categories', 'action' => 'view', $childPropertyCategory['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'property_categories', 'action' => 'edit', $childPropertyCategory['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'property_categories', 'action' => 'delete', $childPropertyCategory['id']), null, __('Are you sure you want to delete # %s?', $childPropertyCategory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Property Category'), array('controller' => 'property_categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
