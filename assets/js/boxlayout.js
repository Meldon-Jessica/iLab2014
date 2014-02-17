/**
 * boxlayout.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
var Boxlayout = (function() {

	var $el = $( '#bl-main' ),
		$sections = $el.children( 'section' ),
		// works section
		$sectionWork = $( '#bl-work-section' ),
		// work items
		$workItems = $( '#bl-work-items > li' ),
		// work panels
		$workPanelsContainer = $( '#bl-panel-work-items' ),
		$workPanels = $workPanelsContainer.children( 'div' ),
		totalWorkPanels = $workPanels.length,
		// navigating the work panels
		$nextWorkItem = $workPanelsContainer.find( 'nav > span.bl-next-work' ),
		// if currently navigating the work items
		isAnimating = false,
		// close work panel trigger
		$closeWorkItem = $workPanelsContainer.find( 'nav > span.bl-icon-close' ),
		transEndEventNames = {
			'WebkitTransition' : 'webkitTransitionEnd',
			'MozTransition' : 'transitionend',
			'OTransition' : 'oTransitionEnd',
			'msTransition' : 'MSTransitionEnd',
			'transition' : 'transitionend'
		},
		// transition end event name
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		// support css transitions
		supportTransitions = Modernizr.csstransitions;
	var panelX = 1;

	function init() {

		initEvents();
	}

	

	function initEvents() {
		
		function nextPanel(){
			var currentPanel = '.panel'+panelX;
			$(currentPanel).addClass('bl-show-work');
			panelX++;
		}
		
		$('#panel1').addClass( 'bl-show-work' );
		$('.startX').click(function(){
			nextPanel();
		});
		$('.bl-panel-items form').on('submit', function(e){
			e.preventDefault();
			if($('.bl-panel-items form').hasClass('addNameForm')){
				console.log('C\'est bien addNameForm');
			} else {
				console.log('Ce n\'est pas addNameForm');
				nextPanel();	
			}
			
		});
		// navigating the work items: current work panel scales down and the next work panel slides up
		$nextWorkItem.on( 'click', function( event ) {
			
			if( isAnimating ) {
				return false;
			}
			isAnimating = true;

			var $currentPanel = $workPanels.eq( currentWorkPanel );
			currentWorkPanel = currentWorkPanel < totalWorkPanels - 1 ? currentWorkPanel + 1 : 0;
			var $nextPanel = $workPanels.eq( currentWorkPanel );

			$currentPanel.removeClass( 'bl-show-work' ).addClass( 'bl-hide-current-work' ).on( transEndEventName, function( event ) {
				if( !$( event.target ).is( 'div' ) ) return false;
				$( this ).off( transEndEventName ).removeClass( 'bl-hide-current-work' );
				isAnimating = false;
			} );

			if( !supportTransitions ) {
				$currentPanel.removeClass( 'bl-hide-current-work' );
				isAnimating = false;
			}
			
			$nextPanel.addClass( 'bl-show-work' );

			return false;

		} );

		// clicking the work panels close button: the current work panel slides down and the section scales up again
		$closeWorkItem.on( 'click', function( event ) {

			// scale up main section
			$sectionWork.removeClass( 'bl-scale-down' );
			$workPanelsContainer.removeClass( 'bl-panel-items-show' );
			$workPanels.eq( currentWorkPanel ).removeClass( 'bl-show-work' );
			
			return false;

		} );

	}

	return { init : init };

})();