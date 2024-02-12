<?php

//Mensagens do sistema
$lang['email_must_be_array'] = "The email validation method must be passed an array.";
$lang['email_invalid_address'] = "Endereço de email inválido: %s";
$lang['email_attachment_missing'] = "Não foi possível encontrar o ficheiro anexo: %s";
$lang['email_attachment_unreadable'] = "Impossível abrir o ficheiro anexo: %s";
$lang['email_no_recipients'] = "Deve incluir destinatários: Para, Cc, or Bcc";
$lang['email_send_failure_phpmail'] = "Unable to send email using PHP mail().  Your server might not be configured to send mail using this method.";
$lang['email_send_failure_sendmail'] = "Unable to send email using PHP Sendmail.  Your server might not be configured to send mail using this method.";
$lang['email_send_failure_smtp'] = "Não é possível enviar o email utilizando PHP SMTP.  O servidor poderá não estar configurado para enviar emails utilizando este método.";
$lang['email_sent'] = "A sua mensagem foi enviada com sucesso, utilizando o seguinte protocolo: %s";
$lang['email_no_socket'] = "Unable to open a socket to Sendmail. Please check settings.";
$lang['email_no_hostname'] = "Não especificou o nome do servidor SMTP.";
$lang['email_smtp_error'] = "Foi encontrado o seguinte erro SMTP: %s";
$lang['email_no_smtp_unpw'] = "ERRO: Deve identificar um utilizador e password para acesso ao servidor SMTP.";
$lang['email_failed_smtp_login'] = "Falha no envio do comando AUTH LOGIN. Erro: %s";
$lang['email_smtp_auth_un'] = "Falha ao autenticar username. Erro: %s";
$lang['email_smtp_auth_pw'] = "Falha ao autenticar password. Erro: %s";
$lang['email_smtp_data_failure'] = "Não é possível enviar os dados: %s";
$lang['email_exit_status'] = "Código de estado (Exit status code): %s";

/* End of file email_lang.php */
/* Location: ./system/language/english/email_lang.php */