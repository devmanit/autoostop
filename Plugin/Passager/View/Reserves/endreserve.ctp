<?= $this->Html->css('/passager/css/stars.css', null, array('inline' => false)); ?>
<?php if ($usersess['role_id'] == 4) { ?>
    <div class="box  warning alignright">
        <div class="box-inner-block">
            <i class="tieicon-boxicon"></i>
            Bonjour,<?= $usersess['surname'] . $usersess['name'] ?> Vous étes connecter comme une conducteur. Voulez vous créer un compte passager pour faire une réservation.
            Redirection votre espace administration ...
        </div>
    </div>
    <?php
} else {
    ?>

    <section class="cat-box recent-box">
        <div class="cat-box-title">
            <h2>Détails réservation</h2>
            <div class="stripe-line"></div>
        </div>
        <?= $this->Form->create('Reserve',array('name' => 'ReserveEndreserveForm')) ?>
        
        <div class="cat-box-content" >
            <div class="entry">
                
                <div class="success"><b>
                        <?php  if($char == 3){?>
                            Félicitations, cette réservation est gratuit
                        <?php }else{?>
                        Crédit(s) utilisé(s) <?=$nbplace ?> 
                        <?php } ?>
                    </b></div><br>
                <div class="checklist">
                    <ul>
                        <li> Nombre(s) de place(s): <b><?= $nbplace ?></b> </li>
                        <li> Date et heure de départ: <b> 
                                <?php
                                echo strftime("%A", strtotime($property['Property']['datedepart'])) .
                                ' ' . strftime("%d", strtotime($property['Property']['datedepart'])) . ' ' .
                                strftime("%B", strtotime($property['Property']['datedepart'])) . ' à ' .
                                strftime("%H", strtotime($property['Property']['heuredepart'])) . ':' .
                                strftime("%M", strtotime($property['Property']['heuredepart']));
                                ?>
                            </b>
                        </li>
                        <li>
                            Couvoiturage de <b>  <?php
                                echo $property['PropertyAddress'][0]['city'] . '</span> vers <span>' .
                                $property['PropertyAddress'][0]['city_des'] . '</span> - <span>' . $property['Property']['pricedt'] . '$ (Nombre de place : ' . $property['Property']['reserved'] . '/' . $property['Property']['rooms'] . ')</span>';
                                ?></b>
                        </li>
                        <li>
                            Adresses Départ et rendez-vous:
                            <b>
                                <ul>

                                    <li>
                                        <?php
                                        echo $property['PropertyAddress'][0]['city'] . ', '
                                        . $property['PropertyAddress'][0]['province'] . ', '
                                        . $property['PropertyAddress'][0]['country'];
                                        ?>
                                    </li>
                                    <li>
                                        <?= $property['PropertyAddress'][0]['line_address']; ?>
                                    </li>
                                </ul>
                            </b>
                        </li>
                        <li>
                            Adresses Arrivé et Point de chute:
                            <b>
                                <ul>

                                    <li>
                                        <?php
                                        echo $property['PropertyAddress'][0]['city_des'] . ', '
                                        . $property['PropertyAddress'][0]['province_des'] . ', '
                                        . $property['PropertyAddress'][0]['country_des'];
                                        ?>
                                    </li>
                                    <li>
                                        <?= $property['PropertyAddress'][0]['line_address_des']; ?></li>
                                </ul>
                            </b>

                        </li>
                       
                    </ul>
                </div>
                <div class="box-inner-block"><i class="tieicon-boxicon"></i>
                    <b>N.B : </b>Une fois votre place réservée, Vous pouvez consulter plus des détails dans votre espace <b>Mes réservations</b>
                    <br>     <br>     <?= $this->Form->end('Finaliser mon réservation') ?>

                </div>

            </div>

        </div>
    </section> 

<?php } ?>
