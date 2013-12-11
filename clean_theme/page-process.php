<?php
/** Make sure that the WordPress bootstrap has run before continuing. */
require_once( ABSPATH . 'wp-load.php');
date_default_timezone_set('Brazil/East');
$action = $_REQUEST['action'];
$errors = new WP_Error();

/*##### TODO #####*/
/*Verificar se está sempre logado, evitar acesso ao process usuários externos.*/

switch ($action){
	case 'login':
		$arr = array('ok' => 'ok', 'msg' => 'senha ok', 'redirect' => site_url('/trabalhe-conosco') );
		echo json_encode($arr);
		break;
	case 'trabalhe_conosco':
		$arr = array('ok' => 'ok', 'msg' => 'Enviado com sucesso', 'redirect' => site_url('/trabalhe-conosco') );
		echo json_encode($arr);
		break;
	default:
		header('Location:'.  site_url());
}

?>