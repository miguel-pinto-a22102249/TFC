<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
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


$route['default_controller'] = "admin/logins/index";
$route['404_override'] = 'error404';

$route['admin/home_admin'] = 'admin/home';
$route['home_admin'] = 'admin/home';
$route['dashboard'] = 'admin/home';
$route[''] = 'admin/logins/index';
$route['/'] = 'admin/logins/index';
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
$route['admin/utilizadores/viewEditar/(:num)'] = 'admin/logins/viewEditar/$1';

$route['admin/utilizadores/consultar/(:num)'] = 'admin/logins/viewEditar/$1/1';
$route['admin/gravar-alteracoes/(:any)'] = 'admin/logins/editarPost/$1';

$route['admin/utilizadores/ativaModoPrivacidade'] = 'admin/logins/ativaModoPrivacidade';
$route['admin/utilizadores/desativaModoPrivacidade'] = 'admin/logins/desativaModoPrivacidade';


/* * ********************************************* */

/* * ****************** Escalão ********************* */
$route['admin/escaloes'] = 'admin/escaloes/listar';
$route['admin/escaloes/adicionar'] = 'admin/escaloes/adicionar';
$route['admin/escaloes/editar/(:num)'] = 'admin/escaloes/editar/$1';
$route['admin/escaloes/consultar/(:num)'] = 'admin/escaloes/viewEditar/$1/1';
$route['admin/escaloes/viewEditar/(:num)'] = 'admin/escaloes/viewEditar/$1';

$route['admin/escaloes/eliminar/(:num)'] = 'admin/escaloes/eliminar/$1';
/* * ********************************************************** */

/* * ****************** Entidades Distribuidoras ********************* */
$route['admin/entidadesDistribuidoras'] = 'admin/entidades_distribuidoras/listar';
$route['admin/entidadesDistribuidoras/adicionar'] = 'admin/entidades_distribuidoras/adicionar';
$route['admin/entidadesDistribuidoras/editar/(:num)'] = 'admin/entidades_distribuidoras/editar/$1';
$route['admin/entidadesDistribuidoras/consultar/(:num)'] = 'admin/entidades_distribuidoras/viewEditar/$1/1';
$route['admin/entidadesDistribuidoras/viewEditar/(:num)'] = 'admin/entidades_distribuidoras/viewEditar/$1';

$route['admin/entidadesDistribuidoras/eliminar/(:num)'] = 'admin/entidades_distribuidoras/eliminar/$1';
/* * ************************************************************** */

/* * ****************** Produtos ********************* */
$route['admin/produtos'] = 'admin/produtos/listar';
$route['admin/produtos/adicionar'] = 'admin/produtos/adicionar';
$route['admin/produtos/editar/(:num)'] = 'admin/produtos/editar/$1';
$route['admin/produtos/consultar/(:num)'] = 'admin/produtos/viewEditar/$1/1';
$route['admin/produtos/viewEditar/(:num)'] = 'admin/produtos/viewEditar/$1';
$route['admin/produtos/eliminar/(:num)'] = 'admin/produtos/eliminar/$1';
/* * ********************************************************** */

/* * ****************** Agregados ********************* */
$route['admin/agregados'] = 'admin/agregados/listar';
$route['admin/agregados/adicionar'] = 'admin/agregados/adicionar';
$route['admin/agregados/editar/(:num)'] = 'admin/agregados/editar/$1';
$route['admin/agregados/viewEditarAgregado/(:num)'] = 'admin/agregados/viewEditarAgregado/$1';
$route['admin/agregados/consultarAgregado/(:num)'] = 'admin/agregados/viewEditarAgregado/$1/1';
$route['admin/agregados/eliminar/(:num)'] = 'admin/agregados/eliminar/$1';

$route['admin/agregados/constituintes/listar'] = 'admin/agregados/listarConstituintes';
$route['admin/agregados/constituintes/adicionar'] = 'admin/agregados/adicionarConstituinte';
$route['admin/agregados/constituintes/editar/(:num)'] = 'admin/agregados/editarConstituinte/$1';
$route['admin/agregados/constituintes/viewEditarConstituinte/(:num)'] = 'admin/agregados/viewEditarConstituinte/$1';
$route['admin/agregados/constituintes/consultarConstituinte/(:num)'] = 'admin/agregados/viewEditarConstituinte/$1/1';;
$route['admin/agregados/constituintes/(:num)'] = 'admin/agregados/constituintes/$1';
$route['admin/agregados/constituintes/eliminar/(:num)'] = 'admin/agregados/eliminarConstituinte/$1';

$route['admin/agregados/importacao'] = 'admin/agregados/importacao';
$route['admin/agregados/importacao'] = 'admin/agregados/importacao';
$route['admin/agregados/guardarImportacao'] = 'admin/agregados/guardarImportacao';
/* * ********************************************************** */

/* * ****************** Distribuições ********************* */
$route['admin/distribuicoes/'] = 'admin/distribuicoes/listar';

$route['admin/distruibuicoes/listarPorConstituinte/(:num)'] = 'admin/distribuicoes/listarPorConstituinte/$1';
$route['admin/distruibuicoes/listarPorAgregado/(:num)'] = 'admin/distribuicoes/listarPorAgregado/$1';
//$route['admin/distribuicoes/constituinte'] = 'admin/distribuicoes/listarPorConstituinte';
//$route['admin/distribuicoes/agregado'] = 'admin/distribuicoes/listarPorAgregado';
$route['admin/distribuicoes/distribuicaoPasso1'] = 'admin/distribuicoes/distribuicaoPasso1';
$route['admin/distribuicoes/distribuicaoPasso2'] = 'admin/distribuicoes/distribuicaoPasso2';
$route['admin/distribuicoes/distribuicaoPasso3'] = 'admin/distribuicoes/distribuicaoPasso3';
/* * ********************************************************** */

/* * ****************** Credenciais ********************* */
$route['admin/credenciais/gerarCredencialA/(:num)'] = 'admin/credenciais/gerarCredencialA/$1';
$route['admin/credenciais/gravarCredencial/(:num)'] = 'admin/credenciais/gravarCredencials/$1';
/* * ********************************************************** */

/* * ********************** GENERICO ************************** */

$route['admin/backup-bd'] = 'admin/generico/AJAXbackupBD';
$route['admin/gera-sitemap'] = 'admin/generico/geraSiteMapAJAX';
$route['admin/configuracoes'] = 'admin/configuracoes/consultarConfigs';
$route['admin/configuracoes/gravar'] = 'admin/configuracoes/gravarConfigs';

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
