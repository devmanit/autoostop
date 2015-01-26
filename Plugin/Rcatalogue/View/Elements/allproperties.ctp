<table id="rideTable">
    <thead>
        <tr>
            <td class="datetime"><?php echo $this->Paginator->sort('Property.datedepart',__d('croogo', 'Date départ')); ?></td>
            <td class="datetime"><?php echo $this->Paginator->sort('PropertyAddress.province',__d('croogo', 'Lieux départ')); ?></td>
            <td class="datetime"><?php echo $this->Paginator->sort('PropertyAddress.province_des',__d('croogo', 'Lieux d\'arrivé')); ?></td>
            <td class="datetime"><?php echo $this->Paginator->sort('Property.pricedt',__d('croogo', 'Prix et Place')); ?></td>
            <td class="datetime"><?php echo $this->Paginator->sort('Property.bagage',__d('croogo', 'Voiture et Bagage')); ?></td>
            <td class="datetime"><?php echo $this->Paginator->sort('Property.spec',__d('croogo', 'Condition')); ?></td>
            <td class="datetime"><?php echo $this->Paginator->sort('Property.evaluation',__d('croogo', 'Evaluation')); ?></td>
            <td class="datetime"></td>
        </tr>
    </thead>
    <tbody>
        <?php 
            
            if(isset($properties) && !empty($properties))
            {
                echo $this->Property->renderAll($properties);
            }
                
        ?>
    </tbody>
</table>
