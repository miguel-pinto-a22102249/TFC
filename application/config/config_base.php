<?

/*
  |--------------------------------------------------------------------------
  | Password
  |--------------------------------------------------------------------------
  | Constantes usadas pelo método de encriptação de password (Helper - password_helper)
 */

//website@amccweb.com / McGlCtSfwP2a
$config['password.algoritmo_encriptacao'] = /** «password_algoritmo» * */ PASSWORD_BCRYPT /** «/password_algoritmo» * */;
$config['password.salt'] = /** «password_salt» * */ random_bytes(22) /** «/password_salt» * */;

$config['email.protocol'] = "smtp";
$config['email.smtp_user'] = "no-reply@ecpp.pt";
$config['email.smtp_pass'] = "xmswbphIMH2S";
$config['email.smtp_crypto'] = "ssl";
$config['email.smtp_host'] = "mail.ecpp.pt";
$config['email.smtp_port'] = "465";
$config['email.mailtype'] = 'html';
$config['email.charset'] = 'utf-8';
$config['email.newline'] = "\r\n";
$config['email.wordwrap'] = TRUE;

$config['email.rececao.form.contacto'] = "info@ecpp.pt"; //Email onde vai receber os emails do form de contacto do site


$config['config.website_em_manutencao'] = FALSE; //Email onde vai receber os emails do form de contacto do site
$config['config.popup_generica_informacao'] = FALSE;