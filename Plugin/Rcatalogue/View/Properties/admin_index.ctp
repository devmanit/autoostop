<?php
$this->Html->css('/rcatalogue/css/simplemodal.css', null, array('inline' => false));
$this->viewVars['title_for_layout'] = __d('croogo', 'Properties');
//$this->Croogo->adminScript('Rcatalogue.admin');
//add this name to edit the default button name of common view
$this->name_button = "Annoncer un départ";
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Properties'), array('action' => 'index'));

echo $this->element('admin/nodes_search');
//echo $this->Form->create('Property');
$output = '';
//debug($properties);
//die("prop");

?>

<div class="properties index">
	<table class="table table-striped">
	<tr>
                <th></th>
		<th><?php echo $this->Paginator->sort('datedepart',__d('croogo', 'Date départ')); ?></th>
		<th><?php echo $this->Paginator->sort('heuredepart',__d('croogo', 'Heure départ')); ?></th>
                <th><?php echo $this->Paginator->sort('PropertyAddress.0.province',__d('croogo', 'Lieu de départ')); ?></th>
                <th><?php echo $this->Paginator->sort('PropertyAddress.0.province_des',__d('croogo', 'Lieu d\'arrivé')); ?></th>
                <th><?php echo $this->Paginator->sort('pricedt',__d('croogo', 'Prix')); ?></th>
                <th><?php echo $this->Paginator->sort('bagage',__d('croogo', 'Voiture et Bagage')); ?></th>
		<th><?php echo $this->Paginator->sort('rooms',__d('croogo', 'Nombre de places')); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($properties as $key => $property):
            $propnumber = $key+($this->request->params['paging']['Property']['page']*10-10);
        
        if(new DateTime($property['Property']['datedepart'])<= new DateTime("now")):
        ?>
	<tr class="departurepassed">
        <?php else :?><tr> <?php endif; ?>
                <td><?php  echo h($propnumber); ?></td>
                <td><?php echo h($property['Property']['jourdepart']).' '.h($property['Property']['datedepart']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['heuredepart']); ?>&nbsp;</td>
                <td><?php echo h($property['PropertyAddress'][0]['country']).' - '.h($property['PropertyAddress'][0]['province']); ?>&nbsp;</td>
                <td><?php echo h($property['PropertyAddress'][0]['country_des']).' - '.h($property['PropertyAddress'][0]['province_des']); ?>&nbsp;</td>
                <td><?php echo h($property['Property']['pricedt']); ?>&nbsp;</td>
		<td><?php 
                    if($property['Property']['bagage'] == 'petit'){
                        echo '<span>'.$property['Car']['marque'].'</span><br/>'.$this->Html->image('/croogo/img/layout/bagage-petit.png', array('style' => 'height:20px;'));
                    }
                    else if($property['Property']['bagage'] == 'moyen'){
                        echo '<span>'.$property['Car']['marque'].'</span><br/>'.$this->Html->image('/croogo/img/layout/bagage-moyen.png', array('style' => 'height:20px;'));
                    }
                    else if($property['Property']['bagage'] == 'grand')
                    {
                        echo '<span>'.$property['Car']['marque'].'</span><br/>'.$this->Html->image('/croogo/img/layout/bagage-grand.png', array('style' => 'height:20px;'));
                    }
                ?>&nbsp;</td>
                <td><?php
                if(($property['Property']['reserved'] != 0) && (new DateTime($property['Property']['datedepart'])> new DateTime("now")))
                {
                    echo $this->Html->link($property['Property']['reserved'].'/'.$property['Property']['rooms'].' places', '#modal-prop' . $property['Property']['id']); 
                }
                else
                {
                    echo h($property['Property']['reserved'].'/'.$property['Property']['rooms'].' places');  
                }
                ?>&nbsp;</td>
		<td class="item-actions">
                        
			<?php 
                        if(new DateTime($property['Property']['datedepart'])<= new DateTime("now")){
                            echo '<b>Etat : Passé</b>';
                        }
                        else
                        {
                           echo $this->Croogo->adminRowAction('', array('action' => 'edit', $property['Property']['id']), array('icon' => 'eye-open'));
                           echo $this->Croogo->adminRowAction('', array('action' => 'delete', $property['Property']['id']), array('icon' => 'remove-sign', 'escape' => true), __d('croogo', 'Etes vous certains d\'annuler le départ numéro  # %s?', $propnumber)); 
                        }
                         ?>
		</td>
	</tr>
        <?php
         if($property['Property']['reserved'] != 0)
         {
            $this->propforelement = $property;
            $output .=$this->element('admin/modalinfopassager');
         }
        ?> 
<?php endforeach; ?>
	</table>
        
        <?php 
        echo $output;
      //  echo $this->Form->end(__d('croogo', 'Submit'));
        ?>
</div>
