<?php $this->load->helper('time_helper'); ?>

<div id="containerContent">
    <?php if(isset($erreur)): ?>
    	<div class="erreurUrl">
    		<?= $erreur ?>
    	</div>
    <?php endif; ?>
    <?php if($this->session->userdata('logged')): ?>
    <?= form_open('status/choisir',
					array(
						'method' => 'post',
						'id' => 'myForm'
					)); ?>
	<img id="loader" src="<?= base_url() ?>/web/images/ajax-loader.gif" alt="ajax-loader" />
	
	<?= form_fieldset('', array('id' => 'content', 'class'=>'icon-link')); ?>
    <?= form_input(array(
              'name'        => 'champ',
              'id'          => 'champ',
              'placeholder' => 'Put your link, Here !',
              'class' => 'champ'
            )); ?>	
    <?= form_fieldset_close() ?>
    
    
	<div class="formBottom">
		<span class="icon-reply"><?= form_reset(array('class' => 'bouton reset'), 'Reset') ?></span>
		<span class="icon-ok"><?= form_submit(array('class' => 'bouton'), 'Submit') ?></span>
	</div>
	
	
    <?= form_fieldset_close() ?>
    <?= form_close() ?>
    <? endif; ?>
	  <section id="timeline">

	  <?php foreach($list as $itemList): ?>
	 	 
	    	<div class="containerList <?php echo $itemList->id ?>">
		    	<h1>
	    			<span>
	    			<?php echo $itemList->titre?>
	    			</span>
		    	</h1>
		    	<div class="img">
		    		<a class="lienTitre" href="<?= $itemList->url ?>"><img src="<?php echo $itemList->img ?>" /></a>
	    		</div>
	    		<div class="infoList">
		    		<span class="url">
		    				<a class="lienTitre" target="_blank" href="<?= $itemList->url ?>"><?php echo $itemList->url ?></a>
		    		</span>
		    		<p><?php echo $itemList->description ?></p>
		    		<p class="date clearfix"><?= relative_time($itemList->date); ?></p>
		    		<?php if($this->session->userdata('logged') && $itemList->bool ):  ?>
		    		<span>
			    		<?= anchor('status/voir/' . $itemList->id . '/','Modifier', 
		    					array('title'=> 'Modification du post' .' ' . $itemList->id . ' - ' . $itemList->titre  ,'class' => 'button modify icon-edit')); ?>
			    		<?= anchor('status/supprimer/' . $itemList->id . '/','Supprimer', 
		            			array('title'=> 'Delete the link number ' .  $itemList->id,'class' => 'button delete icon-trash','id' => $itemList->id )); ?>
		    		</span>	
		    			<?php endif; ?>
	    		</div>
	    		<span class="clearfix">&nbsp;</span>
	    	</div>
	    <?php endforeach; ?>
	  </section>
</div>