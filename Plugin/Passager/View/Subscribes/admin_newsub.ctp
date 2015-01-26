   <?php 
$this->Html->css('/croogo/css/admincss/style-footer', null, array('inline' => false));
$this->Html->css('/users/css/msg.css', null, array('inline' => false));
?>

    <div class="progress progress-striped active">
        <div class="bar" style="width: 99%;"></div>
    </div>

<div class="box">
        <div class="box-title">
            <p>
                Cliquer ici si vous n'étes pas redireger automatiquement  : 
                <b><?= $this->Html->link('Cliquer ici',array('admin' => true, 'plugin' => 'users', 'controller' => 'users','action' => 'login')) ?></b> 
            </p>  
        </div>
    </div> 

      














