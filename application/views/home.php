<?php $this->load->helper('time_helper'); ?>
<div id="containerContent">
    <?php if($this->session->userdata('logged')): ?>
    <?= form_open('status/choisir',
					array(
						'method' => 'post',
						'id' => 'myForm'
					)); ?>
	<?= form_fieldset('', array('id' => 'content')); ?>
    <?= form_input(array(
              'name'        => 'champ',
              'id'          => 'champ',
              'placeholder' => 'Put your link, Here !',
              'class' => 'champ'
            )); ?>	
    <?= form_fieldset_close() ?>
    <?php if(isset($erreur)): ?>
    	<div id="erreurUrl">
    		<?= $erreur ?>
    	</div>
    <?php endif; ?>
    <img id="loader" src="<?= base_url() ?>/web/images/ajax-loader.gif" alt="ajax-loader" />
	<div class="formBottom">
		<?= form_reset(array('class' => 'bouton'), 'Reset') ?>
		<?= form_submit(array('class' => 'bouton'), 'Submit') ?>
	</div>
	
	
    <?= form_fieldset_close() ?>
    <?= form_close() ?>
    <? endif; ?>
	  <section id="timeline">
	  		<div class="header-List">
		      <h2>Link</h2>
		    </div>
	  <?php foreach($list as $itemList): ?>
	    	<div class="containerList <?php echo $itemList->id ?>">
	    		<img src="<?php echo $itemList->img ?>" />
	    		<h1><?php echo $itemList->titre?></h1>
	    		<h2><a class="lienTitre" href="<?= $itemList->url ?>"><?php echo $itemList->url ?></a></h2>
	    		<p><?php echo $itemList->description ?></p>
	    		<p class="date clearfix"><?= relative_time($itemList->date); ?></p>
	    		<?php if($this->session->userdata('logged') && $itemList->bool ):  ?>
	    		<?= anchor('status/supprimer/' . $itemList->id . '/','Supprimer', 
            			array('title'=> 'Delete the link number ' .  $itemList->id,'class' => 'button delete','id' => $itemList->id )); ?>
    			<?= anchor('status/voir/' . $itemList->id . '/','Modifier', 
    					array('title'=> 'Modification du post' .' ' . $itemList->id . ' - ' . $itemList->titre  ,'class' => 'button modify')); ?>
    			<?php endif; ?>
	    	</div>
	    <?php endforeach; ?>
	    	<div class="footer-List">
		        
		    </div>
	  </section>
</div>