$( document ).ready(function() {
    $("#nav-toggle").click(function(){
		$("#sidebar section#info").toggle(500);
		$("#sidebar section#menu").toggle(500);
	});
});
