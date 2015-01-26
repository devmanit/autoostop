<div id="modalcar">
    <div class="modal-content">
        <div class="header" style="height: 30px;">
            <h2>Profile de <?= $property['User']['name'] . ' ' . $property['User']['surname']; ?></h2>
        </div>
        <div class="copy">
            <div class="entry">
                <div class="one_sixth">
<?php echo $this->Html->image('/croogo/img/layout/carTypeSedan.png', array('style' => 'padding-right: 20px;')); ?>
                </div>
                <div class="five_sixth last">
                    <b>Type de véhicule : </b><?= $property['Car']['marque'] ?><br />
                    <b>Propriétaire:</b><?= $property['Car']['type'] ?><br />
                    <b>Matricule : </b><?= $property['Car']['matricule'] ?><br />
                    <b>Année : </b><?= $property['Car']['year'] ?><br />
                    <b>Couleur : </b><?= $property['Car']['color'] ?>
                    <b>Autres informations : </b><?= $property['Car']['description'] ?>
                    <br/>
                </div>
            </div>
        </div>
        <div class="cf footer" style="height: 30px;">
            <a href="#" class="btn" >Close</a>
        </div>
    </div>
    <div class="overlay"></div>
</div>