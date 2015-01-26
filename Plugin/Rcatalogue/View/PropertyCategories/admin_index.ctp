<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Property Categories');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Property Categories'), array('action' => 'index'));

?>

<div class="propertyCategories index">
	<table class="table table-striped">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('parent_id'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('type'); ?></th>
		<th><?php echo $this->Paginator->sort('status'); ?></th>
		<th><?php echo $this->Paginator->sort('updated'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($propertyCategories as $propertyCategory): ?>
	<tr>
		<td><?php echo h($propertyCategory['PropertyCategory']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($propertyCategory['ParentPropertyCategory']['name'], array('controller' => 'property_categories', 'action' => 'view', $propertyCategory['ParentPropertyCategory']['id'])); ?>
		</td>
		<td><?php echo h($propertyCategory['PropertyCategory']['name']); ?>&nbsp;</td>
		<td><?php echo h($propertyCategory['PropertyCategory']['type']); ?>&nbsp;</td>
		<td><?php echo h($propertyCategory['PropertyCategory']['status']); ?>&nbsp;</td>
		<td><?php echo h($propertyCategory['PropertyCategory']['updated']); ?>&nbsp;</td>
		<td><?php echo h($propertyCategory['PropertyCategory']['created']); ?>&nbsp;</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $propertyCategory['PropertyCategory']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $propertyCategory['PropertyCategory']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $propertyCategory['PropertyCategory']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $propertyCategory['PropertyCategory']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
