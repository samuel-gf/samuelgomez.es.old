<?php
	mail("info@samuelgomez.es", "Desde el blog ".date('d/m/Y'), $_POST['msg'], 'Reply-To: '.$_POST['replyto']."\r\n");
