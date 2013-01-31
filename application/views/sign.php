
<div id="containerContent">
	<div id="infoConnexion">
		<h2>Connexion</h2>
		<?= form_open('status/login',
									array(
										'method' => 'post',
										'id' => 'formConnection'
									)); ?>
					<?= form_fieldset('', array('id' => 'content')); ?>
				    <?= form_input(array(
				              'name'        => 'email',
				              'id'          => 'email',
				              'placeholder' => 'Votre email',
				              'class' => 'champ'
				            )); ?>
				    <?= form_password(array(
				              'name'        => 'mdp',
				              'id'          => 'mdp',
				              'placeholder' => 'Mot de passe',
				              'class' => 'champ'
				            )); ?>	
				    <?= form_fieldset_close() ?>
				    <?php if(isset($erreur)): ?>
				    	<div id="erreurUrl">
				    		<?= $erreur ?>
				    	</div>
				    <?php endif; ?>
					<div class="formBottom">
						<?= form_reset(array('class' => 'bouton'), 'annuler') ?>
						<?= form_submit(array('class' => 'bouton'), 'Connection') ?>
					</div>
					
				    <?= form_fieldset_close() ?>
				    <?= form_close() ?>
				    <span><a class="button" href="<?= base_url() ?>">Retour au mur</a></span>
	</div>
	<?= form_open('status/inscrire',
									array(
										'method' => 'post',
										'id' => 'formInscription'
									)); ?>
					<h2>Inscription</h2>
					
					<p id="remarque">Tous les champs sont obligatoires</p>
					
					<?= form_fieldset('', array('id' => 'content')); ?>
					
				    <?= form_label('Votre nom', 'nom'); ?>
				    <?php if(isset($nError)){ echo'<p class="error">' . $nError . '</p>'; } ?>
				    <?= form_input(array(
				              'name'        => 'nom',
				              'id'          => 'nom',
				              'class' => 'champ',
				            )); ?>	
				    
				    <?= form_label('Email', 'emailIns'); ?>
				    <?php if(isset($eError)){ echo'<p class="error">' . $eError . '</p>'; } ?>
				    <?= form_input(array(
				              'name'        => 'emailIns',
				              'id'          => 'emailIns',
				              'class' => 'champ',
				            )); ?>
				    <?= form_label('Mot de passe', 'mdpIns'); ?>
				    <?php if(isset($mError)){ echo'<p class="error">' . $mError . '</p>'; } ?>
				    <?= form_password(array(
				              'name'        => 'mdpIns',
				              'id'          => 'mdpIns',
				              'class' => 'champ',
				            )); ?>	
				    <?= form_label('Recopiez Mot de passe', 'mdpReco'); ?>
				    <?php  if(isset($remError)){ echo'<p class="error">' . $remError . '</p>'; } ?>
				    <?= form_password(array(
				              'name'        => 'mdpReco',
				              'id'          => 'mdpReco',
				              'class' => 'champ',
				            )); ?>	       
				    <img id="loader" alt="ajax-loader" src="http://localhost:8888/curl//web/images/ajax-loader.gif">
				    <?= form_fieldset_close() ?>
				    
				    <?php if(isset($erreur)): ?>
				    	<div id="erreurUrl">
				    		<?= $erreur ?>
				    	</div>
				    <?php endif; ?>
					<div class="formBottom">
						<?= form_reset(array('class' => 'bouton'), 'annuler') ?>
						<?= form_submit(array('class' => 'bouton'), 'Inscription') ?>
					</div>
					<img id="loader" alt="ajax-loader" src="http://localhost:8888/curl//web/images/ajax-loader.gif">
				    <?= form_fieldset_close() ?>
				    <?= form_close() ?>
				    
</div>