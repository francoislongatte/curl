
<div id="containerContent">
	<?= form_open('status/inscrire',
									array(
										'method' => 'post',
										'id' => 'formInscription'
									)); ?>
					<?= form_fieldset('', array('id' => 'content')); ?>
				    <?= form_label('Votre nom', 'nom'); ?>
				    <?php if(!isset($nom)){ echo'<p class="error">' . $nError . '</p>'; } ?>
				    <?= form_input(array(
				              'name'        => 'nom',
				              'id'          => 'nom',
				              'class' => 'champ',
				            )); ?>	
				    
				    <?= form_label('Email', 'email'); ?>
				    <?php if(!isset($email)){ echo'<p class="error">' . $eError . '</p>'; } ?>
				    <?= form_input(array(
				              'name'        => 'email',
				              'id'          => 'email',
				              'class' => 'champ',
				            )); ?>
				    <?= form_label('Mot de passe', 'mdp'); ?>
				    <?php if(!isset($mdp)){ echo'<p class="error">' . $mError . '</p>'; } ?>
				    <?= form_password(array(
				              'name'        => 'mdp',
				              'id'          => 'mdp',
				              'class' => 'champ',
				            )); ?>	
				    <?= form_label('Recopiez Mot de passe', 'mdpReco'); ?>
				    <?php  if(isset($remError)){ echo'<p class="error">' . $remError . '</p>'; } ?>
				    <?= form_password(array(
				              'name'        => 'mdpReco',
				              'id'          => 'mdpReco',
				              'class' => 'champ',
				            )); ?>	       
				    <p id="remarque">Tous les champs sont obligatoires</p>
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
					
				    <?= form_fieldset_close() ?>
				    <?= form_close() ?>
	<div id="infoInscription">
		<p> Bienvenue sur la page d'inscription </p>
		<p> Vous allez bientôt vous inscrire sur une plateforme de post en tout genre </p>
		<p> Petite regle : vous ne pouvez que modifiez vos liens .</p>
		<p id="return">
			<a href="<?= base_url() ?>">Retour au site</a>
		</p>
	</div>
</div>