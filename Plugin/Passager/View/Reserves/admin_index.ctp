<?php
$this->Html->css('/croogo/css/map-style.css', null, array('inline' => false));
$this->Html->css('/rcatalogue/css/simplemodal.css', null, array('inline' => false));
$this->Html->css('/passager/css/stars.css', null, array('inline' => false));
$this->Html->script('https://maps.googleapis.com/maps/api/js?sensor=false', array('inline' => false));
$this->Html->script('/croogo/js/maplace-0.1.3.min.js', array('inline' => false));
$this->Croogo->adminScript('Passager.admin');
?>
<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Mes réservations');
$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Mes réservations'), array('action' => 'index'));
$user = $this->Session->read('Auth.User');
$outputuser = '';
$outputprop = '';
$outputdel = '';
?>

<div class="box">
    <div class="box-title">
        <i class="icon-hand-right"></i>
        Consulter nos départs et réservez votre place: <?=
$this->Html->link('Nos départs', array('admin' => false,
    'plugin' => 'rcatalogue',
    'controller' => 'properties',
    'action' => 'listing'), array('target' => '_blank'));
?> 

    </div>
</div> 

<div class="properties index">
    <table class="table table-striped">
        <tr>


            <th><?php echo $this->Paginator->sort('datedepart', __d('croogo', 'Date départ')); ?></th>
            <th><?php echo $this->Paginator->sort('heuredepart', __d('croogo', 'Heure départ')); ?></th>
            <th><?php echo $this->Paginator->sort('PropertyAddress.0.province', __d('croogo', 'Lieu de départ')); ?></th>
            <th><?php echo $this->Paginator->sort('PropertyAddress.0.province_des', __d('croogo', 'Lieu d\'arrivé')); ?></th>
            <th><?php echo $this->Paginator->sort('name', __d('croogo', 'Nom du conducteur')); ?></th>
            <th><?php echo $this->Paginator->sort('pricedt', __d('croogo', 'Prix et place')); ?></th>
            <th><?php echo $this->Paginator->sort('bagage', __d('croogo', 'Voiture et Bagage')); ?></th>
            <?php if ($user['role_id'] == 1) {
                
            } else {
                ?>
                <th><?php echo $this->Paginator->sort('croogo', __d('croogo', 'Vos places')); ?></th>
                <th class="actions"><?php echo __d('croogo', 'Autre lieu de départ'); ?></th>
            <?php } ?>

            <th class="actions"><?php echo __d('croogo', 'Fiche complète'); ?></th>
            <th class="actions"><?php echo __d('croogo', 'Annuler'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach ($properties as $key => $property): ?>
            <?php if (new DateTime($property['Property']['datedepart']) <= new DateTime("now")): ?>
                <tr style="text-decoration:line-through;">
            <?php else : ?><tr> <?php endif; ?>
                
                <td><?php echo h($property['Property']['jourdepart']).' '.h($property['Property']['datedepart']); ?>&nbsp;</td>
                <td><?php echo h($property['Property']['heuredepart']); ?>&nbsp;</td>
                <td>

                    <?php
                    if (new DateTime($property['Property']['datedepart']) <= new DateTime("now")) {
                        echo h($property['PropertyAddress'][0]['country']) . ' - ' . h($property['PropertyAddress'][0]['city']);
                    } else {
                        echo $this->Html->Link(h($property['PropertyAddress'][0]['country']) . ' - ' . $property['PropertyAddress'][0]['city'], '#modal-map', array('onmouseover' => 'generateMap(' . $property['PropertyAddress'][0]['latitude'] . ',' . $property['PropertyAddress'][0]['longitude'] . ',' . $property['PropertyAddress'][0]['zoom'] . ')'));
                 }
                    ?>&nbsp;</td>
                <td>

                    <?php
                    if (new DateTime($property['Property']['datedepart']) <= new DateTime("now")) {
                        echo h($property['PropertyAddress'][0]['country_des']) . ' - ' . h($property['PropertyAddress'][0]['city_des']);
                    } else {
                        echo $this->Html->Link(h($property['PropertyAddress'][0]['country_des']) . ' - ' . $property['PropertyAddress'][0]['city_des'], '#modal-map', array('onmouseover' => 'generateMap(' . $property['PropertyAddress'][0]['latitude_des'] . ',' . $property['PropertyAddress'][0]['longitude_des'] . ',' . $property['PropertyAddress'][0]['zoom_des'] . ')'));
                    }
                    ?>&nbsp;</td>

                <td><?php
                    if (new DateTime($property['Property']['datedepart']) <= new DateTime("now")) {
                        echo $property['User']['name'] . ' ' . h($property['User']['surname']);
                    } else {
                        echo $this->Html->link($property['User']['name'] . ' ' . $property['User']['surname'], '#modal-user' . $property['Property']['id']);
                    }
                    ?>&nbsp;</td>
                <td><?php echo h($property['Property']['pricedt']) . ' $<br>' . h($property['Property']['reserved']) . '/' . h($property['Property']['rooms'] . ' places'); ?>&nbsp;</td>
                <td><?php
                    if ($property['Property']['bagage'] == 'petit') {
                        echo '<span>' . $property['Car']['marque'] . '</span><br/>' . $this->Html->image('/croogo/img/layout/bagage-petit.png', array('style' => 'height:20px;'));
                    } else if ($property['Property']['bagage'] == 'moyen') {
                        echo '<span>' . $property['Car']['marque'] . '</span><br/>' . $this->Html->image('/croogo/img/layout/bagage-moyen.png', array('style' => 'height:20px;'));
                    } else if ($property['Property']['bagage'] == 'grand') {
                        echo '<span>' . $property['Car']['marque'] . '</span><br/>' . $this->Html->image('/croogo/img/layout/bagage-grand.png', array('style' => 'height:20px;'));
                    }
                    ?>&nbsp;</td>
                <?php if ($user['role_id'] == 1) {
                    
                } else {
                    ?>
                    <td><?php
                        echo h($property['Property']['nbp']);
                        ?>&nbsp;</td>
                    <td >
                        <?php if (!$properties[$key]['Property']['active']) { ?>
                            <?php
                            echo $this->Html->link('Proposer', '#modal-prop' . $property['Property']['id']);
                        } else {
                            echo '<b>Etat : Passé</b>';
                        }
                        ?>&nbsp;

                    </td>
                    <?php } ?>
                <td class="item-actions">
                    <?php if (!$properties[$key]['Property']['active']) { ?>
                        <?php
                        echo $this->Croogo->adminRowAction('Voir fiche', array('plugin' => 'rcatalogue', 'controller' => 'properties', 'action' => 'edit', $property['Property']['id']));
                    } else {
                        echo '<b>Etat : Passé</b>';
                    }
                    ?>
                </td>
                <td>
                    <?php if (!$properties[$key]['Property']['active']) { ?>
                        <?=
                        $this->Croogo->adminRowAction('', '#modal-del' . $property['Property']['id'], array('icon' => 'remove-sign', 'style' => 'color : #9d261d'));
                        ?>
                        <?php
                    } else {
                        echo '<b>Etat : Passé</b>';
                    }
                    ?>
                </td>

            </tr>
            <?php
            $this->idproperty = $property;
            $outputuser .=$this->element('admin/modaluser');
            $outputprop .=$this->element('admin/modalprop');
            $outputdel .=$this->element('admin/modaldel');
            ?>
    <?php endforeach; ?>
    </table>
    <?php echo $outputuser; ?>
    <?php echo $outputprop; ?>
<?php echo $outputdel; ?>
</div>
<!-- Modal Google Map -->
<div id="modal-map" class="modaluser" style="padding-top: 10%">
    <div class="modal-content">
        <div class="header" style="height: 40px;">
            <h2>Google map</h2>
        </div>
        <div class="copy">
            <div class="gmap" id="gmap">

            </div>
        </div>
        <div class="cf footer" style="height: 32px;">
            <a href="#" class="btn" >Fermer</a>
        </div>
    </div>
    <div class="overlay"></div>
</div>



<?php $this->Html->scriptStart(array('inline' => false)); ?>
function generateMap(latparm,lonparam,zoomparam)
{
//remove content from div firt
document.getElementById("gmap").innerHTML = "";

//regenerate map
var maplace_data = [
{
lat: latparm,
lon: lonparam,
title: 'Autoostop',
zoom: zoomparam,
icon: 'http://maps.google.com/mapfiles/marker.png',
show_infowindows: true,
visible: true,
stopover: false,
}
];

var maplace = new Maplace();
maplace.Load({
locations: maplace_data,
map_div: '#gmap',
start: 0,
show_markers: true,
show_infowindows: true,
infowindow_type: 'bubble',
visualRefresh: true,
map_options: {
mapTypeId: google.maps.MapTypeId.ROADMAP,
zoom: 12,
set_center: [latparm,lonparam],
},
type: 'marker',
draggable: false,
});
}


<?php $this->Html->scriptEnd(); ?>