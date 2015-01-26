<div class="row">
    <div class="col-sm-12 no-padding ">
        <br />	
        <div id="showcase-loader">

        </div>
        <div id="owl-demo" class="owl-carousel owl-theme" style="display: none;">

            <?php
            if (!empty($property['Node'])) {
                foreach ($property['Node'] as $index => $node) {
                    ?>
                    <div class="item">
                        
                        <?php
                        $image_path = $node['path'];
                        echo $this->Html->image($image_path, array('alt' => '', 'class' => 'img-polaroid image_resizing'));
                        ?>
                    </div>
                <?php
                }
            } else {
                $image_path = '/uploads/bien-immobilier-sans-image.jpg';
                echo $this->Html->image($image_path, array('alt' => '', 'class' => 'img-polaroid image_resizing'));
            }
            ?>

        </div>
    </div>
    <div class="col-sm-9 col-xs-3">
        <br />	
        <div id="owl-thumbnails" style="display: none;">
            <div class="col-xs-1">
                <div class="showcase-thumbnail-button-backward owl-prev" style="float: left;"><span class="showcase-thumbnail-horizontal"><span>Left</span></span></div>
            </div>
            <div class="col-xs-10">
                <div id="owl-gallery" class="owl-carousel owl-theme">

                    <?php
                    if (!empty($property['Node'])) {
                        foreach ($property['Node'] as $index => $node) {
                            ?>
                            <div class="item">
                                <?php
                                echo $this->Html->link($this->Html->image($node['path'], array('alt' => '', 'class' => 'img-polaroid')), '#', array('data-slide' => $index, 'escape' => false));
                                ?>
                            </div>
                        <?php
                        }
                    } else {
                        $image_path = '/uploads/bien-immobilier-sans-image.jpg';
                        echo $this->Html->image($image_path, array('alt' => '', 'class' => 'img-polaroid'));
                    }
                    ?>

                </div>
            </div>
            <div class="col-xs-1">
                <div class="showcase-thumbnail-button-forward owl-next" style="float: left;"><span class="showcase-thumbnail-horizontal"><span>Left</span></span></div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-3">
        <?php
        //Verfier si proprite a une image ou non
    if (isset($property['Node'][0]['path']) && $property['Node'][0]['path'] != null){
        $img=$property['Node'][0]['path'];
    }else{
        $img = '/uploads/bien-immobilier-sans-image.jpg';
    }
   
    
     echo $this->Form->create(array(
                                'url' => array(
                               
                                'controller' => 'Properties',
                                'action' => 'downpdf',) 
                        )); 
     echo $this->Form->hidden('Property.id', array(
                                    'value' => $property['Property']['id']
                                ));
                                echo $this->Form->hidden('PropertyAddress.line_address', array(
                                    'value' => $property['PropertyAddress'][0]['line_address']
                                ));
                                 echo $this->Form->hidden('PropertyAddress.city', array(
                                    'value' => $property['PropertyAddress'][0]['city']
                                ));
                                  echo $this->Form->hidden('PropertyAddress.country', array(
                                    'value' => $property['PropertyAddress'][0]['country']
                                ));
                                  
                          
                               echo $this->Form->hidden('Node.path', array(
                                    'value' => $img
                                ));
                           
                                echo $this->Form->hidden('Property.name', array(
                                    'value' => $property['Property']['name']
                                ));
                                  echo $this->Form->hidden('Property.spec', array(
                                    'value' => $property['Property']['spec']
                                ));
                             echo $this->Form->hidden('Property.body', array(
                                    'value' => $property['Property']['body']
                                ));
                              echo $this->Form->hidden('Property.reference', array(
                                    'value' => $property['Property']['reference']
                                ));
                            echo $this->Form->hidden('Property.size', array(
                                    'value' => $property['Property']['size']
                                ));
                             echo $this->Form->hidden('Property.rooms', array(
                                    'value' => $property['Property']['rooms']
                                ));
                              echo $this->Form->hidden('Property.pricedt', array(
                                    'value' => $property['Property']['pricedt']
                                ));
                                  echo $this->Form->hidden('Property.pricemt', array(
                                    'value' => $property['Property']['pricemt']
                                )); 
                                  
                          ?>        
                              
            
                <?php echo $this->Form->button(__d('croogo', ''),array('class' => 'btnimg')); ?>
        
<?php
	echo $this->Form->end(); ?>
                                  
                                  
    </div>
</div>