<?

/*
  |--------------------------------------------------------------------------
  | Password
  |--------------------------------------------------------------------------
  | Constantes usadas pelo método de encriptação de password (Helper - password_helper)
 */

$config['password.algoritmo_encriptacao'] = /** «password_algoritmo» * */
    PASSWORD_BCRYPT/** «/password_algoritmo» * */
;
$config['password.salt'] = /** «password_salt» * */
    random_bytes(22)/** «/password_salt» * */
;

$config['config.website_em_manutencao'] = false; //Email onde vai receber os emails do form de contacto do site
$config['config.popup_generica_informacao'] = false;