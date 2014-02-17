$(document).ready(function(){
	$( "#datepicker" ).datepicker();
	$('#ui-datepicker-div').appendTo('.calendar');


	function mainPrice(){
		/*$('.personalCount')*/
		$.ajax({
			url: "checkCurrentPrice.php",
			success: function(html){
		    	console.log(html);
		    	$('.personalCount').html(html+" €");
			}
		});
	}
	mainPrice();



	var panelX = 0;

	function menuPanel(){
		$('.startX').css({'opacity':'0'}, function(e){ $(this).css({'display':'none'}); });
	}

	function nextPanel(){
		panelX++;
		if(panelX < 1){ panelX = 0 }
		else if(panelX > 0){
			$('.startX').css({'opacity':'0'}, function(e){ $(this).css({'display':'none'}); });
		}
		var prepreviousPanel = '.panel'+(panelX-2);
		var previousPanel = '.panel'+(panelX-1);
		var currentPanel = '.panel'+panelX;
		$(prepreviousPanel).removeClass('bl-hide-current-work');
		$(previousPanel).removeClass('bl-show-work').addClass('bl-hide-current-work');
		$(currentPanel).addClass('bl-show-work');
	}
	function ajaxPost(){
		var addListe = $('.addListeForm select').val();
		var addName = $('#addName').val();
		var addMontant = $('#addMontant').val();
		var datepicker = $('#datepicker').val();
		var addNote = $('#addNote').val();
		console.log('FinalSend');
		console.log(addListe);
		console.log(addName);
		console.log(addMontant);
		console.log(datepicker);
		console.log(addNote);
		$.ajax({
		    url: "functions.php",
		    type: "POST",
		    data: { addListe:addListe, addName:addName, addMontant:addMontant, datepicker:datepicker, addNote:addNote },
		    success: function(html) {
		    	/*console.log(html);*/
		    	nextPanel();
		    	mainPrice();
		    	$('.onMeDoit .panel6 .success').html("Cette dette a bien été enregistrée");
		    }
		});
	}




	$('.startX').click(function(e){
		if ( $(this).hasClass("noClick") ) {
			e.preventDefault; // No spam clic during the animations
		} else {
			var elem = $(this);
			$(this).addClass("noClick");
			setTimeout(function() {
				elem.removeClass("noClick"); 
			}, 500);
			$('.addChoice').addClass( 'bl-show-work' );
			nextPanel();
		}
	});
	$('.nextStep').click(function(e){
		if ( $(this).hasClass("noClick") ) {
			e.preventDefault; // No spam clic during the animations
		} else {
			var elem = $(this);
			$(this).addClass("noClick");
			setTimeout(function() {
				elem.removeClass("noClick"); 
			}, 500);
			$('.addChoice').addClass( 'bl-show-work' );
			nextPanel();
		}
	})
	/*Hammer($('.startX')).on("tap",function(){
		$('#panel1').addClass( 'bl-show-work' );
		nextPanel();
	});*/
	
	

	$('.back').click(function(e){
		var thisPanel = $(this).parent().removeClass('bl-show-work').attr('class').substr(5,1);
		console.log(thisPanel);
		$('.panel'+(thisPanel-1)).removeClass('bl-hide-current-work').addClass('bl-show-work');
		$('.panel'+(thisPanel-2)).addClass('bl-hide-current-work');
		if((thisPanel-1) < -1){ thisPanel = 0 };
		panelX = thisPanel-1;
		if(panelX == 0){ $('.startX').css({'opacity':'1'}); }
	});

	
	$('.bl-panel-items form').on('submit', function(e){
		e.preventDefault();
		var addListe = $('#addListe').val();
		var addListeSelected = $('.addListeForm select').val();
		var addName = $('#addName').val();
		var addMontant = $('#addMontant').val();
		var datepicker = $('#datepicker').val();
		var addNote = $('#addNote').val();

		if($(this).hasClass('addNameForm')){
			console.log('addListe: '+addListeSelected);
			$.ajax({
			    url: "checkName.php",
			    type: "POST",
			    data: { addListe:addListeSelected, addName:addName },
			    success: function(html) {
			    	if(html == 'ok'){
			    		$('.addNameForm .error').html('');
			    		nextPanel();
			    	} else {
			    		$('.addNameForm .error').html(html);
			    	}
			    }
			});
		} else if($(this).hasClass('addListeForm')){
			$.ajax({
				url: "checkListe.php",
				type: "POST",
				data: { addListe:addListe },
				success: function(html){
					if(html == 'ok'){
			    		$('.addListeForm .error').html('');
			    		$('.addListeForm select').append('<option value="'+addListe+'" selected >'+addListe+'</option>');
			    		$(".addListeForm select").val(addListe);
			    	} else {
			    		$('.addListeForm .error').html(html);
			    	}
				}
			});
		} else {
			nextPanel();	
		}
		$('.onMeDoit .recap').html("<table><tr><td>Liste</td><td>"+addListeSelected+"</td></tr><tr><td>Prenom</td><td>"+addName+"</td><tr><td>Montant</td><td>"+addMontant+"</td><tr><td>Date Échéance</td><td>"+datepicker+"</td><tr><td>Note</td><td>"+addNote+"</td></table>");
	});


	$('.panel6 button').click(function(){
		ajaxPost();
	});
	$('.btBackStart').click(function(){
		$('.panel6').removeClass('bl-hide-current-work');
		$('.panel7').addClass('bl-hide-current-work').removeClass('bl-show-work').delay(200).removeClass('bl-hide-current-work');
		$('.startX').css({'opacity':'1'}, function(e){ $(this).css({'display':'block'}); });
		panelX = 0;
	});






	/*$('.menu').click(function(e){
		if(($this).hasClass('opened')){
			$(this).removeClass('opened');	
		} else {
			$(this).addClass('opened');
		}	
	});*/

});