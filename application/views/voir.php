 <?php $this->load->helper('time_helper'); ?>

<div id="containerContent">
			<?= form_open('status/modifier',
					array(
						'method' => 'post'
					)); ?>
			<?php foreach ($status as $item ): ?>
				<p><img src="<?= $item->img ?>" /></p>
				<?= form_input(array(
		              'name'  => 'champtitre',
		              'class' => 'champtitre',
		              'value' => $item->titre
		            )); ?>
		         <?= form_textarea(array(
		              'name'  => 'champtext',
		              'class' => 'champtext',
		              'value' => $item->description
		            )); ?>	   		
				<p><?= relative_time($item->date); ?></p>
				<?= form_hidden(array('id'=>$item->id)); ?>
			<?php endforeach; ?>
			<?= anchor('status/index/','Retour'); ?>
			<?= form_submit(array('class' => 'boutonSubmit'), 'envoyer') ?>
			<?= form_close() ?>
			
</div>