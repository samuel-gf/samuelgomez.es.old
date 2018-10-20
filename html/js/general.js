$( document ).ready(function() {
    $("#nav-toggle").click(function(){
		$("#sidebar section#info").fadeToggle("fast");
		$("#sidebar section#menu").toggle("medium");
	});	
});
