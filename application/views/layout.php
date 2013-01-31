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
				<span class="compte">Welcome <?php echo $this->session->userdata('name') ?> </span>
				<span class="icon-logout"><?= anchor('status/logout/','Sign out', 
			            			array('title'=> 'deconnection')); ?></span>
			    <a href="javascript:void()" id="outilsAjouter">plus</a>
			    <a href="javascript:void()" id="outilsSupprimer">moin</a>
				<?php else: ?>
				<span>
					<?= anchor('status/inscription/','Inscription', 
			            			array('title'=> 'inscription')); ?>
			    </span>
				<span class="icon-login">
					<?= anchor('status/inscription/','Connexion', 
			            			array('title'=> 'Connexion')); ?>
			    </span>
			    <?php endif; ?>
			</div>
		</div>
	</div>
	<?= $vue ?>
	<footer class="clearfix">
		&nbsp;
	</footer>
	<script src="<?= base_url() ?>web/js/jquery.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>web/js/script.js" type="text/javascript"></script>
</body>
</html>