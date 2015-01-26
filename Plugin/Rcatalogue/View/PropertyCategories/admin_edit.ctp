<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Property Categories');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Property Categories'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['PropertyCategory']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Property Categories: ' . $this->data['PropertyCategory']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('PropertyCategory');

?>
<div class="propertyCategories row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Property Category'), '#property-category');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='property-category' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('parent_id', array(
					'label' => 'Parent Id',
				));
				echo $this->Form->input('name', array(
					'label' => 'Name',
				));
				echo $this->Form->input('type', array(
					'options' => array(
                                            'vente' => 'Vente',
                                            'location' => 'Location'),
					'empty' => __d('croogo', 'Choisir le type du catégorie')
				));
			?>
			</div>
			<?php echo $this->Croogo->adminTabs(); ?>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox('') .
			$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
			$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			'<hr />' .
                        '<table class="table table-striped" style="width:100%;">
                            <tr>
                                    <th>Location Annuelle</th>
                                    <th>Location Vacances</th>
                                    <th>Active ?</th>
                            </tr>
                            <tr>
                                <td>' .
                        $this->Form->input('PropertyCategory.annual_rental', array(
                           'class' => false,
                           'style' => 'margin-left:5%;',
                       )) .
                        '</td>                                            <td>' .
                        $this->Form->input('PropertyCategory.vacation_rental', array(
                           'class' => false,
                           'style' => 'margin-left:5%;',
                       )) .
                        '</td>                             <td>' .
                        $this->Form->input('PropertyCategory.status', array(
                           'class' => false,
                           'style' => 'margin-left:5%;',
                       )) .
                        '</td>
                            </tr>
                        </table>' .
                        $this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
