(function($) { /*variable pour ajax*/
	var index = 0;
	var number = 0;
	/*----------------------------------------------*/
	
	
	function replace(nombre){
		number = nombre;
	}
	
	
	/*--------fonction pour le slide---------*/
	function slide(){
		$(".choixImage").hide();
		$(".choixImage:first-child").show();
		$("#next").on('click', suiv);
		$("#previous").on('click', prec); 
	}
	
	function suiv(e) {
		if (index >= 0 && index < number) {
			$(".choixImage:visible").hide().children('input').removeAttr('checked').parent().next().show().children('input').attr('checked', 'checked');
			index++;
		}
	}

	function prec(e) {
		if (index > 0 && index <= number) {
			$(".choixImage:visible").hide().children('input').removeAttr('checked').parent().prev().show().children('input').attr('checked', 'checked');
			index--;
		}
	} /*----------------------------------------*/
	
	function createFormulaireChoisir(lienImg,url){
		var form = '<form action="'+ url + 'status/ajouter " method="post" id="formAjoutAjax"></form>';
		var fieldset = '<fieldset class="ajaxCase"></fieldset>';
		var ul = '<ul> </ul>';
		
		var label = '<label></label>';
		var lienImgString = lienImg.toString();
		var tabLienImage = lienImgString.split(',');
		var previous = '<button type="button" id="previous">precedent</button>';
		var next = '<button type="button" id="next">suivant</button>';
		
		$('#containerContent').prepend(form).children('#formAjoutAjax').css('display', 'none').append(fieldset).children('.ajaxCase').append(ul);
		
		replace(tabLienImage.length);
		for (i = 0; i < tabLienImage.length ; i++){			
			var li = '<li class="choixImage">' + '<input type="radio" name="SelectImg" value=" ' +  tabLienImage[i]  + '" class="inputJs" >'  + '<label>' + '<img src="'+ tabLienImage[i] + '" >' +   '</label>'  +   '</li>';
			
			$('ul').append(li);
		}
		
		$('.ajaxCase').append(previous).append(next);
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
		var inputReset = '<input type="reset" value="annuler" class="boutonSubmit">';
		var inputSubmit = '<input type="submit" value="envoyer" class="boutonSubmit">';
		$('.ajaxCase').append(div).children('.formBottom').append(inputReset,inputSubmit);
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
						$('#formAjoutAjax').on('submit', ajoutPost);
						$("#loader").hide();
						$('#erreurUrl').hide();
					}else{
						var error = '<div id="erreurUrl">' + 'Url incorrecte' + '</div>';
						$("#loader").hide();
						$('#myForm #content').after(error);
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
					ajouterUnPost(msg);
					$('#formAjoutAjax').slideUp();
					$('.champ').attr('value' , '');
					$('#myForm').slideDown();
					$('.modify').on('click', formModif);
				}
			});
	}
	
	function ajouterUnPost(data){
		console.log(data);
		var containerList = '<div class="containerList ' + data.idPost+'"></div>';
		var img = '<img src="'+ data.img + '">';
		var h1 = '<h1> ' + data.titre + '</h1>';
		var h2 = '<h2><a class="lienTitre" href="' + data.url + '">' + data.url + '</a></h2>';
		var p = '<p>' + data.description + '</p>';
		var date = '<p class="date">' + data.date + '</p>';
		var aDelete = '<a id="' + data.idPost + '" class="button delete" title="Delete the link number '+ data.idPost + '" href="' + data.urlpage + 'status/supprimer/' + data.idPost + '">Supprimer</a>';
		var aMotif = '<a class="button modify" title="Modification du post ' + data.idPost + ' - ' + data.titre + '" href="' + data.urlpage  + 'status/voir/' + data.idPost + '">Modifier</a>';
		
		$('.header-List').after(containerList);
		$('.containerList').first().css('display', 'none').append(img,h1,h2,p,date,aDelete,aMotif);
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
					$(e.target).parent().slideUp();
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
		var h1 = $('.' + id).children('h1').html();
		var des = $('.' + id).children('p:not(.date)').html();
		console.log($('.' + id).children('a:not(.delete)').html());
		if( $('.' + id).children('a:not(.delete)').html() == 'Modifier' ){
			$('.' + id).children('a.modify').text('Valider').removeClass().addClass('button valider');
			$('.' + id).children('p:not(.date)').html('<textarea class="des" type="text" rows="20" cols="100%" >'+des+'</textarea>');
			$('.' + id).children('h1').html('<input class="titre" type="text" size="100%" value="'+ h1 +'">');
		}else if ( $('.' + id).children('a:not(.delete)').html() == 'Valider'){
			validForm(id);
			
		}
	}
	function validForm(id){
		var id = id;
		var titre = $('input.titre').val();
		var description = $('textarea.des').val();
		$.ajax({
			type: "POST",
			url: 'status/modifier',
			data: { titre:titre , des:description , id:id },
			dataType: "json",
			success: function(msg) {
				$('.' + id).children('a.valider').text('Modifier').removeClass().addClass('button modify');
				$('.' + id).children('p:not(.date)').html(msg.description);
				$('.' + id).children('h1').html( msg.titre );
			},
			error: function(msg){
				$('.' + id).children('a.valider').hide();
				$('.' + id).children('p:not(.date)').html('<p>'+ 'il y a une erreur (Reactualiser pour reafficher l ancien contentu)' +'</p>');
				$('.' + id).children('h1').html('<h1></1>');
			}
		});
		
	}
	$(function() { 
		$('#outilsSupprimer').fadeIn(1500).on('click', hiddenForm);
		$('#outilsAjouter').fadeIn(1500).on('click', visibleForm).hide();
		$('#myForm').on('submit', formAjaxChoisir); 
		$('.delete').on('click', fDelete);
		$('.modify').on('click', formModif);
		
	});
}(jQuery));
