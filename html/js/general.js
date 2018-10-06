$( document ).ready(function() {
    $("#nav-toggle").click(function(){
		$("#sidebar section#info").fadeToggle("slow");
		$("#sidebar section#menu").toggle("medium");
	});
});
