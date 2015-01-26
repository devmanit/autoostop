<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Ajouter voiture');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Mes voitures'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Car']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Mes voitures: ' . $this->data['Car']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Ajouter'), '/' . $this->request->url);
}

echo $this->Form->create('Car');

?>
<div class="propertyCategories row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Ajouter une voiture'), '#property-category');
			echo $this->Croogo->adminTabs();
		?>
		</ul>
                
		<div class="tab-content">
			<div id='property-category' class="tab-pane">
			<?php
                                
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				
                                echo $this->Form->hidden('user_id', array(
					'value' => $useridsession,
				));
                              
                             
                                ?>
                            <div class="input text">
                            <table>
                                <tr>
                                <th>
                                    <?= $this->Form->radio('type',array(0 => '')) ?>
                                </th>
                                <th style="width: 117px">
                                    <label for="type">Votre véhicule</label>
                                </th>
                                
                                <th style="width: 39px">
                                    <?= $this->Form->radio('type',array(1 => '')) ?>
                                </th>
                                <th>
                                    <label for="type">Une véhicule de location</label>
                                </th>
                                </tr>
                            </table>
                            </div>
                            <?php
                                echo $this->Form->input('marque', array(
					'label' => 'Marque & Modèle',
				));
                                echo $this->Form->input('matricule', array(
					'label' => 'Matricule',
				));
                                  $out = '';
                                for($i=2015;$i>=1980;$i--){
                                    $out .= $i.',';
                                }
                                $out = explode(',', $out);
                                $year = array_combine($out, $out);
                                echo ' <label for="year" class="input text">Année</label>' ;
				echo $this->Form->input('year',array('options' => $year), array(
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
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			
                        $this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
