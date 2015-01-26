<div id="modal-prop<?= $this->idproperty['Property']['id'] ?>" class="modaluser" style="padding-top: 10%">
                        <div class="modal-content">
                            <div class="header" style="height: 40px;">
                                <h2>Demande de partir d'un autre lieu</h2>
                            </div>
    <?=
    $this->Form->create('lieu', array('url' => array('plugin' => 'passager',
            'controller' => 'reserves',
            'action' => 'admin_otheradr',
            $this->idproperty['Property']['id'])));
    ?>

                            <div class="row-fluid" style="padding: 3% 0% 2% 2%">
                                <div class="span12">
                                    <p> Le conducteur propose : <b> <?= $this->idproperty['PropertyAddress'][0]['city'] ?></b> à
                                        <b><?= $this->idproperty['Property']['heuredepart'] ?></b> pour un supplément de 3$. </p>
                                    <p> Désirez-vous partir d'un autre endroit proche de <b> <?= $this->idproperty['PropertyAddress'][0]['city'] ?></b></p>
                                </div>
                                <div class="span8">
    <?= $this->Form->input('adresse', array('required' => true, 'label' => false, 'placeholder' => __d('croogo', 'Ecrire l\'adresse ou le lieu'),)); ?>                    
                                </div>
                            </div>

                            <div class="cf footer" style="height: 32px;">

                                <a href="#" class="btn" >Fermer</a>
    <?= $this->Form->end('Soumettre ma demande') ?>

                            </div>
                        </div>
                        <div class="overlay"></div>
                    </div>