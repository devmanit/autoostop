<div class="propertyCategories view">
<h2><?php echo __('Property Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($car['Car']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Property Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($car['ParentCar']['name'], array('controller' => 'cars', 'action' => 'view', $car['ParentCar']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($car['Car']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($car['Car']['type']); ?>
			&nbsp;
		</dd>
		
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($car['Car']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($car['Car']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Property Category'), array('action' => 'edit', $car['Car']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Property Category'), array('action' => 'delete', $car['Car']['id']), null, __('Are you sure you want to delete # %s?', $car['Car']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Categories'), array('controller' => 'cars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Property Category'), array('controller' => 'cars', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Property Categories'); ?></h3>
	<?php if (!empty($car['ChildCar'])): ?>
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
	<?php foreach ($car['ChildCar'] as $childCar): ?>
		<tr>
			<td><?php echo $childCar['id']; ?></td>
			<td><?php echo $childCar['parent_id']; ?></td>
			<td><?php echo $childCar['name']; ?></td>
			<td><?php echo $childCar['type']; ?></td>
			<td><?php echo $childCar['status']; ?></td>
			<td><?php echo $childCar['updated']; ?></td>
			<td><?php echo $childCar['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'cars', 'action' => 'view', $childCar['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'cars', 'action' => 'edit', $childCar['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'cars', 'action' => 'delete', $childCar['id']), null, __('Are you sure you want to delete # %s?', $childCar['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Property Category'), array('controller' => 'cars', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
