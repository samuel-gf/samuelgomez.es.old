<script>
	function enviaFormulario(){
		if ($("#mensaje").val() == ""){
			alert("Error: Debes escribir algo en el formulario");
		} else if ($("#emailremitente").val() == ""){
			alert("Error: Debes poner tu dirección para que pueda responderte");
		} else if (!validateEmail($("#emailremitente").val())){
			alert("Error: Tu dirección de correo está mal escrita");
		} else {
			$.ajax({
				url: 'rq/mailtomaster.php',
				method: 'post',
				data:{
					'msg': $("#mensaje").val(),
					'replyto': $("#emailremitente").val()
				}
			})
			.done(function (){alert("Enviado correctamente");})
			.fail(function (){alert("Error en envio");});
		}
	}

	function validateEmail(email) {
    	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(String(email).toLowerCase());
	}
</script>

<article>
	<h1>Contacto con el autor del sitio web</h1>
	<form id="contacto">
		<br/>
		<input type="email" id="emailremitente" placeholder="Tu email" required />
		<textarea id="mensaje" placeholder="Mensaje"></textarea>
		<input type="button" value="Enviar" onclick="javascript:enviaFormulario();" />
	</form>
</article>
