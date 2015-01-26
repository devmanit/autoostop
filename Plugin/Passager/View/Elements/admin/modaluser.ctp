<div id="modal-user<?= $this->idproperty['Property']['id'] ?>" class="modaluser" style="padding-top: 10%">
                        <div class="modal-content">
                            <div class="header" style="height: 40px;">
                                <h4>Profile de <?= $this->idproperty['User']['name'] . ' ' . $this->idproperty['User']['surname']; ?></h4>
                            </div>
                            <div class="row-fluid">
                                <div class="span2">

                                    <?php
                                    if ($this->idproperty['User']['image'] != null) {
                                        echo $this->Html->image($this->idproperty['User']['image'], array('class' => 'imguser'));
                                    } else {
                                        echo $this->Html->image('/croogo/img/layout/speaker-without-picture.jpg', array('class' => 'imguser'));
                                    }

//calculating evaluation
//calculating evaluation
                                    if ($this->idproperty['User']['Userinfo'][0]['countponc'] == 0 ||
                                            $this->idproperty['User']['Userinfo'][0]['countpol'] == 0 ||
                                            $this->idproperty['User']['Userinfo'][0]['countsec'] == 0) {
                                        $evaluation = 0;
                                    } else {
                                        $evaluation = ($this->idproperty['User']['Userinfo'][0]['noteponc'] / $this->idproperty['User']['Userinfo'][0]['countponc'] +
                                                $this->idproperty['User']['Userinfo'][0]['notepol'] / $this->idproperty['User']['Userinfo'][0]['countpol'] +
                                                $this->idproperty['User']['Userinfo'][0]['notesec'] / $this->idproperty['User']['Userinfo'][0]['countsec']) / 3;
                                        $evaluation = $evaluation * 100;
                                    }
                                    ?>
                                    <div style="padding-left: 37%">
                                        <span class="stars-small" ><span style="width:<?= $evaluation ?>%"></span></span>
                                    </div>
                                </div>
                                <div class="span8" style="padding-left: 2%;">
                                    <b>Nom et prénom : </b><?= $this->idproperty['User']['name'] . ' ' . $this->idproperty['User']['surname']; ?><br />
                                    <b>Sexe : </b><?= $this->idproperty['User']['gender'] ?> - <b>Age : </b><?= $this->idproperty['User']['age'] ?> ans - <b>Langue : </b><?= $this->idproperty['User']['language'] ?><br />
                                    <b>Pays : </b><?= $this->idproperty['User']['country'] ?> - <b>Province : </b><?= $this->idproperty['User']['province'] ?> - <b>Ville : </b><?= $this->idproperty['User']['city'] ?><br />
                                    <br/><div class="checklist"> <ul>
                                            <?php if ($this->idproperty['User']['isverified'] == 1): ?>
                                                <li>Adresse éléctronique : <?= $this->idproperty['User']['email'] ?> </li>
                                                <li>Numéro de téléphone : <?= $this->idproperty['User']['Userinfo'][0]['contactnum'] ?> (vérifié)  </li>
                                                <li>Permis de conduire :  (vérifié)</li>
    <?php else: ?>
                                                <li>Adresse éléctronique : <?= $this->idproperty['User']['email'] ?> </li>
                                                <li>Numéro de téléphone : <?= $this->idproperty['User']['Userinfo'][0]['contactnum'] ?> (non vérifié)</li>
                                                <li>Permis de conduire : (non vérifié)</li>
    <?php endif; ?>
                                            <li>Membre depuis <?= $this->idproperty['User']['created'] ?></li>
                                            <li><b>Autres infos :</b><?= $this->idproperty['User']['Userinfo'][0]['description'] ?></li>
                                            <b>Evaluation :</b>
                                            <table>
                                                <thead><tr><td></td><td></td></tr></thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Ponctualité</td>
                                                        <td>
    <?php
    if ($this->idproperty['User']['Userinfo'][0]['countponc'] == 0) {
        $evaluation_ponc = 0;
    } else {
        $evaluation_ponc = ($this->idproperty['User']['Userinfo'][0]['noteponc'] / $this->idproperty['User']['Userinfo'][0]['countponc']) * 100;
    }
    ?>
                                                            <span class="stars-small"><span style="width:<?= $evaluation_ponc ?>%"></span></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sécurité</td>
                                                        <td>
    <?php
    if ($this->idproperty['User']['Userinfo'][0]['countsec'] == 0) {
        $evaluation_sec = 0;
    } else {
        $evaluation_sec = ($this->idproperty['User']['Userinfo'][0]['notesec'] / $this->idproperty['User']['Userinfo'][0]['countsec']) * 100;
    }
    ?>
                                                            <span class="stars-small"><span style="width:<?= $evaluation_sec; ?>%"></span></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Politesse</td>
                                                        <td>
    <?php
    if ($this->idproperty['User']['Userinfo'][0]['countpol'] == 0) {
        $evaluation_pol = 0;
    } else {
        $evaluation_pol = ($this->idproperty['User']['Userinfo'][0]['notepol'] / $this->idproperty['User']['Userinfo'][0]['countpol']) * 100;
    }
    ?>
                                                            <span class="stars-small"><span style="width:<?= $evaluation_pol; ?>%"></span></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="cf footer" style="height: 32px;">
                                <a href="#" class="btn" >Close</a>
                            </div>
                        </div>
                        <div class="overlay"></div>
                    </div>