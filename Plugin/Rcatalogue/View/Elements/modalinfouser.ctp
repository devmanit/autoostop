<div id="modal">
    <div class="modal-content">
        <div class="header" style="height: 30px;">
            <h2>Profile de <?= $property['User']['name'] . ' ' . $property['User']['surname']; ?></h2>
        </div>
        <div class="copy">
            <div class="entry">
                <div class="one_sixth">
<?php
if ($property['User']['image'] != null) {
    echo $this->Html->image($property['User']['image'], array('align' => 'left'));
} else {
    echo $this->Html->image('/croogo/img/layout/speaker-without-picture.jpg', array('align' => 'left'));
}

//calculating evaluation
//calculating evaluation
if ($property['User']['Userinfo'][0]['countponc'] == 0 ||
        $property['User']['Userinfo'][0]['countpol'] == 0 ||
        $property['User']['Userinfo'][0]['countsec'] == 0) {
    $evaluation = 0;
} else {
    $evaluation = ($property['User']['Userinfo'][0]['noteponc'] / $property['User']['Userinfo'][0]['countponc'] +
            $property['User']['Userinfo'][0]['notepol'] / $property['User']['Userinfo'][0]['countpol'] +
            $property['User']['Userinfo'][0]['notesec'] / $property['User']['Userinfo'][0]['countsec']) / 3;
    $evaluation = $evaluation * 100;
}
?>
                    <span class="stars-small"><span style="width:<?= $evaluation ?>%"></span></span>
                </div>
                <div class="five_sixth last">
                    <b>Nom et prénom : </b><?= $property['User']['name'] . ' ' . $property['User']['surname']; ?><br />
                    <b>Sexe : </b><?= $property['User']['gender'] ?> - <b>Age : </b><?= $property['User']['age'] ?> ans - <b>Langue : </b><?= $property['User']['language'] ?><br />
                    <b>Pays : </b><?= $property['User']['country'] ?> - <b>Province : </b><?= $property['User']['province'] ?> - <b>Ville : </b><?= $property['User']['city'] ?><br />
                    <br/><div class="checklist">
                        <ul>
                    <?php if ($property['User']['isverified'] == 1): ?>
                                <li>Numéro de téléphone (vérifié)
                                 <?php if ($property['User']['Userinfo'][0]['ispublic'] == 1): ?>
                                    <?= ': '.$property['User']['Userinfo'][0]['contactnum'] ?>
                                    <?php endif; ?>
                                </li>
                                
                                <li>Permis de conduire vérifié</li>
                    <?php else: ?>
                                <li>Numéro de téléphone (non vérifié)
                                    <?php if ($property['User']['Userinfo'][0]['ispublic'] == 1): ?>
                                    <?= ': '.$property['User']['Userinfo'][0]['contactnum'] ?>
                                    <?php endif; ?>
                                </li>
                                <li>Permis de conduire non vérifié</li>
                    <?php endif; ?>
                            <li>Membre depuis <?= $property['User']['created'] ?></li>
                            <li><b>Autres infos :</b><?= $property['User']['Userinfo'][0]['description'] ?></li>
                            <b>Evaluation :</b>
                            <table>
                                <thead><tr><td></td><td></td></tr></thead>
                                <tbody>
                                    <tr>
                                        <td>Ponctualité</td>
                                        <td>
                            <?php
                            if ($property['User']['Userinfo'][0]['countponc'] == 0) {
                                $evaluation_ponc = 0;
                            } else {
                                $evaluation_ponc = ($property['User']['Userinfo'][0]['noteponc'] / $property['User']['Userinfo'][0]['countponc']) * 100;
                            }
                            ?>
                                            <span class="stars-small"><span style="width:<?= $evaluation_ponc ?>%"></span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sécurité</td>
                                        <td>
                                            <?php
                                            if ($property['User']['Userinfo'][0]['countsec'] == 0) {
                                                $evaluation_sec = 0;
                                            } else {
                                                $evaluation_sec = ($property['User']['Userinfo'][0]['notesec'] / $property['User']['Userinfo'][0]['countsec']) * 100;
                                            }
                                            ?>
                                            <span class="stars-small"><span style="width:<?= $evaluation_sec; ?>%"></span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Politesse</td>
                                        <td>
                                            <?php
                                            if ($property['User']['Userinfo'][0]['countpol'] == 0) {
                                                $evaluation_pol = 0;
                                            } else {
                                                $evaluation_pol = ($property['User']['Userinfo'][0]['notepol'] / $property['User']['Userinfo'][0]['countpol']) * 100;
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
        </div>
        <div class="cf footer" style="height: 30px;">
            <a href="#" class="btn" >Close</a>
        </div>
    </div>
    <div class="overlay"></div>
</div>