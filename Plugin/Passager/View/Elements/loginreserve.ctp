<div class="logincontainer"> 
    <div class="widget-container">		
        <div id="login-form">
<?php 
if(AuthComponent::user('id')) {?>
    
    <div class="entry">
          
                    <div class="two_third">
                        <p class="adminpanel">Bonjour, <strong><?= $this->Html->link(AuthComponent::user('username'),array(
                                                                                    'plugin' =>'users',
                                                                                    'controller' => 'users',
                                                                                    'action' => 'edit',
                                                                                    AuthComponent::user('id'),
                                                                                    'admin' => true,
                            ));?></strong></p>
                        <p class="adminpanel"><?= $this->Html->link('Espace admin','/admin');?></p>
                        <p class="adminpanel"><?= $this->Html->link('Déconnexion',array(
                                                                                    'plugin' => 'users',
                                                                                    'controller' => 'users',
                                                                                    'action' => 'logout',
                                                                                    'admin' => true,
                        ));?></p>
                    </div>
                    <div class="one_third last">
                        <?= $this->Html->image('/croogo/img/layout/speaker-without-picture.jpg'); ?>
                    </div>
               <div class="clear"></div>
           
    </div>
    
<?php }
else { ?>
    <?php echo $this->Form->create('User',array('url' => array('plugin' => 'users','controller' => 'users', 'action' => 'login','admin' => true)));?>
         <?php $this->Form->inputDefaults(array(
			'label' => false,
		));?>
        <p id="log-username">
            <?php 
            echo $this->Form->input('username', array(
			'placeholder' => __d('croogo', 'Username'),
                        'class' => 'log'
		));
            ?>
            
        </p>
        <p id="log-pass">
            <?php 
            echo $this->Form->input('password', array(
			'placeholder' => __d('croogo', 'Password'),
                        'class' => 'log'
		));
            ?>
        </p>
        <?php 
            echo $this->Form->button(__d('croogo', 'Connexion'),array('class' => 'login-button'));
        ?>
        
        <?php 
        if (Configure::read('Access Control.autoLoginDuration')):
			echo $this->Form->input('remember', array(
				'label' => __d('croogo', 'Remember me?'),
				'type' => 'checkbox',
				'default' => false,
			));
	endif;
        ?>
    <ul class="login-links">
        <li>
          <?php 
            echo $this->Html->link(__d('croogo', 'Mot de passe oublié ?'), array(
			'admin' => false,
			'controller' => 'users',
			'action' => 'forgot',
			));
          ?>
        </li>
    </ul>
    <?php echo $this->Form->end(); ?>
<?php }
?>




           
        </div>
    </div>
</div>