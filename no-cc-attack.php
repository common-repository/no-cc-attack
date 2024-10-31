<?php
/*

**************************************************************************

Plugin Name:  No CC Attack
Plugin URI:   http://www.arefly.com/no-cc-attack/
Description:  Protect your blog from CC Attack! The plugin will check the refresh times of a visitors. If it is too quick, the visitor will be redirect to a custom URL.
Version:      1.0
Author:       Arefly
Author URI:   http://www.arefly.com/
Text Domain:  no-cc-attack
Domain Path:  /lang/

**************************************************************************

	Copyright 2014  Arefly  (email : eflyjason@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**************************************************************************/

define("NO_CC_ATTACK_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("NO_CC_ATTACK_FULL_DIR", plugin_dir_path( __FILE__ ));
define("NO_CC_ATTACK_TEXT_DOMAIN", "no-cc-attack");

/* Plugin Localize */
function no_cc_attack_load_plugin_textdomain() {
	load_plugin_textdomain(NO_CC_ATTACK_TEXT_DOMAIN, false, dirname(plugin_basename( __FILE__ )).'/lang/');
}
add_action('plugins_loaded', 'no_cc_attack_load_plugin_textdomain');

include_once NO_CC_ATTACK_FULL_DIR."options.php";

/* Add Links to Plugins Management Page */
function no_cc_attack_action_links($links){
	$links[] = '<a href="'.get_admin_url(null, 'options-general.php?page='.NO_CC_ATTACK_TEXT_DOMAIN.'-options').'">'.__("Settings", NO_CC_ATTACK_TEXT_DOMAIN).'</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'no_cc_attack_action_links');

function no_cc_attack_register_session() {
	if(!session_id()){
		session_start();
	}
}
add_action('init', 'no_cc_attack_register_session');

function no_cc_attack() {
	$ll_nowtime = time();
	$ll_lasttime = $_SESSION['ll_lasttime'] ? $_SESSION['ll_lasttime'] : $ll_nowtime;
	$ll_times = $_SESSION['ll_times'] ? $_SESSION['ll_times'] + 1 : 1;
	$_SESSION['ll_lasttime'] = $ll_lasttime;
	$_SESSION['ll_times'] = $ll_times;

	if(($ll_nowtime - $ll_lasttime) < get_option('no_cc_attack_second')){
		if($ll_times >= get_option('no_cc_attack_time')){
			$ll_times = 0;
			$_SESSION['ll_lasttime'] = $ll_nowtime;
			$_SESSION['ll_times'] = $ll_times;
			wp_redirect(get_option('no_cc_attack_redirect_url'));
			exit;
		}
	}else{
		$ll_times = 0;
		$_SESSION['ll_lasttime'] = $ll_nowtime;
		$_SESSION['ll_times'] = $ll_times;
	}
}
add_action('template_redirect', 'no_cc_attack');