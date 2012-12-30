<div id="containerChoisir">
    <?= form_open('status/ajouter',
					array(
						'method' => 'post',
						'id' => 'formAjout'
					)); ?>
    <?= form_fieldset('', array('class' => 'formCurl')); ?>
  	<ul>
		<?php if(isset($lienImg)): ?>
			<?php $i = 0 ?>
			<?php foreach ($lienImg as $item ): ?>
				<li class="choixImage">
				<?= form_radio(array(
				    'name'        => 'SelectImg',
				    'id'          => $i,
				    'value'		=> $item,
				    'class'		=> 'inputJs'
				    )) ?>
				<?= form_label('<img src="' . $item .'" />', $i); ?>
				
				</li>
			<?php $i++ ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<?= form_button(array('id' => 'previous', 'content' => 'precedent')) ?>
	<?= form_button(array('id' => 'next', 'content' => 'suivant')) ?>
	
	<div class="contentCurl">
		<h2><?php if(isset($titles)):?><?=  $titles ?></h2>
		<?= form_hidden(array('titre'=>$titles)); ?><?php endif; ?>
		<address><?php if(isset($url)):?><?=  $url ?></address>
		<?= form_hidden(array('url'=>$url)); ?><?php endif; ?>
		<p><?php if(isset($description)):?><?=  $description ?></p>
		<?= form_hidden(array('description'=>$description)); ?><?php else: ?>
		<?= form_hidden(array('description'=>"")); ?>
		<?php endif; ?>
	</div>
	<div class="formBottom">
		<?= form_reset(array('class' => 'boutonSubmit'), 'annuler') ?>
		<?= form_submit(array('class' => 'boutonSubmit'), 'envoyer') ?>
	</div>
	
	
    <?= form_fieldset_close() ?>
    <?= form_close() ?>
</div>
