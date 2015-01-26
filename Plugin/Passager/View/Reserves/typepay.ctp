<?= $this->Html->css('/passager/css/stars.css', null, array('inline' => false)); ?>
<?= $this->Session->flash();
?>
<div class="content" oncontextmenu="return false">
    <div class="post-inner">
        <h1 class="name post-title entry-title" >
            <span itemprop="name">Choisir votre type de paiment</span>
        </h1>
        <div class="divider"></div>
        <div class="clear"></div>
       
        <div class="entry">
            <div class="one_half">
                <b>Crédit de réservation</b>
                 <p>Vos crédit : <b><?= $credit ?></b> réservation</p>
                <p class="post-meta"></p>
                <br>
                <?php if($credit < $nbplace){?>
               <?= $this->Html->link('Acheter des crédits',array('admin' => true,'plugin' => 'passager','controller' => 'credits','action' => 'index'),array('class' => 'shortc-button medium black'));?>

                <?php }else{ ?>
              <?= $this->Html->link('Payer avec crédits',array('admin' => false,'action' => 'endreserve',$property['Property']['id'],$nbplace,$rand,1),array('class' => 'shortc-button medium black'));?>
                <?php }?>
            </div>
            <div class="one_half last">
                <b>Carte de crédit</b> 
                <p>Payer votre réservation avec :<b> PayPal</b>
               
                <p class="post-meta"></p>
                <br>
            <?= $this->Html->link('Payer avec PayPal',array('admin' => false,'action' => 'buyres',$property['Property']['id'],$nbplace,$rand),array('class' => 'shortc-button medium black'));?>
               
            </div>
            <div class="clear"></div>
            <p class="post-meta"></p>
            <table>
                <tbody>
                    <tr>
                      <td>
                          <span><b><?= $property['PropertyAddress'][0]['country'] . ' - ' . $property['PropertyAddress'][0]['city'] ?></b> vers <b><?= $property['PropertyAddress'][0]['country_des'] . ' - ' . $property['PropertyAddress'][0]['city_des'] ?></b>, ON - <?=$property['Property']['datedepart'] ?>, <?= $property['Property']['heuredepart'] ?></span>
                          <span >Prix <em><?= $property['Property']['pricedt'] ?>&nbsp;$</em></span>
                          <span ></span></td>
                        <td>
                            <em> -<?= $nbplace ?> <em> crédit(s) de réservation
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="post-meta"></p>
     <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
document.onmousedown=disableclick;
status="Right Click Disabled";
Function disableclick(e)
{
  if(event.button==2)
   {
     alert(status);
     return false;	
   }
}
<?php $this->Html->scriptEnd(); ?>










