<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */


$route['default_controller'] = "admin/home";
$route['404_override'] = 'error404';

$route['admin/home_admin'] = 'admin/home';
$route['home_admin'] = 'admin/home';
$route['admin'] = 'admin/home';
$route['default-style'] = 'site/testes';

// <editor-fold defaultstate="collapsed" desc="Routes ADMIN">

/* * ****************** LOGIN ********************* */
$route['admin/login'] = 'admin/logins/login';
$route['admin'] = 'admin/logins/index';
$route['login-admin'] = 'admin/logins/index';

$route['admin/logout'] = 'admin/logins/logout';
$route['admin /logout'] = 'admin/logins/logout';

$route['admin/resetPassword'] = 'admin/logins/resetPassword';
$route['resetPassword'] = 'admin/logins/resetPassword';
/* * ********************************************* */


/* * ****************** Utilizadores ********************* */
$route['admin/utilizadores'] = 'admin/logins/listarUtilizadores';

$route['admin/utilizadores/adicionar'] = 'admin/logins/criar';
$route['admin/utilizadores/eliminar/(:num)'] = 'admin/logins/eliminar/$1';
$route['admin/utilizadores/editar/(:num)'] = 'admin/logins/editar/$1';

$route['admin/utilizador/consultar/(:any)'] = 'admin/logins/consultar/$1';
$route['admin/gravar-alteracoes/(:any)'] = 'admin/logins/editarPost/$1';
/* * ********************************************* */

/* * ****************** Escalão ********************* */
$route['admin/escaloes'] = 'admin/escaloes/listarEscaloes';



/* * ********************** GENERICO ************************** */

$route['admin/backup-bd'] = 'admin/generico/AJAXbackupBD';
$route['admin/gera-sitemap'] = 'admin/generico/geraSiteMapAJAX';

/* * ********************************************************** */

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Routes site">
$route['admin/utilizador/consultar/(:any)'] = 'admin/logins/consultar/$1';
// </editor-fold>


/* * ********************** LOGS ************************** */

$route['admin/logs'] = 'admin/logs/listaLogs';

/*     * ********************************************************** */

/* End of file routes.php */
/* Location: ./application/config/routes.php */
