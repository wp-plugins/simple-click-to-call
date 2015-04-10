<?php
/*
Plugin Name: Simple Click To Call
Plugin URI: http://www.revisionalpha.com/simple-click-to-call/
Description: Sistema para contactarse con un agente del sitio
Version: 0.2
Author: revision alpha
Author URI: http://www.revisionalpha.com
License: GPL2
*/


global $revisionalpha_simpleclicktocall_version;
$revisionalpha_simpleclicktocall_version = '0.2';


register_activation_hook(__FILE__, 'revisionalpha_simpleclicktocall_activate');
register_deactivation_hook(__FILE__, 'revisionalpha_simpleclicktocall_deactivate');

add_action( 'init', 'simpleclicktocall_init_method' );
add_action( 'admin_menu', 'register_simpleclicktocall_menu_page' );
add_action( 'wp_enqueue_scripts', 'simpleclicktocall_scripts_and_styles' );

add_action( 'wp_ajax_nopriv_revisionalpha_simpleclicktocall_ajax_callback', 'revisionalpha_simpleclicktocall_ajax_callback' );
add_action( 'wp_ajax_revisionalpha_simpleclicktocall_ajax_callback', 'revisionalpha_simpleclicktocall_ajax_callback' );

function revisionalpha_simpleclicktocall_ajax_callback()
{
	$url = 'http://crm.profcallcenter.com.ar/click-to-call.php';

	$post['key'] = get_option('revisionalpha_simpleclicktocall_key');
	$post['agente'] = get_option('revisionalpha_simpleclicktocall_agente');
	
	$_POST['simple-click-to-call-codigo-pais'] = (!empty($_POST['simple-click-to-call-codigo-pais'])) ? $_POST['simple-click-to-call-codigo-pais'] : NULL; // HARDCODED
	$post['telefono'] = (int) $_POST['simple-click-to-call-codigo-pais'] . (int) $_POST['simple-click-to-call-codigo-area'] . (int) $_POST['simple-click-to-call-numero'];
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$data = curl_exec($ch);
	curl_close($ch);
	
	echo json_encode($data);
	
	exit;
}


/* ACTIVACION */
function revisionalpha_simpleclicktocall_activate()
{
	global $revisionalpha_simpleclicktocall_version;
	
	if (get_option('revisionalpha_simpleclicktocall_version') != $revisionalpha_simpleclicktocall_version)
	{
		update_option('revisionalpha_simpleclicktocall_version', $revisionalpha_simpleclicktocall_version);
	}
	
	add_option( 'revisionalpha_simpleclicktocall_key', '' );
	add_option( 'revisionalpha_simpleclicktocall_agente', '' );
	add_option( 'revisionalpha_simpleclicktocall_estado', 0 );
	add_option( 'revisionalpha_simpleclicktocall_options', '' );
	add_option( 'revisionalpha_simpleclicktocall_form_settings', '' );
	
	$options_default = array();
	
	$options_default['simple-click-to-call-mostrar'] = 'todos-los-dias';
	$options_default['simple-click-to-call-dias'] = array( 1, 2, 3, 4, 5, 6, 0 );
	$options_default['simple-click-to-call-hora-inicio'] = '00:00';
	$options_default['simple-click-to-call-hora-final'] = '23:59';
	$options_default['simple-click-to-call-mensaje-fuera-de-rango'] = 'El horario de atenci&oacute;n ha finalizado.';
	
	add_option( 'revisionalpha_simpleclicktocall_options_default', $options_default );
	
	$form_settings_default = array();
	
	$form_settings_default['simple-click-to-call-description'] = 'Ingrese su n&uacute;mero de tel&eacute;fono.';
	
	$form_settings_default['simple-click-to-call-codigo-pais-text'] = 'Pa&iacute;s';
	$form_settings_default['simple-click-to-call-codigo-pais-default'] = '';
	$form_settings_default['simple-click-to-call-codigo-pais-placeholder'] = 1;
	$form_settings_default['simple-click-to-call-codigo-pais-mostrar'] = 0;
	
	$form_settings_default['simple-click-to-call-codigo-area-text'] = '&Aacute;rea';
	$form_settings_default['simple-click-to-call-codigo-area-default'] = '11';
	$form_settings_default['simple-click-to-call-codigo-area-placeholder'] = 1;
	
	$form_settings_default['simple-click-to-call-numero-text'] = 'N&uacute;mero';
	$form_settings_default['simple-click-to-call-numero-placeholder'] = 1;
	
	$form_settings_default['simple-click-to-call-submit-text'] = 'Click To Call';
	
	$form_settings_default['simple-click-to-call-message-error'] = 'Verifique el c&oacute;digo de &aacute;rea y el n&uacute;mero de tel&eacute;fono ingresado.';
	$form_settings_default['simple-click-to-call-message-wait'] = 'Estableciendo comunicaci&oacute;n...';
	$form_settings_default['simple-click-to-call-message-comunicacion-error'] = 'Nuestros asesores no se encuentran disponibles en este momento.';
	$form_settings_default['simple-click-to-call-message-comunicacion-ok'] = 'Comunicaci&oacute;n establecida.';
	
	add_option( 'revisionalpha_simpleclicktocall_form_settings_default', $form_settings_default );
}


function revisionalpha_simpleclicktocall_deactivate()
{
	
}


function register_simpleclicktocall_menu_page()
{
	// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page(__('Simple Click To Call', 'revisionalpha_simpleclicktocall'), __('Click To Call', 'revisionalpha_simpleclicktocall'), 'manage_options', $parent_slug = plugin_dir_path( __FILE__ ) . 'app/simple-click-to-call.php', '', 'dashicons-phone', 33);
	
	// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	add_submenu_page($parent_slug, __('Simple Click To Call', 'revisionalpha_simpleclicktocall'), __('General', 'revisionalpha_simpleclicktocall'), 'manage_options', plugin_dir_path( __FILE__ ) . 'app/simple-click-to-call.php');
	add_submenu_page($parent_slug, __('Ajustes Simple Click To Call', 'revisionalpha_simpleclicktocall'), __('Ajustes', 'revisionalpha_simpleclicktocall'), 'manage_options', plugin_dir_path( __FILE__ ) . 'app/simple-click-to-call-settings.php');
	add_submenu_page($parent_slug, __('Personalizar Simple Click To Call', 'revisionalpha_simpleclicktocall'), __('Personalizar', 'revisionalpha_simpleclicktocall'), 'manage_options', plugin_dir_path( __FILE__ ) . 'app/simple-click-to-call-customize.php');	
}


function simpleclicktocall_scripts_and_styles()
{
    if ( get_option('revisionalpha_simpleclicktocall_form_settings') )
	{
		$form_settings = get_option('revisionalpha_simpleclicktocall_form_settings');
	}
	else
	{
		$form_settings = get_option('revisionalpha_simpleclicktocall_form_settings_default');
	}
    
    wp_register_script( 'jquery-validate', plugins_url( '/js/jquery.validate.min.js', __FILE__ ), array( 'jquery' ), '1.13.1' );
    wp_enqueue_script( 'jquery-validate' );
    
    wp_register_script( 'simple-click-to-call-ajax-submit', plugins_url( '/js/simple-click-to-call-ajax-submit.js', __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'simple-click-to-call-ajax-submit' );
    wp_localize_script( 'simple-click-to-call-ajax-submit', 'options', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'message_error' => $form_settings['simple-click-to-call-message-error'], 'message_wait' => $form_settings['simple-click-to-call-message-wait'], 'message_comunicacion_ok' => $form_settings['simple-click-to-call-message-comunicacion-ok'], 'message_comunicacion_error' => $form_settings['simple-click-to-call-message-comunicacion-error'] ) );
    
    wp_register_style( 'simple-click-to-call-styles', plugins_url( '/css/simple-click-to-call-styles.css', __FILE__ ), array(), '', 'all' );
    wp_enqueue_style( 'simple-click-to-call-styles' );
}


/* INIT */
function simpleclicktocall_init_method()
{
	load_plugin_textdomain('revisionalpha_simpleclicktocall', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


/* SHORTCODES */
include( plugin_dir_path( __FILE__ ) . 'php/simple-click-to-call-shortcodes.php' );

