<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Property Categories');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Property Categories'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Car']['marque'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Property Categories: ' . $this->data['Car']['marque'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('Car');

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
				
                                echo $this->Form->input('marque', array(
					'label' => 'Marque & Modèle',
				));
                                echo $this->Form->input('matricule', array(
					'label' => 'Matricule',
				));
				echo $this->Form->input('year', array(
					'label' => 'Année',
				));
				echo $this->Form->input('color', array(
					'label' => 'Coleur',
				));
				echo $this->Form->input('description', array(
					'label' => 'Autres informations du véhicule',
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
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')).
                        $this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
