(function($) { /*variable pour ajax*/
	var index = 0;
	var number = 0;
	/*----------------------------------------------*/
	
	function replace(nombre){
		number = nombre;
	}
	
	
	/*--------fonction pour le slide---------*/
	function slide(){
		var image = $(".choixImage");
		image.hide();
		$(".choixImage:first-child").show();
		$("#next").on('click', suiv);
		$("#previous").on('click', prec); 
		number = image.length;
	}
	
	function suiv(e) {
		if (index >= 0 && index < number-2) {
			$(".choixImage:visible").hide().children('input').removeAttr('checked').parent().next().show().children('input').attr('checked', 'checked');
			index++;
		}
	}

	function prec(e) {
		if (index > 0 && index <= number-1) {
			$(".choixImage:visible").hide().children('input').removeAttr('checked').parent().prev().show().children('input').attr('checked', 'checked');
			index--;
		}
	} /*----------------------------------------*/
	
	function createFormulaireChoisir(lienImg,url){
		var form = '<form action="'+ url + 'status/ajouter " method="post" id="formAjoutAjax"></form>';
		var fieldset = '<fieldset class="ajaxCase"></fieldset>';
		var ul = '<ul> </ul>';
		var wrapul = '<div class="imgWrap"></div>'
		var label = '<label></label>';
		var lienImgString = lienImg.toString();
		var tabLienImage = lienImgString.split(',');
		var wraplien = '<div class="warplien"></div>';
		var previous = '<span class="suivant icon-left-open"><button class="button" type="button" id="previous">precedent</button></span>';
		var next = '<span class="precedent icon-right-open"><button class="button" type="button" id="next">suivant</button></span>';
		
		$('#containerContent').prepend(form).children('#formAjoutAjax').css('display', 'none').append(fieldset).children('.ajaxCase').append(wrapul).children('.imgWrap').append(ul);
		
		replace(tabLienImage.length);
		for (i = 0; i < tabLienImage.length ; i++){			
			var li = '<li class="choixImage">' + '<input type="radio" name="SelectImg" value=" ' +  tabLienImage[i]  + '" class="inputJs" >'  + '<label>' + '<img src="'+ tabLienImage[i] + '" >' +   '</label>'  +   '</li>';
			
			$('ul').append(li);
		}
		
		$('.imgWrap').append(wraplien).children('.warplien').append(previous).append(next);
	}
	
	function divContentCurl(data){
		var contentCurl = '<div class="contentCurl"></div>';
		var h2 = '<h2>' + data.titles + '</h2>';
		var inputHiddenTitre = '<input type="hidden" name="titre" value="' + data.titles + '">';
		var address = '<address>'+ data.url +'</address>';
		var inputHiddenUrl = '<input type="hidden" name="url" value="'+ data.url  +'">';
		var p = '<p>' + data.description + '</p>';
		var inputHiddenDescription = '<input type="hidden" name="description" value="'+ data.description  +'">';
		$('.ajaxCase').append(contentCurl).children('.contentCurl').append(h2,inputHiddenTitre,address,inputHiddenUrl,p,inputHiddenDescription);
	}
	function formBottomSubmit(){
		var div = '<div class="formBottom"></div>';
		var inputReset = '<span class="icon-cancel"><input type="reset" value="annuler" class="bouton"></span>';
		var inputSubmit = '<span class="icon-ok"><input type="submit" value="envoyer" class="bouton"></span>';
		$('.contentCurl').append(div).children('.formBottom').append(inputReset,inputSubmit);
	}
	function formAjaxChoisir(e){
		$("#loader").show();
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: 'status/choisir',
				data: $("#myForm").serialize(),
				dataType: "json",
				success: function(msg) {
					if(msg.state == "ok"){
						createFormulaireChoisir(msg.lienImg,msg.urlpage);
						
						divContentCurl(msg);
						formBottomSubmit();
						$('#myForm').hide();
						$('#formAjoutAjax').slideDown();
						slide();
						$('.inputJs').hide().first().attr('checked', 'checked');
						$('#formAjoutAjax').on('submit', ajoutPost);
						$("#loader").hide();
						$('#erreurUrl').hide();
					}else{
						var error = '<div class="erreurUrl">' + 'Url incorrecte' + '</div>';
						$("#loader").hide();
						$('#myForm #content').before(error);
					}
					
				}
			});
	}
	
	function ajoutPost(e){
		e.preventDefault();
		$.ajax({
				type: "POST",
				url: 'status/ajouter',
				data: $("#formAjoutAjax").serialize(),
				dataType: "json",
				success: function(msg) {
					console.log(msg);
					ajouterUnPost(msg);
					$('#formAjoutAjax').slideUp();
					$('.champ').attr('value' , '');
					$('#myForm').slideDown();
					$('.modify').on('click', formModif);
				}
			});
	}
	
	function ajouterUnPost(data){
		
		var containerList = '<div class="containerList ' + data.idPost+'"></div>';
		var img = '<div class="img"><a class="lienTitre" href="' + data.urlpage + '"><img src="'+ data.img + '"></a></div>';
		var infoList = '<div class="infoList"></div>';
		var h1 = '<h1><span> ' + data.titre + '</span></h1>';
		var spanlien = '<span class="url"><a class="lienTitre" href="' + data.url + '">' + data.url + '</a></span>';
		var p = '<p>' + data.description + '</p>';
		var date = '<p class="date clearfix">' + data.date + '</p>';
		var spanButton = '<span class="btn"></span>';
		var aDelete = '<a id="' + data.idPost + '" class="button delete icon-trash" title="Delete the link number '+ data.idPost + '" href="' + data.urlpage + 'status/supprimer/' + data.idPost + '">Supprimer</a>';
		var aMotif = '<a class="button modify icon-edit" title="Modification du post ' + data.idPost + ' - ' + data.titre + '" href="' + data.urlpage  + 'status/voir/' + data.idPost + '">Modifier</a>';
		
		$('#timeline').prepend(containerList);
		$('.containerList').first().css('display', 'none').append(h1,img,infoList).children('.infoList').append(spanlien,p,date,spanButton).children('.btn').append(aMotif,aDelete);
		
		$('.containerList').first().slideDown();
	}
	function fDelete(e){
		e.preventDefault();
		var urlCourante = e.target.href;
		var tabId = urlCourante.split('/');
		var number = tabId.length;
		var id = tabId[number-1];
		var url = '';
		for (var i = 0 ; i < tabId.length-1 ; i++){
			url += tabId[i] + '/';
		}
		
		$.ajax({
				type: "POST",
				url: url,
				data: { id : id },
				dataType: "json",
				success: function(msg) {
					$(e.target).parent().parent().parent().slideUp();
				}
			});
	}
	
	function visibleForm(e){
		e.preventDefault();
		$('#myForm').slideDown();
		$('#outilsSupprimer').fadeIn();
		$('#outilsAjouter').fadeOut();
	}
	
	function hiddenForm(e){
		e.preventDefault();
		$('#myForm').slideUp();
		$('#outilsAjouter').fadeIn();
		$('#outilsSupprimer').fadeOut();
	}
	function formModif(e){
		e.preventDefault();
		var urlCourante = e.target.href;
		var tabId = urlCourante.split('/');
		var number = tabId.length;
		var id = tabId[number-1];
		var balise = $('.' + id);
		var infoList = balise.children('.infoList');
		var infoListSpan = infoList.children('span:not(.url)');
		var h1 = balise.children('h1').children('span').html();
		var des = infoList.children('p:not(.date)').html();
		if( infoListSpan.children('a:not(.delete)').html() == 'Modifier' ){
		infoListSpan.children('a.modify').text('Valider').removeClass().addClass('button valider icon-ok');
			infoList.children('p:not(.date)').html('<textarea class="des" type="text" rows="20" cols="100%" >'+des+'</textarea>');
			balise.children('h1').children('span').html('<input class="titre" type="text" size="100%" value="'+ h1 +'">');
		}else if ( infoListSpan.children('a:not(.delete)').html() == 'Valider'){
			validForm(id);
		}
	}
	function validForm(id){
		var id = id;
		var titre = $('input.titre').val();
		var description = $('textarea.des').val();
		var balise = $('.' + id);
		var infoList = balise.children('.infoList');
		var infoListSpan = infoList.children('span:not(.url)');
		$.ajax({
			type: "POST",
			url: 'status/modifier',
			data: { titre:titre , des:description , id:id },
			dataType: "json",
			success: function(msg) {
				
				infoListSpan.children('a.valider').text('Modifier').removeClass().addClass('button modify');
				infoList.children('p:not(.date)').html(msg.description);
				balise.children('h1').children('span').html( msg.titre );
			},
			error: function(msg){
				$('.' + id).children('a.valider').hide();
				$('.' + id).children('p:not(.date)').html('<p>'+ 'il y a une erreur (Reactualiser pour reafficher l ancien contentu)' +'</p>');
				$('.' + id).children('h1').html('<h1></1>');
			}
		});
		
	}
	function validFormInscrip(e) {
		e.preventDefault();
		var loader = $('#loader');
		var nom = $('#nom');
		var nomVal = $.trim(nom.val());
		var ErrorNom = "<span class='error' >Ce champ est obligatoire</span>";
		var email = $('#emailIns');
		var emailVal = $.trim(email.val());
		var ErrorEmail = "<span class='error' >Verifiez votre email</span>";
		var mdp = $('#mdpIns');
		var mdpVal = $.trim(mdp.val());
		var ErrorMdp = "<span class='error' >Ce champ est obligatoire</span>";
		var mdpReco = $('#mdpReco');
		var mdpRecoVal = $.trim(mdpReco.val());
		var ErrorMdpReco = "<span class='error' >Ce champ doit correspondre au champ 'Mot de passe'</span>";
		var inscriptSuccess = "<div id='success'>Inscription réussie</div>";
		
		if (nomVal === '') {
			if (nom.prev('span').size() < 1) {
				nom.before(ErrorNom);
			}
		} else {
				nom.prev('span').remove();
		}
		
		if (validEmail(emailVal) === false) {
			if (email.prev('span').size() < 1) {
				email.before(ErrorEmail);
			}
		} else {
				email.prev('span').remove();
		}
		
		if (mdpVal === '') {
			if (mdp.prev('span').size() < 1) {
				mdp.before(ErrorMdp);
			} 
		}else {
				mdp.prev('span').remove();
		}
		if(mdpRecoVal !== mdpVal){
			if (mdpReco.prev('span').size() < 1) {
				mdpReco.before(ErrorMdpReco);
			}
		}else{
				mdpReco.prev('span').remove();
		}
		
		if (nomVal!=='' && validEmail(emailVal)===true && mdpVal!=='' && mdpRecoVal === mdpVal) {
			loader.fadeIn();
			$.ajax({
				type: "POST",
				url: 'inscrire',
				data: $("#formInscription").serialize(),
				dataType: "json",
				success: function(msg) {
					if(msg['check']){
						window.location = msg['redirect'];
					}else{
						var ErrorEmail = "<span class='error' >Cette email est déja enregistrer</span>";
						if (email.prev('span').size() < 1) {
							email.before(ErrorEmail);
						}
					}
					loader.fadeOut();
				},
				error: function(er) {
				}
			});
		}
	}
	function validEmail(email) {
		var verif = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return verif.test(email);
	}
	$(function() { 
		$('#outilsSupprimer').fadeIn(1500).on('click', hiddenForm);
		$('#outilsAjouter').fadeIn(1500).on('click', visibleForm).hide();
		$('#myForm').on('submit', formAjaxChoisir); 
		$('.reset').on('click',function(){
							$('.erreurUrl').fadeOut();
							
						});
		$('#formInscription').on('submit',validFormInscrip);
		$('.delete').on('click', fDelete);
		$('.modify').on('click', formModif);
		var loader = $('#loader').hide();
	});
}(jQuery));

