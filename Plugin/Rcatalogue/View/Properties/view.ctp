<div class="properties view">
<h2><?php echo __('Property'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($property['Property']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Reference'); ?></dt>
		<dd>
			<?php echo h($property['Property']['reference']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Property Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($property['PropertyCategory']['name'], array('controller' => 'property_categories', 'action' => 'view', $property['PropertyCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($property['Property']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pstatus'); ?></dt>
		<dd>
			<?php echo h($property['Property']['pstatus']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($property['Property']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rooms'); ?></dt>
		<dd>
			<?php echo h($property['Property']['rooms']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pricedt'); ?></dt>
		<dd>
			<?php echo h($property['Property']['pricedt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priceeuro'); ?></dt>
		<dd>
			<?php echo h($property['Property']['priceeuro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($property['Property']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($property['Property']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($property['Property']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($property['Property']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Property'), array('action' => 'edit', $property['Property']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Property'), array('action' => 'delete', $property['Property']['id']), null, __('Are you sure you want to delete # %s?', $property['Property']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Categories'), array('controller' => 'property_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Category'), array('controller' => 'property_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Addresses'), array('controller' => 'property_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Address'), array('controller' => 'property_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Images'), array('controller' => 'property_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Image'), array('controller' => 'property_images', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Property Addresses'); ?></h3>
	<?php if (!empty($property['PropertyAddress'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Property Id'); ?></th>
		<th><?php echo __('Line Address'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('Country'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($property['PropertyAddress'] as $propertyAddress): ?>
		<tr>
			<td><?php echo $propertyAddress['id']; ?></td>
			<td><?php echo $propertyAddress['property_id']; ?></td>
			<td><?php echo $propertyAddress['line_address']; ?></td>
			<td><?php echo $propertyAddress['city']; ?></td>
			<td><?php echo $propertyAddress['country']; ?></td>
			<td><?php echo $propertyAddress['description']; ?></td>
			<td><?php echo $propertyAddress['updated']; ?></td>
			<td><?php echo $propertyAddress['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'property_addresses', 'action' => 'view', $propertyAddress['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'property_addresses', 'action' => 'edit', $propertyAddress['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'property_addresses', 'action' => 'delete', $propertyAddress['id']), null, __('Are you sure you want to delete # %s?', $propertyAddress['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Property Address'), array('controller' => 'property_addresses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Property Images'); ?></h3>
	<?php if (!empty($property['PropertyImage'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Property Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Path'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($property['PropertyImage'] as $propertyImage): ?>
		<tr>
			<td><?php echo $propertyImage['id']; ?></td>
			<td><?php echo $propertyImage['property_id']; ?></td>
			<td><?php echo $propertyImage['name']; ?></td>
			<td><?php echo $propertyImage['size']; ?></td>
			<td><?php echo $propertyImage['type']; ?></td>
			<td><?php echo $propertyImage['path']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'property_images', 'action' => 'view', $propertyImage['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'property_images', 'action' => 'edit', $propertyImage['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'property_images', 'action' => 'delete', $propertyImage['id']), null, __('Are you sure you want to delete # %s?', $propertyImage['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Property Image'), array('controller' => 'property_images', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
