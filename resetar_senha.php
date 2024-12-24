<?php
	$to = $_POST['usuario'];
	$origem = "fabian.viegas@institutoivoti.com.br";
	$subject = "Altera&ccedil;&atilde;o de senha - Atletix";
	$message = "Ol&aacute;, tubo bem?<p>".
				"Voc&ecirc; esqueceu sua senha. N&atilde;o se preocupe, iremos lhe ajudar.<br>".
				"Acesse o sistema novamente e informe a senha <p><h2><b>@TL3T1x_</b></h2><br>".
				"Voc&ecirc; ser&aacute; direcionado para uma p&aacute;gina de altera&ccedil;&atilde;o de senha.<p>".
				"Abra&ccedil;o,<br>".
				"Equipe de TI - Atletix";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Equipe TI - Atletix <$origem>';
	$enviaremail = mail($to, $subject, $message, $headers);

	if ($enviaremail) {
		echo "Foi...";
	} else {
		echo "Não foi...";
	}
	
//	header("Location: index.html"); */
?>