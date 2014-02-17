generateDummyContent();

/*********************************************************/
/* SET UP NAVIGATION (mouse+touch)                       */
/*********************************************************/
	var container = document.querySelector(".container");

	document.addEventListener("click",onInput,false);
	document.addEventListener("touchend",onInput,false);

	function onInput(e){
		if ( e.target.id.indexOf("link") > -1 ) {
			var p = e.target.id.substr(4);
			container.style.webkitTransform = "translate3d(-"+p+"00%,0,0)";
			e.preventDefault();
		}
	}

/*********************************************************/
/* GENERATE DUMMY CONTENT AND NAVIGATION LINKS           */
/*********************************************************/

function generateDummyContent() {
	// just some Bacon Ipsum
	var bacon  = "<p>Bacon ipsum dolor sit amet capicola tenderloin sausage, ham pig pork belly tri-tip short loin bacon corned beef salami ground round kielbasa. Capicola frankfurter doner, bacon shankle short loin tail short ribs ham hock biltong turkey. Cow turkey prosciutto jerky meatloaf bresaola sausage chicken short loin tongue ball tip. Ball tip chuck shoulder, turkey short loin jerky hamburger sirloin biltong corned beef frankfurter t-bone. Ham hock strip steak venison ribeye ground round turkey turducken. Shoulder ribeye boudin flank, jowl chicken shank tri-tip drumstick. Boudin pork loin tail beef ribs, ham pancetta ribeye andouille pork tri-tip venison.</p><p>Short loin t-bone kielbasa salami brisket ball tip, jowl beef ribs meatball rump. Chuck shoulder jerky flank bacon turducken pork loin kielbasa ham hock short ribs pancetta pork belly. Spare ribs pig andouille, prosciutto venison t-bone shank ham hock biltong pork loin ball tip leberkas short ribs. Rump leberkas frankfurter ham hock chuck swine. Jowl bacon pastrami frankfurter spare ribs short loin turkey. Salami drumstick flank, turducken sirloin doner tenderloin venison swine kielbasa ham ribeye. Tenderloin doner beef ribs, spare ribs prosciutto leberkas shoulder pork loin pig kielbasa short ribs strip steak bresaola boudin.</p><p>Bacon ribeye corned beef shankle spare ribs biltong short loin hamburger pastrami andouille meatball. Turkey bacon prosciutto tail short loin corned beef bresaola ham hock cow shankle strip steak pork chop fatback spare ribs andouille. Kielbasa beef ribs cow, salami jerky shank short loin pork belly meatloaf ground round jowl chicken. Ball tip bresaola venison leberkas turducken swine prosciutto pancetta. Filet mignon biltong prosciutto ground round meatloaf beef ribs. Ball tip venison sirloin shankle, bacon shoulder meatloaf doner brisket biltong drumstick hamburger turkey andouille.</p>";

	// collect al pages, and add content and navigation menu
	var pages = document.querySelectorAll(".page-insider"),
		n = pages.length;
	[].forEach.call(pages,function(e,i){
		var html = '';
		if ( i > 0 ) 
			html += '<a href="#" id="link'+(i-1)+'" class="prevLink"> to previous page</a>';
		if ( i < n-1 ) 
			html += '<a href="#" id="link'+(i+1)+'" class="nextLink"> to next page</a>';
		html += '<h1>This is page ' + (i) + '</h1>';
		e.innerHTML = html + bacon;
	});
}