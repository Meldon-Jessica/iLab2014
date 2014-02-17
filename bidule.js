// Snippets Hammer
	// Opacités & Transform n'impactent pas les perf.

function toggleReveal(){
	$('.reveal').toggleClass('visible');
	$('.main').toggleClass('fixedItem');
};

Hammer($('.showReveal')).on("tap",function(e){
	console.log(e);
	toggleReveal();
});

Hammer($('.hideReveal')).on("tap",function(e){
	console.log(e);
	toggleReveal();
});

Hammer($('.bidule')).on("swipe",function(e){
	console.log(e);
	
});