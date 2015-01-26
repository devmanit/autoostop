<?php
$this->Html->css('/croogo/css/map-style.css', null, array('inline' => false));
$this->Html->css('/rcatalogue/css/simplemodal.css', null, array('inline' => false));
$this->Html->script('https://maps.googleapis.com/maps/api/js?sensor=false', array('inline' => false));
$this->Html->script('/croogo/js/maplace-0.1.3.min.js', array('inline' => false));
?>

<section class="cat-box recent-box">
    <div class="cat-box-title">
        <h2 class="highlightdate"><?php
        if(isset($passed) && $passed == true)
        {
            echo 'ce départ n\'est plus disponible';
        }
        else
        {
           echo strftime("%A", strtotime($property['Property']['datedepart'])) .
            ' ' . strftime("%d", strtotime($property['Property']['datedepart'])) . ' ' .
            strftime("%B", strtotime($property['Property']['datedepart'])) . ' à ' .
            strftime("%H", strtotime($property['Property']['heuredepart'])) . ':' .
            strftime("%M", strtotime($property['Property']['heuredepart'])); 
        }

?>
        </h2>
        <br/><br/><br/>
        <h2>
            <?php
            echo 'Couvoiturage de <span>' . $property['PropertyAddress'][0]['city'] . '</span> vers <span>' .
            $property['PropertyAddress'][0]['city_des'] . '</span> - <span>' . $property['Property']['pricedt'] . '$ (Nombre de place : ' . $property['Property']['reserved'] . '/' . $property['Property']['rooms'] . ')</span>';
            ?>
        </h2>
        <div class="stripe-line">&nbsp;</div>
    </div>

    <div class="cat-box-content">
        <fieldset class="fscf-fieldset">
            <legend>Adresses (Départ + Arrivé)</legend>
            <div class="entry">
                <div class="one_half minimizewidth">
                    <div class="gmapbox" id="gmap"></div>
                    <span class="today-date">
                        <?php
                        echo $property['PropertyAddress'][0]['city'] . ', '
                        . $property['PropertyAddress'][0]['province'] . ', '
                        . $property['PropertyAddress'][0]['country'];
                        ?>
                        <br/>
                        <strong>Rendez-vous :</strong><br/><?= $property['PropertyAddress'][0]['line_address']; ?>
                    </span>
                </div>
                <div><?= $this->Html->image('/croogo/img/layout/triangle.jpg', array('class' => 'destimgbox')); ?></div>
                <div class="one_half minimizewidth last">
                    <div class="gmapbox" id="gmapbox"></div>
                    <span class="today-date">
                        <?php
                        echo $property['PropertyAddress'][0]['city_des'] . ', '
                        . $property['PropertyAddress'][0]['province_des'] . ', '
                        . $property['PropertyAddress'][0]['country_des'];
                        ?>
                        <br/>
                        <strong>Point de chute :</strong><br/><?= $property['PropertyAddress'][0]['line_address_des']; ?>
                    </span>
                </div>
            </div>
        </fieldset>
        <fieldset class="fscf-fieldset">
            <legend>Réserevation départ</legend>
            <div class="entry">
                <div class="one_third">
                    <?php
                    if(isset($passed) && $passed == true)
                    {
                        echo '<h2 class="highlightdate">COMPLET</h2>';
                    }
                    else
                    {
                    echo $this->Form->create('Reservation', array('url' => '/passager/reserves/reserve/' . $property['Property']['id']));
                    
                                $html = '';
                                for ($i = 1; $i <=  $property['Property']['rooms']; $i++) {
                                    $html.= "<option value='$i'>$i place passager</option>";
                                }
                                echo "<select class=\"inputmeselect\" id=\"selectbox\" name=\"data[Reservation][places]\">$html</select>";
              
                    echo $this->Form->end('Réserver mon départ');
                    if (!$this->Session->read('Auth.User')) {
                        echo 'Vous n\'étes pas connecter. ';
                        echo $this->Html->link(__d('croogo', 'Connexion'), array(
                            'admin' => false,
                            'plugin' => 'users',
                            'controller' => 'users',
                            'action' => 'login',
                                ), array('style' => 'color:blue;'));
                        echo '<br/>';
                        echo $this->Html->link(__d('croogo', 'Créer un compte'), array(
                            'admin' => false,
                            'plugin' => 'users',
                            'controller' => 'users',
                            'action' => 'registeruser',
                                ), array('style' => 'color:blue;'));
                    }
                    }
                    ?>

                </div>
                <div class="two_third last">
                    <div class="box  shadow aligncenter">
                        <div class="box-inner-block"><i class="tieicon-boxicon"></i>
                            <b>N.B : </b>Une fois votre place réservée, votre chauffeur sera immédiatement informé de votre identité via son <b>compte Autostop.</b>
                            Vous connaîtrez également l'identité du chauffeur, la marque et la couleur de sa voiture et les détails sur le lieu de rendez-vous.
                        </div></div>
                </div>
            </div>
        </fieldset>
        <fieldset class="fscf-fieldset">
            <legend>Informations sur le départ</legend>
            <div class="entry">
                <div style="width:40%; float:left;">
                    <div id="ridePrefsLegend">
<?php
$array_condition = explode(',', $property['Property']['spec']);
?>
                        <ul>
                            <li class="clearfix">
                                <span class="icon"><?= $this->Html->image('/croogo/img/layout/espacefumeur-' . $array_condition[0] . '.gif'); ?></span>
<?php if ($array_condition[0] == 1): ?>
                                    <span class="label">Espace fumeur</span>
                                <?php else: ?>
                                    <span class="label">Espace non fumeur</span>
                                <?php endif; ?>
                            </li>
                            <li class="clearfix">
                                <span class="icon"><?= $this->Html->image('/croogo/img/layout/airclimatise-' . $array_condition[1] . '.gif'); ?></span>
<?php if ($array_condition[1] == 1): ?>
                                    <span class="label">Air climatisé</span>
                                <?php else: ?>
                                    <span class="label">Pas d'air climatisé</span>
                                <?php endif; ?>
                            </li>
                            <li class="clearfix">
                                <span class="icon"><?= $this->Html->image('/croogo/img/layout/supportvelo-' . $array_condition[2] . '.gif'); ?></span>
<?php if ($array_condition[2] == 1): ?>
                                    <span class="label">Support à vélo</span>
                                <?php else: ?>
                                    <span class="label">Pas de support à vélo</span>
                                <?php endif; ?>
                            </li>
                            <li class="clearfix">
                                <span class="icon"><?= $this->Html->image('/croogo/img/layout/supportski-' . $array_condition[3] . '.gif'); ?></span>
<?php if ($array_condition[3] == 1): ?>
                                    <span class="label">Support à ski</span>
                                <?php else: ?>
                                    <span class="label">Pas de support à ski</span>
                                <?php endif; ?>
                            </li>
                            <li class="clearfix">
                                <span class="icon"><?= $this->Html->image('/croogo/img/layout/animaux-' . $array_condition[4] . '.gif'); ?></span>
<?php if ($array_condition[4] == 1): ?>
                                    <span class="label">Animaux acceptés</span>
                                <?php else: ?>
                                    <span class="label">Animaux refusés</span>
                                <?php endif; ?>
                            </li>
                            <li class="clearfix">
                                <span class="icon"><?= $this->Html->image('/croogo/img/layout/numeroconducteur-' . $array_condition[5] . '.gif'); ?></span>
<?php if ($array_condition[5] == 1): ?>
                                    <span class="label">Accès au numéro de téléphone du conducteur</span>
                                <?php else: ?>
                                    <span class="label">Pas d'accès au numéro de téléphone du conducteur</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div> 
                </div>
                <div style="width:55%;float:left;padding-left: 10px;border-left: 1px dotted #999;">
<?php
echo '<h4>Conducteur : ' . $this->Html->Link($property['User']['name'] . ' ' . $property['User']['surname'], '#modal',array('style' => 'color:#08c')) . '</h4>';
echo $this->Html->image('/croogo/img/layout/carTypeSedan.png', array('style' => 'padding-right: 20px;'));
echo $this->Html->image('/croogo/img/layout/luggage2.png', array('style' => 'width: 50px;'));
?>
                    <br>
                    Type de véhicule :  <strong><?= $this->Html->Link($property['Car']['name'], '#modalcar',array('style' => 'color:#08c')); ?></strong><br>
                    Bagage / Espace dans la valise :
<?php
if ($property['Property']['bagage'] == 'petit') {
    echo '<b>petit sac à dos</b>';
} else if ($property['Property']['bagage'] == 'moyen') {
    echo '<b>Bagages de moyen format acceptés </b>';
} else {
    echo '<b>Bagages de grand format acceptés </b>';
}
?>

                </div>
            </div>
        </fieldset>
    </div>
</section>
<?php $this->idproperty = $property;
echo $this->element('modalcar');
echo $this->element('modalinfouser');
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function() {

//first map
var maplace_data = [
{
lat: <?= $property['PropertyAddress'][0]['latitude']; ?>,
lon: <?= $property['PropertyAddress'][0]['longitude']; ?>,
title: 'Autoostop',
zoom: <?= $property['PropertyAddress'][0]['zoom']; ?>,
icon: 'http://maps.google.com/mapfiles/markerA.png',
show_infowindows: true,
visible: true,
stopover: false,
}
];
//second map
var maplace_data_des = [
{
lat: <?= $property['PropertyAddress'][0]['latitude_des']; ?>,
lon: <?= $property['PropertyAddress'][0]['longitude_des']; ?>,
title: 'Autoostop',
zoom: <?= $property['PropertyAddress'][0]['zoom_des']; ?>,
icon: 'http://maps.google.com/mapfiles/markerB.png',
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
set_center: [<?= $property['PropertyAddress'][0]['latitude']; ?>, <?= $property['PropertyAddress'][0]['longitude']; ?>],
},
type: 'marker',
draggable: false,
});
var maplace_des = new Maplace();
maplace_des.Load({
locations: maplace_data_des,
map_div: '#gmapbox',
start: 0,
show_markers: true,
show_infowindows: true,
infowindow_type: 'bubble',
visualRefresh: true,
map_options: {
mapTypeId: google.maps.MapTypeId.ROADMAP,
zoom: 12,
set_center: [<?= $property['PropertyAddress'][0]['latitude_des']; ?>, <?= $property['PropertyAddress'][0]['longitude_des']; ?>],
},
type: 'marker',
draggable: false,
});
});
<?php $this->Html->scriptEnd(); ?>

