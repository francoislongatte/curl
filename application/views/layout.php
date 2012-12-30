<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?= $titre ?></title>
	<link href="<?= base_url() ?>web/css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body id="liste">
	<div id="topBarre">
		<div id="title">	
			<h1 id="titre"><a href="<?= base_url() ?>"><?= $titre ?></a></h1>
			<div id="boiteCompte">
				<?php if($this->session->userdata('logged')): ?>
				<span>Bienvenue <?php echo $this->session->userdata('name') ?> </span>
				<span><?= anchor('status/logout/','Deconnection', 
			            			array('title'=> 'deconnection')); ?></span>
			    <a href="javascript:void()" id="outilsAjouter">plus</a>
			    <a href="javascript:void()" id="outilsSupprimer">moin</a>
				<?php else: ?>
				<span>
					<?= anchor('status/inscription/','Inscription', 
			            			array('title'=> 'inscription')); ?>
			    </span>
				<span>
					Connection
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
						<?= form_submit(array('class' => 'bouton'), 'Connection') ?>
					</div>
					
					
				    <?= form_fieldset_close() ?>
				    <?= form_close() ?>
				    
			    </span>
			    <?php endif; ?>
			</div>
		</div>
	</div>
	<?= $vue ?>
	<script src="<?= base_url() ?>web/js/jquery.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>web/js/script.js" type="text/javascript"></script>
</body>
</html>