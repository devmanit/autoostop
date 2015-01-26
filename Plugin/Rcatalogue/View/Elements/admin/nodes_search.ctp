<?php
$url = isset($url) ? $url : array('action' => 'index');
?>
<div class="row-fluid">
	<div class="span12">
		<div class="clearfix filter">
			<?php
			echo $this->Form->create('Property', array(
				'class' => 'inline',
                                'url' => $url, 
			));

			$this->Form->inputDefaults(array(
				'label' => false,
				'class' => 'span11',
			));

			echo $this->Form->input('chooser', array(
				'type' => 'hidden',
				'value' => isset($this->request->query['chooser']),
			));

			echo $this->Form->input('filter', array(
				'title' => __d('croogo', 'Search'),
				'placeholder' => __d('croogo', 'Search...'),
                                'legend' => false,
				'div' => 'input text span3',
				'tooltip' => false,
			));


                        echo $this->Form->hidden('isfilter', array(
				'label' => false,
                                'value' => true,
			));
			echo $this->Form->submit(__d('croogo', 'Filter'), array('class' => 'btn',
				'div' => 'input submit span2'
			));
			echo $this->Form->end();
			?>
		</div>
	</div>
</div>