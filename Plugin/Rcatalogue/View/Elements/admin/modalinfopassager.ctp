<div id="modal-prop<?= $this->propforelement['Property']['id'] ?>" class="modaluser" style="padding-top: 10%">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Passagers réservés (<?= ($this->propforelement['Property']['reserved'].'/'.$this->propforelement['Property']['rooms']); ?>)</h4>
            <div class="progress progress-striped">
                <div class="bar" style="width: <?= ($this->propforelement['Property']['reserved']/$this->propforelement['Property']['rooms'])*100 ?>%;"></div>
            </div>
        </div>
        <div class="modal-body">
           <table class="table table-striped">
            <tr>
                <th>Passager</th>
                <th>Nombre de places</th>
                <th>Profile</th>
            </tr>
<?php /*debug($this->propforelement['Property']['passagersinfo']);
            die("hello");*/?>
            <?php foreach ($this->propforelement['Property']['passagersinfo'] as $key => $value):
                //combine tables to view nbr places for this dep
               /* debug("******prop id :");
                debug($value['User']['property_id']);
                debug("******prop nbrplace :");
                debug($value['User']['nbrplace']);*/
                
               $array_reser_info =  array_combine(explode(',', $value['User']['property_id']), explode(',', $value['User']['nbrplace']));
               
                /*debug("******array_reser_info :");
                debug($array_reser_info);*/
            ?>
            <tr>
                <td><?= $value['User']['name'] ?></td>
                <td><span class="badge badge-info"><?= $array_reser_info[$this->propforelement['Property']['id']]?></span></td>
                <td>
                    <div class="btn-group nav">
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        
                        <ul class="dropdown-menu">
                            <div class="span10">
                            <li>Nom & Prénom : <?= $value['User']['name'].' '.$value['User']['surname'] ?></li>
                            <li>Numéro de tél : <?= $value['Userinfo'][0]['contactnum']?></li>
                            <li>Email : <?= $value['User']['email']?></li>
                            <li>Langue : <?= $value['User']['language']?></li>
                            <?php if($value['User']['isstudent'] == true): ?>
                                <li>Etudiant : Oui</li>
                            <?php else : ?>
                                <li>Etudiant : Non</li>
                            <?php endif;?>
                                <li>Inscrit à Autostop depuis le <?= $value['User']['created'];?></li>
                                </div>
                            <div class="span2">
                                <?php
                                if (isset($value['User']['image']) && $value['User']['image'] != null) {
                                    echo $this->Html->image($value['User']['image'],array('width' => '100%'));
                                } else {
                                    echo $this->Html->image('/croogo/img/layout/speaker-without-picture.jpg',array('width' => '100%'));
                                }
                                ?>
                        </div>
                        </ul>
                        
                        
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
           </table>
        </div>   
       
        <div class="cf footer" style="height: 32px;">
            <a href="#" class="btn" >Close</a>
        </div>
    </div>
    <div class="overlay"></div>
    </div>
</div>