<div id="modal-del<?= $this->idproperty['Property']['id'] ?>" class="modaluser" style="padding-top: 10%">
                        <div class="modal-content">

                                <?=
                                $this->Form->create('Delete', array('url' => array('plugin' => 'passager',
                                        'controller' => 'reserves',
                                        'action' => 'admin_deleteres',
                                        $this->idproperty['Property']['id'])));
                                ?>

                            <div class="row-fluid" style="padding: 3% 0% 2% 2%">
                                Choisir le nombre de place que vous voulez diminuer: &nbsp;&nbsp;
                                <?=
                                $html = '';
                                for ($i = 1; $i <= $this->idproperty['Property']['nbp']; $i++) {
                                    $html.= "<option value='$i'>$i</option>";
                                }
                                echo "<select id=\"selectbox\" name=\"data[Delete][nbdel]\">$html</select>";
                                ?>
                            </div>

                            <div class="cf footer" style="height: 32px;">

                                <a href="#" class="btn" >Annuler</a>
            <?= $this->Form->end('Confimrer') ?>

                            </div>
                        </div>
                        <div class="overlay"></div>
                    </div>